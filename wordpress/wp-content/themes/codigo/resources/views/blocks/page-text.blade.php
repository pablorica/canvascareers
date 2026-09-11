{{-- Free-form magazine page — accepts any Gutenberg blocks via InnerBlocks. --}}
<article class="magazine__page magazine__page--text {{ $block->classes }}" style="{{ $block->inlineStyle }}">
  <div class="page-text page-text--freeform">
    <InnerBlocks />
  </div>
</article>
