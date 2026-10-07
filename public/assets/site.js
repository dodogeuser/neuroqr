const toggle = document.querySelector('.menu-toggle');
const drawer = document.querySelector('#mobile-menu');

if (toggle && drawer && typeof drawer.showModal === 'function') {
  toggle.hidden = false;
  let closeTimer;
  const closeMenu = (immediate = false) => {
    if (!drawer.open) return;
    clearTimeout(closeTimer);
    const finish = () => drawer.close();
    if (immediate || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
      finish();
    } else {
      drawer.classList.add('is-closing');
      closeTimer = setTimeout(finish, 200);
    }
  };

  toggle.addEventListener('click', () => {
    clearTimeout(closeTimer);
    drawer.classList.remove('is-closing');
    document.documentElement.classList.add('drawer-open');
    drawer.showModal();
    toggle.setAttribute('aria-expanded', 'true');
    drawer.querySelector('.drawer-close').focus({ preventScroll: true });
  });
  drawer.querySelector('.drawer-close').addEventListener('click', () => closeMenu());
  drawer.addEventListener('keydown', event => {
    if (event.key !== 'Tab') return;
    const controls = [...drawer.querySelectorAll('button, a[href]')];
    const first = controls[0];
    const last = controls[controls.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });
  drawer.addEventListener('cancel', event => {
    event.preventDefault();
    closeMenu();
  });
  drawer.addEventListener('click', event => {
    if (event.target === drawer) closeMenu();
    if (event.target.closest('a')) closeMenu(true);
  });
  drawer.addEventListener('close', () => {
    clearTimeout(closeTimer);
    drawer.classList.remove('is-closing');
    document.documentElement.classList.remove('drawer-open');
    toggle.setAttribute('aria-expanded', 'false');
    if (window.matchMedia('(max-width: 800px)').matches) toggle.focus();
  });
  window.matchMedia('(min-width: 801px)').addEventListener('change', event => {
    if (event.matches && drawer.open) {
      closeMenu(true);
      document.querySelector('.header-inner .brand').focus();
    }
  });
  window.addEventListener('pagehide', () => closeMenu(true));
}

// Progressive enhancement: reveal only off-screen content, once per visit.
const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
let revealObserver;
const stopReveals = () => {
  revealObserver?.disconnect();
  document.querySelectorAll('.reveal-ready').forEach(element => {
    element.classList.remove('reveal-ready');
    element.classList.add('is-visible');
  });
};

if ('IntersectionObserver' in window && !motionPreference.matches) {
  revealObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.08 });

  document.querySelectorAll('.section-heading, .service-row, .value-card, .nexa-plan, .studio-intro > div, .work-showcase, .cta-panel').forEach(element => {
    if (element.getBoundingClientRect().top >= window.innerHeight) {
      element.classList.add('reveal-ready');
      revealObserver.observe(element);
    }
  });

  // Keyboard navigation must never land on visually hidden content.
  document.addEventListener('focusin', event => {
    const section = event.target.closest('.reveal-ready');
    if (section) {
      section.classList.add('is-visible');
      revealObserver.unobserve(section);
    }
  });
}

motionPreference.addEventListener('change', event => {
  if (event.matches) stopReveals();
});
