<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Post extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.page-header',
        'partials.content',
        'partials.content-*',
    ];

    /**
     * Data to be passed to view before rendering, but after merging.
     *
     * @return array
     */
    public function override()
    {
        return [
            'title'          => $this->title(),
            'layout_options' => $this->layout_options(),
        ];
    }

    /**
     * Returns the post title.
     *
     * @return string
     */
    public function title()
    {
        if ($this->view->name() !== 'partials.page-header') {
            return get_the_title();
        }

        if (is_home()) {
            if ($home = get_option('page_for_posts', true)) {
                return get_the_title($home);
            }

            return __('Latest Posts', 'sage');
        }

        if (is_archive()) {
            return get_the_archive_title();
        }

        if (is_search()) {
            return sprintf(
                /* translators: %s is replaced with the search query */
                __('Search Results for %s', 'sage'),
                get_search_query()
            );
        }

        if (is_404()) {
            return __('Not Found', 'sage');
        }

        return get_the_title();
    }


    /**
     * Returns the ACF layout options.
     * Deprecated: Use the ACF Builder instead.
     *
     * @return array
     */
    public function layout_options() {
        $options = [
            'container'  => 'container',
            'hide_title' => false,
        ];
        if ( function_exists( 'get_field' ) ) { 
            $options['container']  =  get_field('layout_container');
            $options['hide_title'] = get_field('layout_hide_title');
        }
        return $options;
    }
}
