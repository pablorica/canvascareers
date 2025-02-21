{{--
    @name Content Page
    @desc The content layout for pages
--}}

<!-- /codigo/resources/views/partials/content-page.blade.php -->
<div class="@option('layout_container')">
    @php(the_content())

    {!! wp_link_pages([
        'echo' => 0, 
        'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 
        'after' => '</p></nav>'
    ]) !!}
</div>
<!-- End /codigo/resources/views/partials/content-page.blade.php -->
