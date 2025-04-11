{{--
  Template Name: Home
--}}

@extends('layouts.app')

<!-- /codigo/resources/views/template-home.blade.php -->
@section('content')
  <div id="home" class="@option('layout_container') flex w-full flex-col md:flex-row">
    @php($collaborator = get_field('collaborator'))

    @if($collaborator)
      <div class="w-full md:w-[410px] 2xl:w-[455px] flex-shrink-0 flex flex-col">
        <div class="header-spacer hidden md:block"></div>
        <div class="md:flex-1 flex flex-col justify-center items-start">
          <span class="block
            text-md md:text-lg
            collaborator-fade-in-up
          ">
            {{ get_field('top_title') }}
          </span>
          <h1 class="text-md md:text-3xl 2xl:text-4xl
            font-serif font-light md:font-normal
            mt-4 md:mt-6
            collaborator-fade-in-up
          ">
            @php($name = explode(' ', $collaborator->post_title))
            <span class="italic">{{ $name[0] }}</span> {{ implode(' ', array_slice($name, 1)) }}
          </h1>
          <span class="block
            text-md mt-1 md:mt-6
            collaborator-fade-in-up
          ">
            {{ get_field('position', $collaborator) }} {{ __('based in', 'codigo') }} {{ get_field('location', $collaborator) }}
          </span>
          <div class="text-md
            max-w-80 mt-4
            hidden md:block
            collaborator-fade-in-up
          ">
            {!! get_the_content() !!}
          </div>

          @php($cta = get_field('cta'))
          <a
            href="{{ $cta['link'] }}"
            class="
            text-md 2xl:text-base py-2 px-7 rounded-full
            mb-8 mt-3
            bg-chalk hover:bg-citrus
            transition-colors duration-300
            border border-charcoal md:inline-block
            leading-none text-center hidden
            overflow-ellipsis overflow-hidden whitespace-nowrap
            collaborator-fade-in-up
          "
          >
            {{ $cta['text'] }}
          </a>
        </div>
      </div>
      <div
        class="md:-mr-14 flex-1 mt-6 md:mt-0 relative"
      >

      @php($first_image = get_field('home_first_image', $collaborator->ID))
      @php($second_image = get_field('home_second_image', $collaborator->ID))

      @if($first_image && $second_image)
        <div class="flex flex-wrap h-full gap-0">
          <figure class="w-full lg:w-1/2
            p-0 relative
            collaborator-fade-in-up
          ">
            <img
              class="w-full h-full object-cover"
              src="{{ get_field('home_first_image', $collaborator->ID) }}"
              alt="{{ $collaborator->post_title }}"
            >
        </figure>

          <figure class="w-full lg:w-1/2
            p-0 relative
            hidden lg:block
            collaborator-fade-in-up
          ">
            <img
              class="w-full h-full object-cover"
              src="{{ get_field('home_second_image', $collaborator->ID) }}"
              alt="{{ $collaborator->post_title }}"
            >
        </figure>
        </div>
      @else
        <img
          class="w-full h-full object-cover"
          src="{{ get_the_post_thumbnail_url($collaborator->ID, 'full') }}"
          alt="{{ $collaborator->post_title }}"
        >
      @endif



        <a
          href="{{ $cta['link'] }}"
          class="
            text-md text-white underline
            leading-none text-center md:hidden
            absolute bottom-6 left-0 right-0
          "
        >
          {{ $cta['text'] }}
        </a>
      </div>
    @endif
  </div>
@endsection
<!-- End /codigo/resources/views/template-home.blade.php -->
