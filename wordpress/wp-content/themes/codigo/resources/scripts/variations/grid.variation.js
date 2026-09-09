/**
 * Add CSS Grids to Gutenberg Group Block
 * TODO: Check if the variation already exists by searching for it in the registered variations array.
 *
 * Bud.js
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/variations}
 *
 * Wordpress
 * @see {@link https://developer.wordpress.org/news/2023/08/29/an-introduction-to-block-variations/}
 * @see {@link https://developer.wordpress.org/themes/features/block-variations/}
 * @see {@link https://developer.wordpress.org/block-editor/reference-guides/block-api/block-variations/}
 * @see {@link https://developer.wordpress.org/news/2024/02/06/adding-and-using-grid-support-in-wordpress-themes/}
 */



export default {
  block: `core/group`,
  name: 'group-grid',
  title: `Grid`,
  icon: 'grid-view',
  description: `Arrange blocks in a grid.`,
  attributes: {
    layout: {
      type: 'grid'
    }
  },
  scope: ['block', 'inserter', 'transform'],
  isActive: (blockAttributes) => blockAttributes.layout?.type === 'grid',

}
