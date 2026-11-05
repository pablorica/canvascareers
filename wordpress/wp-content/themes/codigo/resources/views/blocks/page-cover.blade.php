<article
  class="magazine__page magazine__page--cover {{ $block->classes }}"
  style="--page-bg: {{ $background }}; {{ $block->inlineStyle }}"
>
  <div class="cover {{ $showWordmark ? '' : 'cover--no-wordmark' }}">
    @if($showDetails)
      <a class="cover__eyebrow no-underline"
        href="{{ get_permalink(get_page_by_path('collaborators')) }}"
      >{{ $eyebrow }}</a>
    @endif

    <h1 class="cover__title">
      <em>{{ $nameLead }}</em>@if($nameRest) {{ $nameRest }}@endif
    </h1>

    @if($showDetails)
      <div class="cover__meta">
        <span class="cover__year">{{ $year }}</span>
        <span class="cover__role">{{ $role }}</span>
        <span class="cover__location">{{ $location }}</span>
        <span class="cover__type">{{ $eyebrow }}</span>
      </div>
    @endif

    @if($showWordmark)
      <div class="cover__wordmark" aria-label="Canvas Careers">
        <a href="{{ home_url('/') }}" class="no-underline">
          <span>Canvas</span>
          <span>Careers</span>
        </a>
      </div>
    @endif
  </div>
</article>
