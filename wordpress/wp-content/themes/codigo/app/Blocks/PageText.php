<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class PageText extends Block
{
  public $name = 'Page Text';

  public $description = 'A free-form page — add any Gutenberg blocks to build a custom spread.';

  public $category = 'layout';

  public $icon = 'editor-alignleft';

  public $keywords = ['text', 'content', 'interview', 'freeform', 'magazine'];

  public $post_types = ['collaborator'];

  public $parent = ['acf/magazine'];

  public $mode = 'preview';

  public $supports = [
    'align' => false,
    'mode' => false,
    'multiple' => true,
    'jsx' => true, // enable InnerBlocks — this page accepts any blocks
    'anchor' => false,
  ];

  public function with(): array
  {
    return [];
  }

  /**
   * No ACF fields — the page's content is whatever blocks are nested inside it.
   */
  public function fields(): array
  {
    return Builder::make('page_text')->build();
  }
}
