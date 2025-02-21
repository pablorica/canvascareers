{{--
    @name Content Card
    @desc The content layout for posts cards
--}}

<!-- /codigo/resources/views/partials/content.blade.php -->
@php($layout_container = 'container')
@if( function_exists('get_field') )
  @if(get_field('layout_container', 'option'))
    @php($layout_container = get_field('layout_container', 'option'))
  @endif
@endif

<article @php(post_class( $layout_container ))>
  <header>
    <h2 class="entry-title">
      <a href="{{ get_permalink() }}">
        {!! $title !!}
      </a>
    </h2>

    @include('partials.entry-meta')
  </header>

  <div class="entry-summary">
    @php(the_excerpt())
  </div>
</article>
<!-- End /codigo/resources/views/partials/content.blade.php -->
