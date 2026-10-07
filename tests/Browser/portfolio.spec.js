import { test, expect } from '@playwright/test';

const pages = ['/', '/about', '/services', '/products', '/products/nexa', '/contact'];

for (const width of [1440, 768, 390, 320]) {
  test(`all pages work at ${width}px`, async ({ page }) => {
    await page.setViewportSize({ width, height: 1000 });
    const failures = [];
    page.on('pageerror', error => failures.push(error.message));
    page.on('response', response => {
      if (response.status() >= 400) failures.push(`${response.status()} ${response.url()}`);
    });

    for (const path of pages) {
      await page.goto(path);
      await expect(page.locator('h1')).toBeVisible();
      await expect(page).toHaveTitle(/Nexus Qart/);
      if (path === '/products/nexa') {
        await page.emulateMedia({ reducedMotion: 'reduce' });
        await page.screenshot({ path: `.qa/nexa-${width}.png`, fullPage: true });
      }
      expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth)).toBe(true);
      expect(await page.locator('img').evaluateAll(images => images.every(image => image.complete && image.naturalWidth > 0))).toBe(true);
    }

    expect(failures).toEqual([]);
    await page.goto('/');
    await page.screenshot({ path: `.qa/home-${width}.png`, fullPage: true });
  });
}

test('mobile navigation opens, escapes, and follows links', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto('/');
  const toggle = page.getByRole('button', { name: 'Menu', exact: true });
  await toggle.click();
  await expect(toggle).toHaveAttribute('aria-expanded', 'true');
  await expect(page.getByRole('navigation', { name: 'Mobile navigation' })).toBeVisible();
  await page.keyboard.press('Escape');
  await expect(toggle).toHaveAttribute('aria-expanded', 'false');
  await expect(toggle).toBeFocused();
  await toggle.click();
  await page.getByRole('navigation', { name: 'Mobile navigation' }).getByRole('link', { name: 'About', exact: true }).click();
  await expect(page).toHaveURL(/\/about$/);
});

test('product, contact and keyboard paths work', async ({ page }) => {
  await page.goto('/');
  await page.keyboard.press('Tab');
  await expect(page.getByRole('link', { name: 'Skip to content' })).toBeFocused();
  await page.getByRole('link', { name: 'Discover Nexa' }).click();
  await page.getByText('Where do I sign in?', { exact: true }).click();
  await expect(page.locator('.faqs details').first()).toHaveAttribute('open', '');
  await expect(page.getByRole('link', { name: 'Open Nexa login' })).toHaveAttribute('href', 'https://getwooperly.com/login');
  await page.getByRole('link', { name: 'Ask about Nexa' }).click();
  await expect(page.getByRole('link', { name: 'Start an email' })).toHaveAttribute('href', /mailto:.*subject=.*Nexa%20QR%20Menu/);
});

test('local links resolve and scripts are optional', async ({ page, request, browser }) => {
  const paths = new Set();
  for (const path of pages) {
    await page.goto(path);
    for (const href of await page.locator('a[href]').evaluateAll(links => links.map(link => link.href))) {
      if (href.startsWith('http://127.0.0.1:4174')) paths.add(href.split('#')[0]);
    }
  }
  for (const href of paths) expect((await request.get(href)).ok()).toBe(true);

  const context = await browser.newContext({ javaScriptEnabled: false, viewport: { width: 390, height: 844 }, reducedMotion: 'reduce' });
  const fallback = await context.newPage();
  await fallback.goto('http://127.0.0.1:4174/');
  await expect(fallback.getByRole('navigation', { name: 'Page navigation' })).toBeVisible();
  await context.close();
});


test('scroll animations reveal content and respect reduced motion', async ({ page }) => {
  await page.emulateMedia({ reducedMotion: 'no-preference' });
  await page.goto('/');
  const card = page.locator('.service-row').first();
  await card.scrollIntoViewIfNeeded();
  await expect(card).toHaveCSS('opacity', '1');
  const nextLink = page.getByRole('link', { name: 'Start a conversation' });
  await nextLink.focus();
  await expect(page.locator('.cta-panel')).toHaveCSS('opacity', '1');
  await page.emulateMedia({ reducedMotion: 'reduce' });
  await expect(page.locator('.reveal-ready')).toHaveCount(0);
  await expect(page.locator('.art-core')).toHaveCSS('animation-name', 'none');
});

test('mobile drawer overlays the page, traps focus and closes cleanly', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.goto('/about');
  const headingTop = await page.locator('h1').evaluate(el => el.getBoundingClientRect().top);
  const toggle = page.getByRole('button', { name: 'Menu', exact: true });
  const drawer = page.getByRole('dialog', { name: 'Site navigation' });
  await toggle.click();
  await expect(drawer).toBeVisible();
  await expect(drawer.getByRole('button', { name: 'Close menu' })).toBeFocused();
  await expect(drawer.getByRole('link', { name: 'About', exact: true })).toHaveAttribute('aria-current', 'page');
  expect(await page.locator('h1').evaluate(el => el.getBoundingClientRect().top)).toBe(headingTop);
  await expect(page.locator('html')).toHaveCSS('overflow', 'hidden');
  await page.keyboard.press('Shift+Tab');
  await expect(drawer.getByRole('link', { name: 'Start a project' })).toBeFocused();
  await page.keyboard.press('Tab');
  await expect(drawer.getByRole('button', { name: 'Close menu' })).toBeFocused();
  await page.screenshot({ path: '.qa/mobile-drawer.png' });
  await page.mouse.click(10, 300);
  await expect(drawer).not.toBeVisible();
  await expect(toggle).toBeFocused();
  await expect(page.locator('html')).not.toHaveCSS('overflow', 'hidden');
  await toggle.click();
  await drawer.getByRole('button', { name: 'Close menu' }).click();
  await expect(drawer).not.toBeVisible();
  await page.emulateMedia({ reducedMotion: 'reduce' });
  await toggle.click();
  await expect(page.locator('.drawer-panel')).toHaveCSS('animation-name', 'none');
  await drawer.getByRole('link', { name: 'Services', exact: true }).click();
  await expect(page).toHaveURL(/\/services$/);
  await toggle.click();
  await page.setViewportSize({ width: 1200, height: 900 });
  await expect(drawer).not.toBeVisible();
  await expect(page.locator('html')).not.toHaveCSS('overflow', 'hidden');
});

test('drawer entry does not trigger horizontal focus scrolling', async ({ page }) => {
  await page.setViewportSize({ width: 390, height: 844 });
  await page.emulateMedia({ reducedMotion: 'no-preference' });
  await page.goto('/about');
  const frames = await page.evaluate(async () => {
    const dialog = document.querySelector('#mobile-menu');
    const panel = dialog.querySelector('.drawer-panel');
    document.querySelector('.menu-toggle').click();
    const samples = [];
    for (let frame = 0; frame < 25; frame++) {
      await new Promise(requestAnimationFrame);
      samples.push({ scroll: dialog.scrollLeft, x: panel.getBoundingClientRect().x });
    }
    return samples;
  });
  expect(frames.every(frame => frame.scroll === 0)).toBe(true);
  for (let index = 1; index < frames.length; index++) {
    expect(frames[index].x).toBeLessThanOrEqual(frames[index - 1].x + 1);
  }
  await expect(page.getByRole('button', { name: 'Close menu' })).toBeFocused();
});
