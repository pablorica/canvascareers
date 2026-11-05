<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class MagazineMenu extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.magazine-menu',
    ];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        $page = get_page_by_path('collaborators');

        return [
            'jobLinks' => wp_get_nav_menu_items('Jobs Filters Menu') ?: [],
            'collaboratorsTitle' => $page ? get_the_title($page) : '',
            'collaboratorsIntro' => $page ? apply_filters('the_content', $page->post_content) : '',
            'collaboratorsUrl' => $page ? get_permalink($page) : '',
            'years' => $this->years(),
        ];
    }

    /**
     * Years shown on the Collaborators page. As there, a single year needs no filter.
     *
     * @return array
     */
    public function years()
    {
        $terms = get_terms('collaborator-year', ['hide_empty' => true]);

        if (is_wp_error($terms)) {
            return [];
        }

        $years = array_values(array_filter(
            $terms,
            fn ($term) => get_field('display_collaborators_index', $term)
        ));

        return count($years) > 1 ? $years : [];
    }
}
