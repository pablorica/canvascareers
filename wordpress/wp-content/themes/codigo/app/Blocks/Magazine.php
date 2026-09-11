<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class Magazine extends Block
{
  /**
   * The block name.
   */
  public $name = 'Magazine';

  /**
   * The block description.
   */
  public $description = 'Horizontal, magazine-style container. Add page blocks inside: on desktop they scroll horizontally two-up, on mobile they stack vertically.';

  /**
   * The block category.
   */
  public $category = 'layout';

  /**
   * The block icon.
   */
  public $icon = 'book';

  /**
   * The block keywords.
   */
  public $keywords = ['magazine', 'horizontal', 'spread', 'collaborator'];

  /**
   * The block post type allow list.
   */
  public $post_types = ['collaborator'];

  /**
   * The default block mode.
   */
  public $mode = 'preview';

  /**
   * The default block alignment.
   */
  public $align = 'full';

  /**
   * The supported block features.
   */
  public $supports = [
    'align' => true,
    'mode' => true,
    'multiple' => false,
    'jsx' => true,
    'anchor' => true,
  ];

  /**
   * Inner block starting template — a sensible sequence for a new conversation.
   */
  public $template = [
    'acf/page-cover' => [],
    'acf/page-image' => [],
    'acf/page-text'  => [],
  ];

  /**
   * Data passed to the block view.
   */
  public function with(): array
  {
    return [
      'snap' => get_field('snap_mode') ?: 'page',
    ];
  }

  /**
   * The block field group.
   */
  public function fields(): array
  {
    $fields = Builder::make('magazine');

    $fields
      ->addSelect('snap_mode', [
        'label' => 'Snap',
        'instructions' => 'How the horizontal scroll settles as the reader moves through the conversation.',
        'choices' => [
          'page' => 'One page at a time',
          'spread' => 'One spread (two pages) at a time',
        ],
        'default_value' => 'page',
        'return_format' => 'value',
        'ui' => 1,
      ]);

    return $fields->build();
  }

  /**
   * Assets enqueued when rendering the block.
   */
  public function assets(array $block): void
  {
    //
  }
}
