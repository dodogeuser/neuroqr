<div class="service-list">
  @foreach ([
    ['01', 'Websites & digital experiences', 'A distinctive online presence that tells your story and makes the next step feel natural.', 'Web design', 'Development', 'web'],
    ['02', 'Custom software', 'Purpose-built tools that fit your business, connect your processes, and simplify the everyday.', 'Business tools', 'Integrations', 'software'],
    ['03', 'AI & automation', 'Put information to work and give your team more room to focus on what needs a human touch.', 'Workflow design', 'AI integration', 'ai'],
    ['04', 'Technology consulting', 'A clear technical perspective, from the first question to a practical plan for moving forward.', 'Discovery', 'Technical strategy', 'strategy']
  ] as [$number, $heading, $copy, $tagOne, $tagTwo, $icon])
    <article class="service-row" id="service-{{ $icon }}">
      <div class="service-card-top"><span class="service-icon" aria-hidden="true"><svg viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        @if ($icon === 'web')
          <rect x="4" y="6" width="24" height="20" rx="3"/><path d="M4 12h24M9 9h.1M13 9h.1M9 17h7M9 21h12"/>
        @elseif ($icon === 'software')
          <path d="m11 10-7 6 7 6m10-12 7 6-7 6M18 7l-4 18"/>
        @elseif ($icon === 'ai')
          <path d="m16 3 3.5 9.5L29 16l-9.5 3.5L16 29l-3.5-9.5L3 16l9.5-3.5Z"/>
        @else
          <circle cx="16" cy="16" r="12"/><path d="m21 11-3 7-7 3 3-7Z"/>
        @endif
      </svg></span><span class="service-number">{{ $number }}</span></div>
      <div class="service-card-body"><h3>{{ $heading }}</h3><p>{{ $copy }}</p></div>
      <div class="service-card-bottom"><div class="tags"><span>{{ $tagOne }}</span><span>{{ $tagTwo }}</span></div><a href="{{ route('contact', ['interest' => $heading]) }}" class="circle-link" aria-label="Discuss {{ strtolower($heading) }}">↗</a></div>
    </article>
  @endforeach
</div>
