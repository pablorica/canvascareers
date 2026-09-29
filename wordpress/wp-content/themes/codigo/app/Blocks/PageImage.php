<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class PageImage extends Block
{
  public $name = 'Page Image';

  // ACF Blocks V3 + WP Block API v3 (iframe-compatible)
  public $blockVersion = 3;
  public $apiVersion = 3;

  public $description = 'A full-bleed image filling one page or a two-page spread.';

  public $category = 'layout';

  public $icon = 'format-image';

  public $keywords = ['image', 'photo', 'magazine', 'spread'];

  public $post_types = ['collaborator'];

  public $parent = ['acf/magazine'];

  public $supports = [
    'align' => false,
    'multiple' => true,
    'jsx' => false,
    'anchor' => false,
  ];

  public function with(): array
  {
    // error_log('SPAN: ' . var_export(get_field('span'), true));
    // error_log('FIELDS: ' . var_export(get_fields(), true));
    // error_log('RAW: ' . var_export($this->block->data ?? null, true));

   $span = get_field('span') === 'Two-page spread' ? 2 : 1;
  //$span = get_field('span');

    return [
      'imageId' => get_field('image'),
      'span' => $span,
      // One A4 page at full viewport height ≈ 70.7vh wide; a spread is double.
      'sizes' => $span === 2
        ? '(max-width: 767px) 100vw, 142vh'
        : '(max-width: 767px) 100vw, 71vh',
    ];
  }

  public function fields(): array
  {
    $fields = Builder::make('page_image');

    /*
    Check the [ACF Builder Cheatsheet](https://github.com/Log1x/acf-builder-cheatsheet?tab=readme-ov-file) to learn how to add ACF fields by code
     */

    $fields
      ->addImage('image', [
        'label' => 'Image',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'required' => 1,
      ])
      ->addButtonGroup('span', [
        'label' => 'Width',
        'choices' => [
            'One page',
            'Two-page spread',
        ],
        'default_value' => 'single',
        'return_format' => 'value',
        'layout' => 'horizontal',
      ]);

    return $fields->build();
  }
}
