/**
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/filters}
 */
roots.register.filters('@scripts/filters');

/**
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/variations}
 */
roots.register.variations('@scripts/variations');

/**
 * @see {@link https://bud.js.org/extensions/bud-preset-wordpress/editor-integration/styles}
 */
roots.register.styles('@scripts/styles');

/**
 * @see {@link https://webpack.js.org/api/hot-module-replacement/}
 */
if (import.meta.webpackHot) import.meta.webpackHot.accept(console.error);
