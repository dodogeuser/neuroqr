<x-layout title="Nexa — Digital menus, catalogues & AI" description="Nexa by Nexus Qart combines QR menus, digital catalogues, brand customization, search and AI assistance. Manage multiple companies from one account.">
  <section class="container product-feature-grid product-hero">
    <div>
      <a class="back-link" href="{{ route('products') }}">← All products</a>
      <p class="eyebrow">NEXA BY NEXUS QART</p>
      <h1>Your catalogue.<br>Your brand.<br><span class="accent-text">More possibilities.</span></h1>
      <p class="page-intro">A customizable digital menu, catalogue and AI interaction platform. Give customers a simple way to browse, search and ask — and your business one place to manage the experience.</p>
      <div class="button-group"><a class="button button-dark" href="{{ config('portfolio.wooperly_url') }}">Open Nexa login ↗</a><a class="text-link" href="{{ route('contact', ['interest' => 'Nexa QR Menu']) }}">Ask about Nexa →</a></div>
      <p class="small-note">Already a customer? Your existing login is still on getwooperly.com.</p>
    </div>
    <x-product-preview />
  </section>
  <section class="section services-section"><div class="container">
    <p class="eyebrow">BROWSE. SEARCH. ASK.</p><h2>The QR code is just<br>the beginning.</h2>
    <div class="three-grid">
      <article class="value-card"><span>NEXA CATALOGUE</span><h3>Keep your content current.</h3><p>Manage categories, items, ingredients, prices, images and featured content. Add, edit and remove items, then publish changes quickly.</p></article>
      <article class="value-card"><span>NEXA SEARCH</span><h3>Help customers find their next favorite.</h3><p>Guests browse categories and use basic keyword search to discover items, ingredients and prices on their phone.</p></article>
      <article class="value-card"><span>NEXA AI / AI PLAN</span><h3>A conversation with your catalogue.</h3><p>Answer natural-language questions using the business’s configured menu or catalogue, including price ranges, featured options and item combinations.</p></article>
    </div>
  </div></section>
  <section class="container section intro-grid">
    <p class="eyebrow">NEXA STUDIO</p>
    <div><h2>Your menu should<br>look like <span class="muted">your business.</span></h2><p class="large-copy">Control the display name, subtitle, logo and public menu address. Choose templates, colors, fonts and light or dark mode to create an experience that fits your brand.</p><p>Fine-tune text scale, card and price styles, and whether item images appear. Visual settings and everyday content management are available from the same admin area.</p></div>
  </section>
  <section class="section services-section"><div class="container">
    <p class="eyebrow">THE NEXUS QART PLATFORM</p><h2>One account.<br>More than one business.</h2>
    <div class="three-grid">
      <article class="value-card"><span>01 / SWITCH COMPANIES</span><h3>Your businesses, connected.</h3><p>Manage multiple companies and switch between their workspaces from the same user account.</p></article>
      <article class="value-card"><span>02 / KEEP EACH IDENTITY</span><h3>Separate brands. Separate content.</h3><p>Each company keeps its own menu or catalogue data, branding, settings and customer-facing experience.</p></article>
      <article class="value-card"><span>03 / ROOM TO GROW</span><h3>The first of more to come.</h3><p>Nexa is the first available product in the Nexus Qart platform. The account and product structure is designed for additional products in the future.</p></article>
    </div>
    <p class="nexa-audience">For restaurants, cafés, pubs, clubs, hotels, internet cafés and other businesses that need a live digital catalogue.</p>
  </div></section>
  <section class="container section" id="plans">
    <p class="eyebrow">SIMPLE PRICING</p><h2>Start with your menu.<br>Add a little intelligence.</h2>
    <div class="nexa-plans">
      <article class="nexa-plan"><span class="pill">CORE</span><h3>$7 <small>/ month</small></h3><p>Your digital menu and catalogue essentials.</p><ul><li>Live QR menu or catalogue</li><li>Categories, items, ingredients, prices and images</li><li>Featured items and basic search</li><li>Branding, templates and light/dark mode</li><li>Design controls, admin access and fast updates</li></ul><a class="button button-dark" href="{{ route('contact', ['interest' => 'Nexa Core plan']) }}">Ask about Core ↗</a></article>
      <article class="nexa-plan nexa-plan-ai"><span class="pill">AI</span><h3>$11 <small>/ month</small></h3><p>Everything in Core, plus AI assistance.</p><ul><li>Menu and catalogue-grounded AI assistant</li><li>Natural-language questions</li><li>Price questions and combination guidance</li><li>Assistance based on your business content</li></ul><a class="button button-dark" href="{{ route('contact', ['interest' => 'Nexa AI plan']) }}">Ask about AI ↗</a></article>
    </div>
    <p class="nexa-offer">One month free · Installation and initial configuration included · Loyalty program available</p>
  </section>
  <section class="section services-section"><div class="container">
    <p class="eyebrow">LOOKING AHEAD / PLANNED CAPABILITIES</p><h2>Built to keep evolving.</h2><p class="page-intro">These capabilities are on the roadmap, rather than included in the current feature set.</p>
    <div class="three-grid"><article class="value-card"><span>NEXA ORDER / PLANNED</span><h3>Cart & ordering.</h3><p>Let customers collect selected items as Nexa moves toward richer ordering flows.</p></article><article class="value-card"><span>NEXA SEARCH / PLANNED</span><h3>Semantic search.</h3><p>Move beyond current keyword search toward discovery based on meaning.</p></article><article class="value-card"><span>NEXA AI / PLANNED IMPROVEMENTS</span><h3>More helpful conversations.</h3><p>Continue improving context, usefulness and menu or catalogue guidance.</p></article></div>
  </div></section>
  <section class="container section faq-section"><div><p class="eyebrow">A FEW USEFUL DETAILS</p><h2>Before you<br>take a look.</h2></div>
    <div class="faqs">
      <details><summary>Where do I sign in?</summary><p>Use the <a href="{{ config('portfolio.wooperly_url') }}">Nexa login page</a>. It currently opens getwooperly.com; your existing account stays in the separate product application.</p></details>
      <details><summary>What do the screenshots show?</summary><p>These are actual customer-facing menu and AI assistant screenshots. The business branding, items and prices shown are example menu content, not Nexa subscription prices.</p></details>
      <details><summary>Is Nexa only for restaurants?</summary><p>No. Nexa also supports businesses that need a configurable digital catalogue, including cafés, hotels, clubs and other venues.</p></details>
      <details><summary>How do I start or ask about a plan?</summary><p><a href="{{ route('contact', ['interest' => 'Nexa demo and plans']) }}">Contact Nexus Qart</a> to discuss your business, setup and the available plans.</p></details>
    </div>
  </section><x-cta />
</x-layout>
