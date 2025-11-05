<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class HomeTemplate extends Field
{
  /**
   * The field group.
   * https://github.com/Log1x/acf-builder-cheatsheet
   */
  public function fields(): array
  {
    $fields = Builder::make('home_template', [
      'title' => 'Home Fields',
      'style' => 'seamless',
      'position' => 'side'
    ]);

    $fields
      ->setLocation('page_template', '==', 'template-home.blade.php');

    $fields
      /*
        ->addText('top_title', [
            'label' => 'Top Title',
            'instructions' => 'The title at the top of the page.',
            'required' => 0,
            'conditional_logic' => [],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ])
      */
      ->addPostObject('collaborator', [
        'label' => 'Collaborator',
        'instructions' => 'Select the collaborator to display on the homepage.',
        'required' => 0,
        'conditional_logic' => [],
        'wrapper' => [
          'width' => '',
          'class' => '',
          'id' => '',
        ],
        'post_type' => ['collaborator'],
        'taxonomy' => '',
        'allow_null' => 0,
        'multiple' => 0,
        'return_format' => 'object',
        'ui' => 1,
      ]);

    return $fields->build();
  }
}
