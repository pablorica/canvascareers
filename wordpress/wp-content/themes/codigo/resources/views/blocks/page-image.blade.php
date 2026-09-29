<article class="
    magazine__page
    magazine__page--image
    {{ $span === 2 ? 'magazine__page--spread' : '' }}
    {{ $block->classes ?? '' }}
  "
  data-span="{{ $span }}"
>
  <figure class="magazine__page--figure">
    @if ($imageId)
    {!! wp_get_attachment_image(
      $imageId,
      $span === 2 ? 'full' : '2048x2048',
      false,
      [
        'class' => 'magazine__page__img',
        'sizes' => $sizes,
        'loading' => 'lazy',
        'decoding' => 'async',
      ]) !!}
    @elseif ($block->preview ?? false)
      <div class="magazine__page__placeholder">Choose an image</div>
    @endif
  </figure>
</article>
