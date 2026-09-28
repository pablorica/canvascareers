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
    $footerLeft = trim((string) get_field('footer_left'));
    $footerRight = trim((string) get_field('footer_right'));

    $pageNumber = trim((string) get_field('page_number'));

    return [
      'pageNumber' => $pageNumber,
      'pageNumberPosition' => get_field('page_number_position') === 'left' ? 'left' : 'right',
      'footerLeft' => $footerLeft,
      'footerRight' => $footerRight,
      'footerEnd' => (bool) get_field('footer_end'),
      'hasFooter' => $footerLeft !== '' || $footerRight !== '',
    ];
  }

  /**
   * The page's content is whatever blocks are nested inside it.
   * The only fields are the page number and footer, which sit in the margins.
   */
  public function fields(): array
  {
    $fields = Builder::make('page_text');

    $fields
      ->addText('page_number', [
        'label' => 'Page number',
        'instructions' => 'Leave empty to hide it.',
        'wrapper' => ['width' => 40],
      ])
      ->addButtonGroup('page_number_position', [
        'label' => 'Page number position',
        'choices' => ['left' => 'Top left', 'right' => 'Top right'],
        'default_value' => 'right',
        'wrapper' => ['width' => 60],
      ])
      ->addText('footer_left', [
        'label' => 'Footer — first item',
        'instructions' => 'Starts at column 1, e.g. "2026" or "Interview".',
        'wrapper' => ['width' => 100],
      ])
      ->addText('footer_right', [
        'label' => 'Footer — second item',
        'instructions' => 'e.g. "Canvas Careers" or "Marcus Quigley".',
        'wrapper' => ['width' => 100],
      ])
      ->addTrueFalse('footer_end', [
        'label' => 'Right-align second item',
        'instructions' => 'Off: starts at column 4. On: aligned to the right margin.',
        'ui' => 1,
        'wrapper' => ['width' => 100],
      ]);

    return $fields->build();
  }
}