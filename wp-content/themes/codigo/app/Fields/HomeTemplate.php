<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class HomeTemplate extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('home_template', [
            'title' => 'Template Fields',
            'style' => 'seamless',
            'position' => 'side'
        ]);

        $fields
            ->setLocation('page_template', '==', 'template-home.blade.php');

        $fields
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
            ])
            ->addGroup('cta', [
                'label' => 'Call to Action',
                'instructions' => 'The call to action of the page.',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'layout' => 'block'
            ])
                ->addText('text', [
                    'label' => 'Text',
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
                ->addText('link', [
                    'label' => 'Link',
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
            ->endGroup();

        return $fields->build();
    }
}
