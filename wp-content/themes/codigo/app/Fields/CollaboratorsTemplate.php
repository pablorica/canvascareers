<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorsTemplate extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('collaborators_template', [
            'title' => 'Template Fields',
            'style' => 'seamless',
            'position' => 'side'
        ]);

        $fields
            ->setLocation('page_template', '==', 'template-collaborators.blade.php');

        $fields
            ->addNumber('slider_speed', [
                'label' => 'Slider Speed',
                'instructions' => 'The speed of the slider in milliseconds.',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => 3500,
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'min' => 0,
                'max' => 10000,
                'step' => 100,
            ]);

        return $fields->build();
    }
}
