<?php

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use Log1x\AcfComposer\Builder;

class PageImage extends Block
{
    public $name = 'Page Image';

    public $description = 'A single image page — full-bleed or contained, with an optional caption.';

    public $category = 'layout';

    public $icon = 'format-image';

    public $keywords = ['image', 'photo', 'magazine'];

    public $post_types = ['collaborator'];

    public $parent = ['acf/magazine'];

    public $mode = 'preview';

    public $supports = [
        'align' => false,
        'mode' => true,
        'multiple' => true,
        'jsx' => false,
        'anchor' => false,
    ];

    public function with(): array
    {
        return [
            'image' => get_field('image'),
            'fit' => get_field('fit') ?: 'cover',
            'background' => get_field('background_color') ?: '#E6E1DC',
            'caption' => get_field('caption'),
            'captionLabel' => get_field('caption_label') ?: 'Image',
        ];
    }

    public function fields(): array
    {
        $fields = Builder::make('page_image');

        $fields
            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ])
            ->addSelect('fit', [
                'label' => 'Fit',
                'choices' => [
                    'cover' => 'Full-bleed (cover)',
                    'contain' => 'Contained (with margin)',
                ],
                'default_value' => 'cover',
                'return_format' => 'value',
                'ui' => 1,
            ])
            ->addColorPicker('background_color', [
                'label' => 'Background colour',
                'instructions' => 'Used behind contained images.',
                'default_value' => '#E6E1DC',
            ])
            ->addText('caption_label', [
                'label' => 'Caption label',
                'placeholder' => 'Image',
            ])
            ->addTextarea('caption', [
                'label' => 'Caption',
                'new_lines' => 'br',
                'rows' => 2,
            ]);

        return $fields->build();
    }
}
