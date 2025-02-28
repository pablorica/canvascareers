<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorYearFields extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('collaborator_year_fields', [
            'title' => 'Extra Fields',
        ]);

        $fields
            ->setLocation('taxonomy', '==', 'collaborator-year');

        $fields
            ->addTextarea('no_items_text', [
                'label' => 'No Items Text',
                'instructions' => 'The text to display when no items are found.',
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
