@props(['title' => 'Thoughtful software. Real-world impact.', 'description' => 'Nexus Qart designs and builds websites, software, and digital products that make everyday business simpler.'])
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#f8fafc">
  <title>{{ $title }} | Nexus Qart</title>
  <meta name="description" content="{{ $description }}">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Nexus Qart">
  <meta property="og:title" content="{{ $title }} | Nexus Qart">
  <meta property="og:description" content="{{ $description }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <link rel="icon" href="{{ asset('assets/nexus-qart-mark.svg') }}" type="image/svg+xml">
  <link rel="stylesheet" href="{{ asset('assets/site.css') }}">
  <script src="{{ asset('assets/site.js') }}" defer></script>
</head>
<body>
  <a class="skip-link" href="#main">Skip to content</a>
  <header class="site-header">
    <div class="container header-inner">
      <a href="{{ route('home') }}" class="brand" aria-label="Nexus Qart home"><img src="{{ asset('assets/nexus-qart-logo.svg') }}" width="221" height="42" alt="Nexus Qart"></a>
      <nav class="desktop-nav" aria-label="Main navigation">
        @foreach (['home' => 'Home', 'about' => 'About', 'services' => 'Services', 'products' => 'Products'] as $name => $label)
          <a href="{{ route($name) }}" @if(request()->routeIs($name) || ($name === 'products' && request()->routeIs('nexa'))) aria-current="page" @endif>{{ $label }}</a>
        @endforeach
      </nav>
      <a class="button button-small header-cta" href="{{ route('contact') }}">Let’s talk <span aria-hidden="true">↗</span></a>
      <button class="menu-toggle" hidden type="button" aria-controls="mobile-nav" aria-expanded="false">Menu <span aria-hidden="true">☰</span></button>
    </div>
    <nav id="mobile-nav" class="mobile-nav container" aria-label="Mobile navigation" hidden>
      @foreach (['home' => 'Home', 'about' => 'About', 'services' => 'Services', 'products' => 'Products', 'contact' => 'Contact'] as $name => $label)
        <a href="{{ route($name) }}" @if(request()->routeIs($name)) aria-current="page" @endif>{{ $label }}</a>
      @endforeach
    </nav>
    <noscript><nav class="container fallback-nav" aria-label="Page navigation"><a href="{{ route('home') }}">Home</a><a href="{{ route('about') }}">About</a><a href="{{ route('services') }}">Services</a><a href="{{ route('products') }}">Products</a><a href="{{ route('contact') }}">Contact</a></nav></noscript>
  </header>
  <main id="main">{{ $slot }}</main>
  <footer class="site-footer">
    <div class="container footer-top">
      <div><a class="brand" href="{{ route('home') }}"><img src="{{ asset('assets/nexus-qart-logo-light.svg') }}" width="221" height="42" alt="Nexus Qart home"></a><p>Good ideas deserve<br>thoughtful technology.</p></div>
      <div><h2>Explore</h2><a href="{{ route('about') }}">About us</a><a href="{{ route('services') }}">Our services</a><a href="{{ route('contact') }}">Get in touch</a></div>
      <div><h2>Our products</h2><a href="{{ route('products') }}">All products</a>
        @foreach (config('products') as $product)
          <a href="{{ isset($product['route']) ? route($product['route']) : $product['url'] }}">{{ $product['name'] }}</a>
        @endforeach
      </div>
      <div><h2>Have an idea?</h2><a class="footer-contact" href="{{ route('contact') }}">Let’s build it together. <span aria-hidden="true">↗</span></a></div>
    </div>
    <div class="container footer-bottom"><span>© {{ date('Y') }} Nexus Qart. All rights reserved.</span><span>Designed with purpose. Built with care.</span></div>
  </footer>
</body>
</html>

