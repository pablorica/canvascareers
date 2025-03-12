{{--
  Template Name: Collaborators
--}}

@extends('layouts.app')

<!-- /codigo/resources/views/template-collaborators.blade.php -->
@section('content')
  <div
    id="collaborators"
    class="@option('layout_container') flex items-center min-h-full md:m-auto flex-col md:flex-row"
  >
    <div class="flex flex-col w-full md:grid grid-cols-12 flex-1">
      <div class="
        col-span-12 md:col-span-3 xl:col-span-2 md:my-8 mb-10 mt-2
        md:block flex flex-wrap gap-y-2 gap-x-4 items-center justify-between
      ">
        <h1 class="h4 text-2xl">{{ get_the_title() }}</h1>

        <div class="text-sm 2xl:text-md mt-6 mb-9 font-medium hidden md:block">
          {!! get_the_content() !!}
        </div>

        @php($years = get_terms('collaborator-year', ['hide_empty' => false]))
        <ul class="flex list-none gap-x-1 sm:gap-x-2 gap-y-1 flex-wrap">
          @foreach($years as $year)
            <li>
              <a
                class="
                  text-lg 2xl:text-2xl py-1 md:py-2 px-3
                  cursor-pointer rounded-full
                  bg-chalk hover:bg-citrus
                  transition-colors duration-300
                  border border-charcoal block
                  leading-none text-center collaborators-year
                  @if($loop->first) !bg-charcoal !text-chalk @endif
                "
                data-filter="{{ $year->slug }}"
              >
                {{ $year->name }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
      <div class="hidden md:block col-span-2"></div>
      @foreach($years as $year)
        @php($collaborators = get_posts([
          'post_type' => 'collaborator',
          'posts_per_page' => -1,
          'tax_query' => [[
            'taxonomy' => 'collaborator-year',
            'field' => 'slug',
            'terms' => $year->slug,
          ]],
        ]))

        <div
          class="
            collaborators collaborators-{{ $year->slug }}
            md:col-span-7 xl:col-span-8 col-span-12
            md:max-w-full max-w-[70%] w-full
            mx-auto md:overflow-hidden flex-1
            @if(!$loop->first) hidden @endif
            @if (count($collaborators) > 0) wrapper-carousel @endif
          "
        >
          @if (count($collaborators) > 0)
            <div
              class="flex gap-2 md:my-8 tiny-carousel"
              data-autoplay="1"
              data-autoplay-timeout="{{ get_field('slider_speed') }}"
            >
              @foreach($collaborators as $collaborator)
                <div class="collaborator !flex flex-col justify-end">
                  <span class="font-sans text-lg md:text-xl 2xl:text-3xl mb-5 2xl:mb-7 block">
                    {{ get_field('month', $collaborator) }}
                  </span>
                  <a href="{{ get_permalink($collaborator) }}" class="flex-1 flex flex-col md:justify-end">
                    <div class="md:flex-1 mb-4">
                      <h2 class="font-serif text-xl md:text-xl 2xl:text-2xl font-normal line-clamp-1 md:line-clamp-none">
                        @php($name = explode(' ', get_the_title($collaborator)))
                        <span class="italic">{{ $name[0] }}</span> {{ implode(' ', array_slice($name, 1)) }}
                      </h2>
                      <p class="text-sm mt-3 font-serif line-clamp-1 md:line-clamp-none">
                        <strong>{{ get_field('position', $collaborator) }},</strong> {{ get_field('location', $collaborator) }}
                      </p>
                    </div>

                    <img
                      class="w-full hidden md:block md:h-[280px] 2xl:h-[320px] object-cover"
                      src="{{ get_the_post_thumbnail_url($collaborator) }}"
                      alt="{{ get_the_title($collaborator) }}"
                    />
                    <div
                      class="bg-cover bg-center w-full bg-no-repeat md:hidden flex-1"
                      style="background-image: url('{{ get_the_post_thumbnail_url($collaborator) }}')"
                    >
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <div class="md:my-8 block md:h-[418px] 2xl:h-[456px]">
              <span class="text-sm text-center font-medium">
                {!! get_field('no_items_text', $year) !!}
              </span>
            </div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
@endsection
<!-- End /codigo/resources/views/template-collaborators.blade.php -->
