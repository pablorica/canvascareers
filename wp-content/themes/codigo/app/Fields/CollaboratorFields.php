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
            ]);

        return $fields->build();
    }
}
