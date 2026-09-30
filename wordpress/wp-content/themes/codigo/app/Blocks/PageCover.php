<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class PageCover extends Block
{
  public $name = 'Page Cover';

  // ACF Blocks V3 + WP Block API v3 (iframe-compatible)
  public $blockVersion = 3;
  public $apiVersion = 3;

  public $description = 'Cover page — coloured panel with the collaborator name, role and meta line.';

  public $category = 'layout';

  public $icon = 'cover-image';

  public $keywords = ['cover', 'title', 'magazine'];

  public $post_types = ['collaborator'];

  /**
   * Collaborator
   */
  protected function getCollaboratorData($type)
  {
    $id = get_the_ID();

    if ($type === 'year') {
      $terms = get_the_terms(get_the_ID(), 'collaborator-year');

      if ($terms && ! is_wp_error($terms)) {
        return $terms[0]->name;
      }

      return date("Y");
    }

    if ($type === 'position') {
      return get_field('position', $id) ?: '';
    }

    if ($type === 'location') {
      return get_field('location', $id) ?: '';
    }

    return null;
  }
  protected function defaultNameLead(): string
  {
    $parts = preg_split('/\s+/', trim(get_the_title()));

    return $parts[0] ?? '';
  }

  protected function defaultNameRest(): string
  {
    $parts = preg_split('/\s+/', trim(get_the_title()));
    array_shift($parts);

    return implode(' ', $parts);
  }


  /**
   * Only usable inside the Magazine block.
   */
  public $parent = ['acf/magazine'];

  public $supports = [
    'align' => false,
    'multiple' => true,
    'jsx' => false,
    'anchor' => false,
  ];

  public function with(): array
  {
    return [
      'eyebrow' => get_field('eyebrow') ?: 'Interview',
      'nameLead' => get_field('name_lead') ?: $this->defaultNameLead(),
      'nameRest' => get_field('name_rest') ?: $this->defaultNameRest(),
      'year' => get_field('year') ?: $this->getCollaboratorData('year'),
      'role' => get_field('role') ?: $this->getCollaboratorData('position'),
      'location' => get_field('location_text') ?: $this->getCollaboratorData('location'),
      'showWordmark' => (bool) get_field('show_wordmark'),
      'background' => get_field('background_color') ?: '#D7BE7D',
    ];
  }

  public function fields(): array
  {
    $fields = Builder::make('page_cover');



    $fields
      ->addText('eyebrow', [
        'label' => 'Eyebrow',
        'placeholder' => 'Interview',
      ])
      ->addText('name_lead', [
        'label' => 'Name — italic part',
        'instructions' => 'Shown in italics. Leave blank to use the first word of the post title.',
        'placeholder' => 'Marcus',
      ])
      ->addText('name_rest', [
        'label' => 'Name — regular part',
        'instructions' => 'Leave blank to use the rest of the post title.',
        'placeholder' => 'Quigley',
      ])
      ->addText('year', [
        'label' => 'Year',
        'instructions' => 'Leave blank to use the Collaborator Year term.',
        'placeholder' => $this->getCollaboratorData('year'),
      ])
      ->addText('role', [
        'label' => 'Role',
        'instructions' => 'Leave blank to use the collaborator Position field.',
        'placeholder' => $this->getCollaboratorData('position'),
      ])
      ->addText('location_text', [
        'label' => 'Location',
        'instructions' => 'Leave blank to use the collaborator Location field.',
        'placeholder' => $this->getCollaboratorData('location'),
      ])
      ->addTrueFalse('show_wordmark', [
        'label' => 'Show “Canvas Careers” wordmark',
        'default_value' => 1,
        'ui' => 1,
      ])
      ->addColorPicker('background_color', [
        'label' => 'Background colour',
        'default_value' => '#D7BE7D',
      ]);

    return $fields->build();
  }


}
