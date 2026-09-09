<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class SalarySurveys extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('salary_surveys');

        $fields
            ->setLocation('post_type', '==', 'salary');

        $fields->addText('low', [
            'label' => 'Low',
            'instructions' => '',
            'required' => 0,
            'wrapper' => [
                'width' => '33%',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ])->addText('typical', [
            'label' => 'Typical',
            'instructions' => '',
            'required' => 0,
            'wrapper' => [
                'width' => '33%',
                'class' => '',
                'id' => '',
            ],
            'default_value' => '',
            'placeholder' => '',
            'prepend' => '',
            'append' => '',
            'maxlength' => '',
        ])->addText('high', [
            'label' => 'High',
            'instructions' => '',
            'required' => 0,
            'wrapper' => [
                'width' => '33%',
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
