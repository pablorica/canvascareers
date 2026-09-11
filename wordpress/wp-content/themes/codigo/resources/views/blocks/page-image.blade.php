<article
  class="magazine__page magazine__page--image magazine__page--fit-{{ $fit }} {{ $block->classes }}"
  style="--page-bg: {{ $background }}; {{ $block->inlineStyle }}"
>
  @if($image)
    <figure class="page-image">
      <img
        class="page-image__img"
        src="{{ $image['url'] }}"
        alt="{{ $image['alt'] ?? '' }}"
        loading="lazy"
      >
      @if($caption)
        <figcaption class="page-image__caption">
          @if($captionLabel)
            <span class="page-image__caption-label">{{ $captionLabel }}</span>
          @endif
          <span class="page-image__caption-text">{!! nl2br(e($caption)) !!}</span>
        </figcaption>
      @endif
    </figure>
  @else
    <div class="page-image__placeholder">
      {{ $block->preview ? 'Select an image →' : '' }}
    </div>
  @endif
</article>
