<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class JobFieds extends Field
{
    /**
     * The field group.
     * https://github.com/Log1x/acf-builder-cheatsheet
     */
    public function fields(): array
    {
        $fields = Builder::make('job_fieds', [
            'title' => 'Job Fields',
        ]);

        $fields
            ->setLocation('post_type', '==', 'job');

        $fields
            ->addText('contract', [
                'label' => 'Contract',
                'instructions' => '',
                'default_value' => '',
                'wrapper' => [
                    'width' => '50',
                ],
            ])
            ->addText('salary', [
                'label' => 'Salary',
                'instructions' => '',
                'default_value' => '',
                'wrapper' => [
                    'width' => '50',
                ],
            ])
            ->addWysiwyg('start_column', [
                'label' => 'Start Column',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'wrapper' => [
                    'width' => '50',
                ],
            ])
            ->addWysiwyg('middle_column', [
                'label' => 'Middle Column',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'wrapper' => [
                    'width' => '50',
                ],
            ])
            ->addWysiwyg('end_column', [
                'label' => 'End Column',
                'instructions' => '',
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'wrapper' => [
                    'width' => '50',
                ],
            ]);

        return $fields->build();
    }
}
