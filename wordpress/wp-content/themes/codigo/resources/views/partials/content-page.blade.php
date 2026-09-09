{{--
    @name Content Page
    @desc The content layout for pages
--}}

<!-- /codigo/resources/views/partials/content-page.blade.php -->
@php($stretch_content = get_field('stretch_content'))
<div class="@option('layout_container') md:h-full {{ $stretch_content ? 'mbtb-only:px-0 md:pr-0 stretch-content' : '' }}">
  @php(the_content())

  {!! wp_link_pages([
      'echo' => 0,
      'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
      'after' => '</p></nav>'
  ]) !!}
</div>
<!-- End /codigo/resources/views/partials/content-page.blade.php -->
