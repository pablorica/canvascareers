@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @if(has_block('acf/magazine'))
      @include('partials.content-single-collaborator-magazine')
    @else
      @includeFirst(['partials.content-single-' . get_post_type(), 'partials.content-single'])
    @endif
  @endwhile
@endsection
