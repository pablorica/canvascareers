<article
  class="magazine__page magazine__page--cover {{ $block->classes }}"
  style="--page-bg: {{ $background }}; {{ $block->inlineStyle }}"
>
  <div class="cover">
    <p class="cover__eyebrow">{{ $eyebrow }}</p>

    <h1 class="cover__title">
      <em>{{ $nameLead }}</em>@if($nameRest) {{ $nameRest }}@endif
    </h1>

    <div class="cover__foot">
      <div class="cover__meta">
        <span>{{ $year }}</span>
        <span>{{ $role }}</span>
        <span>{{ $location }}</span>
      </div>

      @if($showWordmark)
        <div class="cover__wordmark">Canvas<br>Careers</div>
      @endif
    </div>
  </div>
</article>
