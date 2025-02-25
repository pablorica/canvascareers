{{--
  Template Name: Collaborators
--}}

@extends('layouts.app')

<!-- /codigo/resources/views/template-members.blade.php -->
@section('content')
  <div
    id="collaborators"
    class="@option('layout_container') flex items-center min-h-full"
  >
    <div class="grid grid-cols-12">
      <div class="
        col-span-12 md:col-span-3 xl:col-span-2 md:my-8 mb-10
        md:block flex flex-wrap gap-y-2 gap-x-4 items-center justify-between
      ">
        <h1 class="h4 text-2xl">{{ get_the_title() }}</h1>

        <div class="text-sm mt-6 mb-9 font-medium hidden md:block">
          {!! get_the_content() !!}
        </div>

        @php($years = get_terms('year', ['hide_empty' => false]))
        <ul class="flex list-none gap-x-1 sm:gap-x-2 gap-y-1 flex-wrap">
          @foreach($years as $year)
            <li>
              <a
                class="
                  text-lg md:text-2xl py-1 md:py-2 px-3
                  hover:text-chalk cursor-pointer
                  bg-chalk hover:bg-charcoal rounded-full
                  transition-colors duration-300
                  border border-charcoal block
                  leading-none text-center collaborators-year
                  @if($loop->first) bg-charcoal text-chalk @endif
                "
                data-filter="{{ $year->slug }}"
              >
                {{ $year->name }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="col-span-2"></div>
      @foreach($years as $year)
        <div
          class="
            collaborators collaborators-{{ $year->slug }}
            md:col-span-7 xl:col-span-8 wrapper-carousel col-span-12
            md:max-w-full max-w-[70%] w-full
            mx-auto md:overflow-hidden
            @if(!$loop->first) hidden @endif
          "
        >
          <div
            class="flex gap-2 md:my-8 tiny-carousel"
            data-autoplay="1"
            data-autoplay-timeout="{{ get_field('slider_speed') }}"
          >
            @php($collaborators = get_posts([
              'post_type' => 'collaborator',
              'posts_per_page' => -1,
              'tax_query' => [[
                'taxonomy' => 'year',
                'field' => 'slug',
                'terms' => $year->slug,
              ]],
            ]))

            @foreach($collaborators as $collaborator)
              <div class="collaborator !flex flex-col justify-end">
                <span class="font-sans text-lg md:text-3xl mb-5 md:mb-7 block">
                  {{ get_field('month', $collaborator) }}
                </span>
                <a href="{{ get_permalink($collaborator) }}" class="flex-1 flex flex-col justify-end">
                  <div class="flex-1 mb-4">
                    <h2 class="font-serif italic text-xl md:text-2xl font-medium">
                      {{ get_the_title($collaborator) }}
                    </h2>
                    <p class="text-sm mt-3 font-serif">
                      <strong>{{ get_field('position', $collaborator) }},</strong> {{ get_field('location', $collaborator) }}
                    </p>
                  </div>

                  <img
                    class="w-full h-[350px] md:h-[280px] 2xl:h-[320px] object-cover"
                    src="{{ get_the_post_thumbnail_url($collaborator) }}"
                    alt="{{ get_the_title($collaborator) }}"
                  />
                </a>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
<!-- End /codigo/resources/views/template-members.blade.php -->
