<div class="service-list">
  @foreach ([
    ['01', 'Websites & digital experiences', 'A clear online presence, designed around your business and the people you serve.', 'Web design', 'Development'],
    ['02', 'Custom software', 'Practical applications that connect your processes and give your team room to focus.', 'Business tools', 'Integrations'],
    ['03', 'AI & automation', 'Thoughtful ways to reduce repetitive work and make information easier to use.', 'Workflow design', 'AI integration'],
    ['04', 'Technology consulting', 'A technical perspective on your next step, from early ideas to an actionable delivery plan.', 'Discovery', 'Technical strategy']
  ] as [$number, $heading, $copy, $tagOne, $tagTwo])
    <article class="service-row"><span class="service-number">{{ $number }}</span><div><h3>{{ $heading }}</h3><p>{{ $copy }}</p><div class="tags"><span>{{ $tagOne }}</span><span>{{ $tagTwo }}</span></div></div><a href="{{ route('contact', ['interest' => $heading]) }}" class="circle-link" aria-label="Discuss {{ strtolower($heading) }}">↗</a></article>
  @endforeach
</div>
