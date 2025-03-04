<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class JobsTemplate extends Field
{
    /**
     * The field group.
     */
    public function fields(): array
    {
        $fields = Builder::make('jobs_template', [
            'title' => 'Template Fields',
            'style' => 'seamless',
            'position' => 'side'
        ]);

        $fields
            ->setLocation('post_type', '==', 'page')
            ->and('post_template', '==', 'template-jobs.blade.php');

        $fields
            ->addTaxonomy('job_category', [
                'label' => 'Job Category',
                'instructions' => 'Select the job category to display.',
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'taxonomy' => 'job-category',
                'field_type' => 'select',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 1,
                'return_format' => 'id',
                'multiple' => 0,
            ]);

        // Get CF7 forms
        $forms = get_posts([
            'post_type' => 'wpcf7_contact_form',
            'numberposts' => -1,
        ]);

        $fields->addPostObject('contact_form', [
            'label' => 'Contact Form',
            'instructions' => 'Select the contact form to display.',
            'required' => 0,
            'conditional_logic' => [],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'post_type' => [
                0 => 'wpcf7_contact_form',
            ],
            'taxonomy' => '',
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'id',
        ]);

        return $fields->build();
    }
}
