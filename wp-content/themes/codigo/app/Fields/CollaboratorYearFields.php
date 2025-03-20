<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorYearFields extends Field
{
    /**
     * The field group.
     * https://github.com/Log1x/acf-builder-cheatsheet
     */
    public function fields(): array
    {
        $fields = Builder::make('collaborator_year_fields', [
            'title' => 'Extra Fields',
            'style' => 'seamless',
        ]);

        $fields
            ->setLocation('taxonomy', '==', 'collaborator-year');

        $fields
            ->addText('description_title', [
                'label' => 'Description Title',
                'instructions' => 'The title to display above the description.',
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
            ])
            ->addTrueFalse('display_collaborators_index', [
                'label' => 'Display in Collaborators Index Page',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ]);

        return $fields->build();
    }
}
