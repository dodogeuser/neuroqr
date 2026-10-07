<x-layout title="Our products" description="Explore the Nexus Qart product portfolio: purposeful digital tools for everyday business needs.">
  <section class="container page-hero"><p class="eyebrow">OUR PRODUCT PORTFOLIO</p><h1>Built with purpose.<br>Ready for the <span class="accent-text">everyday.</span></h1><p class="page-intro">Our products put our approach into practice: thoughtful technology for familiar business needs.</p></section>
  @foreach (config('products') as $product)
    <section class="container product-feature-grid">
      <div>
        <span class="pill">{{ $product['category'] }}</span>
        <h2 class="product-title">{{ $product['name'] }}</h2>
        <p class="large-copy">{{ $product['tagline'] }}</p>
        <p>{{ $product['description'] }}</p>
        <div class="button-group">
          <a class="button button-dark" href="{{ isset($product['route']) ? route($product['route']) : $product['url'] }}">Explore {{ $product['name'] }} ↗</a>
          @if (!empty($product['login_url']))
            <a class="text-link" href="{{ $product['login_url'] }}">{{ $product['name'] }} login ↗</a>
          @endif
        </div>
      </div>
      @if (($product['preview'] ?? null) === 'nexa')
        <x-product-preview />
      @elseif (!empty($product['image']))
        <img src="{{ asset($product['image']) }}" alt="{{ $product['name'] }} product preview" loading="lazy">
      @else
        <div class="brand-art" aria-hidden="true"><img src="{{ asset('assets/nexus-qart-mark.svg') }}" width="230" height="230" alt=""><span>{{ $product['name'] }}</span></div>
      @endif
    </section>
  @endforeach
  <x-cta />
</x-layout>
