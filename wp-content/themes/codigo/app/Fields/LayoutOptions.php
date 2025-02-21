<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class LayoutOptions extends Field
{
    /**
     * The field group.
     * https://github.com/Log1x/acf-builder-cheatsheet
     */
    public function fields(): array
    {
        $layoutOptions = Builder::make(
            'layout_options',  
            ['position' => 'side'] 
        );

        $layoutOptions
            ->setLocation('post_type', '==', 'page')
            ->or('post_type', '==', 'post');
        
        
        $layoutOptions
            ->addTrueFalse('layout_hide_title', [
                'label' => 'Hide Title',
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

        return $layoutOptions->build();
    }
}
