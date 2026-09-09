<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});


/**
 * Add a class to the <li> element in the WordPress navigation menu.
 *
 * @param array $classes
 * @param  $item
 * @param  $args
 * @return array
 */
add_filter(
    'nav_menu_css_class', 
    function ($classes, $item, $args) {
        $classes[] = 'mr-3 nav__item';
        return $classes;
    }, 
    1, 
    3
);


/** 
 * Add a class to the <a> element in the WordPress navigation menu.
 *
 * @param array $atts
 * @param $item
 * @param $args
 * @return array
 */
add_filter(
    'nav_menu_link_attributes', 
    function ($atts, $item, $args) {
        $atts['class'] = 'inline-block 
                px-4 py-2 
                text-lg font-normal 
                text-gray-800 
                no-underline 
                rounded-md 
                dark:text-gray-200 
                hover:text-indigo-500 
                focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:focus:bg-gray-800
            ';
        return $atts;
    }, 
    1, 
    3
);
