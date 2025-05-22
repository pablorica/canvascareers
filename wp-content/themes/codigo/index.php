<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>

  <?php
  //Check if body_class() contains wp-admin
  $body_class_frontend = 'overflow-x-hidden';
  $body_class = esc_attr( implode( ' ', get_body_class() ) );
  if (strpos($body_class, 'wp-admin') === false) {
    $body_class_frontend .= ' wp-frontend';
  }
   ?>
  <body <?php body_class($body_class_frontend); ?>>
    <?php wp_body_open(); ?>
    <?php do_action('get_header'); ?>

    <div id="app">
      <?php echo view(app('sage.view'), app('sage.data'))->render(); ?>
    </div>

    <?php do_action('get_footer'); ?>
    <?php wp_footer(); ?>
  </body>
</html>
