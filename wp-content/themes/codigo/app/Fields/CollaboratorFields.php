<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorFields extends Field
{
    /**
     * The field group.
     * https://github.com/Log1x/acf-builder-cheatsheet
     */
    public function fields(): array
    {
        $fields = Builder::make(
            'collaborator_fields',
            [
                'title' => 'Extra Fields',
                'position' => 'side'
            ]
        );

        $fields
            ->setLocation('post_type', '==', 'collaborator');

        $fields
            ->addText('position', [
                'label' => 'Position',
                'instructions' => '',
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
            ->addText('location', [
                'label' => 'Location',
                'instructions' => '',
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
            ->addText('month', [
                'label' => 'Month',
                'instructions' => '',
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
            ->addRepeater('portfolio_images', [
                'label' => 'Portfolio Images',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [],
                'layout' => 'block',
                'button_label' => 'Add Image',
                'collapsed' => 'fit_mode',
            ])
                ->addImage('image', [
                    'label' => 'Image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'return_format' => 'url',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                ])
                ->addSelect('fit_mode', [
                    'label' => 'Fit Mode',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => [],
                    'wrapper' => [
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ],
                    'choices' => ['cover', 'contain'],
                    'allow_custom' => 0,
                    'save_custom' => 0,
                    'default_value' => ['cover'],
                    'layout' => 'vertical',
                    'toggle' => 0,
                    'return_format' => 'value',
                ])
            ->endRepeater();

        return $fields->build();
    }
}
