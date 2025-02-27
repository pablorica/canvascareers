<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorFields extends Field
{
    /**
     * The field group.
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
            ->endRepeater();

        return $fields->build();
    }
}
