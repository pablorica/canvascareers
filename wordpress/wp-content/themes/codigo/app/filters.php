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


/**
 * Opt all of the ACF blocks into version 3
 * @see https://www.advancedcustomfields.com/resources/acf-blocks-v3/#upgrading-to-v3
 *
 * @param integer $version
 * @param $block
 * @return integer
 */
function my_custom_function_to_bump_the_block_version($version, $block)
{
  return 3;
}
add_filter('acf/blocks/default_block_version', 'my_custom_function_to_bump_the_block_version', 10, 2);


/**
 * Caption for magazine images on mobile, from the Media Library's Title and
 * Image Caption fields. Desktop keeps the captions placed on the page.
 *
 * @param  int|string|null  $attachmentId
 * @return string
 */
function magazine_image_caption($attachmentId)
{
  $attachmentId = (int) $attachmentId;

  if (! $attachmentId) {
    return '';
  }

  $title = get_the_title($attachmentId);
  $caption = wp_get_attachment_caption($attachmentId);

  if (! $title && ! $caption) {
    return '';
  }

  return sprintf(
    '<figcaption class="magazine-image-caption">%s%s</figcaption>',
    $title ? '<strong>' . esc_html($title) . '</strong>' : '',
    $caption ? '<em>' . esc_html($caption) . '</em>' : ''
  );
}


/**
 * Add the mobile caption to image blocks in magazine articles.
 */
add_filter('render_block_core/image', function ($content, $block) {
  if (is_admin() || ! has_block('acf/magazine')) {
    return $content;
  }

  // The block's own caption would be a second <figcaption> in the same figure
  $content = preg_replace('#<figcaption[^>]*wp-element-caption[^>]*>.*?</figcaption>#s', '', $content);

  return str_replace('</figure>', magazine_image_caption($block['attrs']['id'] ?? null) . '</figure>', $content);
}, 10, 2);
