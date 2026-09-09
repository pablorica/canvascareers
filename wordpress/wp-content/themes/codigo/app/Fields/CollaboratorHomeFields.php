<?php

namespace App\Fields;

use Log1x\AcfComposer\Builder;
use Log1x\AcfComposer\Field;

class CollaboratorHomeFields extends Field
{
	/**
	 * The field group.
	 * https://github.com/Log1x/acf-builder-cheatsheet
	 */
	public function fields(): array
	{
		$fields = Builder::make(
			'collaborator_home_fields',
			[
				'title' => 'Homepage Details',
				'position' => 'side'
			]
		);


        //In an admin page: wp-admin/post.php?post=35&action=edit, how can I get current post ID: (get_the_ID() des not work)

        // Attempt to retrieve the collaborator ID from a transient
        $collaborator = get_transient('collaborator_id');

        // If no transient is set, determine the collaborator ID
        if (!$collaborator) {
            global $post;
            if (!empty($post) && isset($post->ID)) {
                $collaborator = $post->ID;
                //error_log('Collaborator ID from $post: ' . $collaborator);
            } elseif (isset($_GET['post'])) {
                $collaborator = intval($_GET['post']);
                //error_log('Collaborator ID via $_GET: ' . $collaborator);
            } else {
                //error_log('Post ID not found.');
            }

            // Save the collaborator ID in a transient for future use
            if ($collaborator) {
                set_transient('collaborator_id', $collaborator, 60); // Persist for 60 seconds
            }
        }

        // Default headline
        $headline = 'Designer based in London';
        // If a collaborator ID is found, fetch the custom fields
        if ($collaborator) {
            $position = get_field('position', $collaborator);
            $location = get_field('location', $collaborator);

            // Ensure fields are not empty before constructing the headline
            if (!empty($position) && !empty($location)) {
                $headline = $position . ' based in ' . $location;
            } else {
                //error_log('Custom fields are missing for post ID: ' . $collaborator);
            }
        }



		$fields
			->setLocation('post_type', '==', 'collaborator');

		$fields
			->addMessage('home_details', 'message', [
				'label' => 'Collaborator data to be displayed on the homepage',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => [],
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'message' => '',
				'new_lines' => 'wpautop', // 'wpautop', 'br', '' no formatting
				'esc_html' => 0,
			])
			->addImage('home_first_image', [
				'label' => 'First Image',
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
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			])
			->addImage('home_second_image', [
				'label' => 'Second Image',
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
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			])
			->addText('home_intro_label', [
				'label' => 'Intro label ',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => [],
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'default_value' => 'Featuring the jobs of',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			])
			->addText('home_headline', [
				'label' => 'Headline',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => [],
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'default_value' => '',
				'placeholder' => $headline,
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			])
			->addTextarea('home_description', [
				'label' => 'Description',
				'instructions' => '',
				'required' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'default_value' => '',
				'placeholder' => 'Evelent, sa nem ratempo rerrum la cum intem in nimet quo volorro expe nobis parupta tibusanduci re cus',
				'maxlength' => '',
				'rows' => '',
				'new_lines' => '', // Possible values are 'wpautop', 'br', or ''.
			])
			->addLink('cta', [
                'label' => 'Call to Action',
                'instructions' => "By default the label is 'Discover our Collaborators', and it's linked to the collaborators page.",
                'required' => 0,
                'conditional_logic' => [],
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'return_format' => 'array',
            ]);

		return $fields->build();
	}
}
