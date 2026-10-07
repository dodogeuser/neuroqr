<x-layout title="Let’s talk" description="Contact Nexus Qart about your next website, software project, or the Nexa QR menu product.">
  <section class="container page-hero"><p class="eyebrow">LET’S CONNECT</p><h1>Good things start<br>with a <span class="accent-text">conversation.</span></h1><p class="page-intro">Tell us what you’re thinking about. A new project, a practical problem, or a question about Nexa — we’d like to hear it.</p></section>
  <section class="container contact-grid">
    <div class="contact-card"><p class="eyebrow">WRITE TO US</p><h2>Your idea.<br>Our next conversation.</h2><p>A few details about your business, your goals, and your timing will help us understand where to start.</p>
      @php
        $interest = request()->query('interest');
        $subject = is_string($interest) ? mb_substr($interest, 0, 160) : 'A new project';
        $mailto = 'mailto:'.config('portfolio.contact_email').'?subject='.rawurlencode('Nexus Qart — '.$subject);
      @endphp
      <a class="button button-dark" href="{{ $mailto }}">Start an email <span aria-hidden="true">↗</span></a><a class="email-address" href="mailto:{{ config('portfolio.contact_email') }}">{{ config('portfolio.contact_email') }}</a><p class="small-note">Opens your email app. You can also copy the address into your preferred email service.</p>
    </div>
    <div class="contact-aside"><p class="eyebrow">WHAT TO INCLUDE</p><ol class="brief-list"><li><span>01</span><div><h3>A little about you</h3><p>Your company and the people you serve.</p></div></li><li><span>02</span><div><h3>What you have in mind</h3><p>The problem, the idea, or the product you’re interested in.</p></div></li><li><span>03</span><div><h3>Your starting point</h3><p>Any existing website, timeline, or requirements.</p></div></li></ol><div class="login-note"><strong>Looking for your QR menu account?</strong><a class="text-link" href="{{ config('portfolio.wooperly_url') }}">Go to Nexa login ↗</a></div></div>
  </section>
</x-layout>
