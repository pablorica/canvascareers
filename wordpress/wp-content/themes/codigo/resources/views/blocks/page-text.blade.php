{{-- Free-form magazine page — built from Grid Cells on the 6×6 grid. --}}
<article
  class="magazine__page magazine__page--text {{ $block->classes }}"
  style="@if($background)--page-bg: {{ $background }}; @endif{{ $block->inlineStyle }}"
>
  <div class="page-text page-text--freeform">
    @if ($pageNumber !== '')
      <span class="page-number page-number--{{ $pageNumberPosition }}">{{ $pageNumber }}</span>
    @endif

    <InnerBlocks
      allowedBlocks="{!! esc_attr(wp_json_encode(['acf/grid-cell'])) !!}"
      template="{!! esc_attr(wp_json_encode([['acf/grid-cell']])) !!}"
    />

    @if ($hasFooter)
      <footer class="page-footer {{ $footerEnd ? 'page-footer--end' : '' }}">
        <span class="page-footer__item">{{ $footerLeft }}</span>
        <span class="page-footer__item">{{ $footerRight }}</span>
      </footer>
    @endif
  </div>
</article>