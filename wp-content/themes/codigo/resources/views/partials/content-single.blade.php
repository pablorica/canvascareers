{{--
    @name Content Single
    @desc The content layout for posts
--}}

<!-- /codigo/resources/views/partials/content-single.blade.php -->
<article @php(post_class('h-entry '.get_field("layout_container", "option") )) >
  <header>

    @if( function_exists('get_field') )
      @if(get_field('layout_hide_title'))
      @else
        <h1 class="p-name">{!! $title !!}</h1>
      @endif
    @endif

    @include('partials.entry-meta')
  </header>

  <div class="e-content">
    @php(the_content())
  </div>

  <footer>
    {!! wp_link_pages([
        'echo' => 0,
        'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'),
        'after' => '</p></nav>'
    ]) !!}
  </footer>

  @php(comments_template())
</article>
