{{--
    Magazine — horizontal spread container.
    On desktop the track is pinned and scrolls horizontally (see resources/scripts/modules/magazine.js).
    Below 1024px it stacks vertically (see resources/styles/scss/pages/magazine.scss).
--}}
<section
  class="magazine {{ $block->classes }}"
  style="{{ $block->inlineStyle }}"
  data-magazine
  data-snap="{{ $snap }}"
>
  <div class="magazine__track" data-magazine-track>
    <InnerBlocks
      template="{{ $block->template }}"
      allowedBlocks='@json(["acf/page-cover", "acf/page-image", "acf/page-text"])'
      orientation="horizontal"
    />
  </div>
</section>
