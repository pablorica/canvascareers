{{--
  Template Name: Collaborators
--}}

@extends('layouts.app')


@section('content')
<!-- /codigo/resources/views/template-collaborators.blade.php -->
  <div
    id="collaborators"
    class="@option('layout_container')
      flex items-center lg:items-end
      min-h-full
      lg:m-auto
      flex-col lg:flex-row"
  >
    <div class="w-full
      flex flex-col flex-1
      lg:grid grid-cols-12
    ">
      <div class="
        col-span-12 lg:col-span-2
        mb-10 mt-2 lg:my-0
        flex flex-wrap
        gap-y-2 gap-x-4
        items-center justify-between
        lg:block
      ">
        <h1 class="h4
          text-2xl lg:text-xl 2xl:text-3xl
          2xl:mb-7
        ">{{ get_the_title() }}</h1>

        <div class="text-sm 2xl:text-md
          mt-6 mb-9
          font-medium
          max-w-[215px] 2xl:max-w-[260px]
          hidden lg:block">
          {!! get_the_content() !!}
        </div>

        <?php
        $allowed_years = [];
        $years   = get_terms('collaborator-year', ['hide_empty' => false]);
        $seasons = get_terms('collaborator-season', ['hide_empty' => false]);
        if(count($years) > 1) {
          foreach($years as $year) {
            if(get_field('display_collaborators_index', $year)) {

              //Check if this taxonomy term has published posts
              //error_log("Checking collaborators for year: " . print_r($year, true));
              $collaborators = get_posts([
                'post_type' => 'collaborator',
                'posts_per_page' => -1,
                'tax_query' => [[
                  'taxonomy' => 'collaborator-year',
                  'field' => 'slug',
                  'terms' => $year->slug,
                ]],
              ]);
              if(count($collaborators) > 0) {
                // If the year has collaborators, add it to the allowed years
                $allowed_years[] = $year;
                $allowed_seasons[$year->slug] = [];
                if(count($seasons) > 1) {
                  foreach($seasons as $season) {
                    $seasonalcols = get_posts([
                      'post_type' => 'collaborator',
                      'posts_per_page' => -1,
                      'tax_query' => [[
                        'taxonomy' => 'collaborator-year',
                        'field' => 'slug',
                        'terms' => $year->slug,
                        ],[
                        'taxonomy' => 'collaborator-season',
                        'field' => 'slug',
                        'terms' => $season->slug,
                      ]],
                    ]);
                    if(count($seasonalcols) > 0) {
                      // If the season has collaborators, add it to the allowed seasons
                      $allowed_seasons[$year->slug][] = $season;
                    }
                  }
                }

              }
            }
          }
        }
        //error_log("Allowed years: " . implode(', ', array_map(function($year) { return $year->name; }, $allowed_years)));
        $hidden_years = '';
        if(count($allowed_years) < 2) {
          // If there's only one year, no need to show the filter
          $hidden_years = 'hidden';
        }
        ?>

        @if(count($allowed_years))
        <ul class="mobile-only:hidden flex list-none gap-x-1 sm:gap-x-2 gap-y-1 flex-wrap {{ $hidden_years }}">
          @foreach($allowed_years as $year)
            <li>
              <a
                class="collaborators-year
                  text-md md:text-sm 2xl:text-base py-2 px-5 md:py-[5px] md:px-[8px] 2xl:py-2 2xl:px-5 rounded-full  hover:bg-citrus transition-colors duration-300 overflow-ellipsis overflow-hidden whitespace-nowrap border border-charcoal inline-block
                  cursor-pointer
                  bg-chalk text-charcoal
                  @if($loop->first) !bg-charcoal !text-chalk @endif
                "
                data-year="{{ $year->slug }}"
              >
                {{ $year->name }}
              </a>
            </li>

            <?php
            $seasonButtons[$year->slug] = ''; // Initialize output

            ob_start(); // Start output buffering
            ?>
            @if(count($allowed_seasons[$year->slug]) > 1)
              @foreach($allowed_seasons[$year->slug] as $season)
                <li>
                  <a
                    class="collaborators-season
                      text-md md:text-sm 2xl:text-base py-2 px-5 md:py-[5px] md:px-[8px] 2xl:py-2 2xl:px-5 rounded-full  hover:bg-citrus transition-colors duration-300 overflow-ellipsis overflow-hidden whitespace-nowrap border border-charcoal inline-block
                      cursor-pointer
                      bg-chalk text-charcoal
                      @if($loop->first) !bg-charcoal !text-chalk @endif
                    "
                    data-year="{{ $year->slug }}"
                    data-season="{{ $season->slug }}"
                  >
                    {{ $season->name }}
                  </a>
                </li>
              @endforeach
            @endif
            <?php
            $seasonButtons[$year->slug] = ob_get_clean(); // Capture output buffer and clean it
            ?>
          @endforeach
        </ul>
        @endif

        @if(count($seasonButtons))
          @foreach($seasonButtons as $seasonButton)
          <ul class="mobile-only:hidden list-none gap-x-1 sm:gap-x-2 gap-y-1 flex-wrap
            @if(!$loop->first) hidden @else flex @endif"
          >
            {!! $seasonButton !!}
          </ul>
          @endforeach
        @endif
      </div>

      <div class="hidden lg:block col-span-2 lg:col-span-1"></div>
      @foreach($allowed_years as $year)
        <?php
          $currentYear  = $year->slug;
          $hidden_class = '';
          if(!$loop->first) $hidden_class= 'hidden';
        ?>
        @foreach($allowed_seasons[$currentYear] as $season)
          @php($collaborators = get_posts([
            'post_type' => 'collaborator',
            'posts_per_page' => -1,
            'tax_query' => [[
                'taxonomy' => 'collaborator-year',
                'field' => 'slug',
                'terms' => $currentYear,
              ],[
                'taxonomy' => 'collaborator-season',
                'field' => 'slug',
                'terms' => $season->slug,
            ]],
          ]))

          <div
            class="collaborators year-{{ $currentYear }} season-{{ $season->slug }}
              col-span-12 lg:col-span-9
              w-full max-w-[70%] lg:max-w-full
              mx-auto flex-1
              lg:relative
              {{ $hidden_class }}
              @if(!$loop->first) hidden @endif
              @if (count($collaborators) > 0) wrapper-carousel @endif
            "
          >
            <div class="collaborator-placeholder
                group
                hidden md:flex flex-col
                justify-end
                pr-2
                mb-[40px]"
            >
              <div class="">
                <div class="font-sans
                  text-lg lg:text-xl 2xl:text-3xl
                  mb-5 2xl:mb-7">&nbsp</div>
                <div class="mb-4">
                  <h2 class="font-serif
                    text-xl lg:text-xl 2xl:text-2xl
                    font-normal
                    line-clamp-1 lg:line-clamp-none
                  "><span class="italic">&nbsp</span> &nbsp</h2>
                  <p class="text-sm mt-3 font-serif line-clamp-1 lg:line-clamp-none">
                    <strong>&nbsp</strong> &nbsp</p>
                </div>
                <div class="hidden lg:block
                  aspect-[20/24] max-h-[18vw]
                  w-full
                  relative">
                  <img class="w-full h-full object-cover"
                    src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
                    alt=""
                  />
                </div>
                <div class="w-full
                    bg-cover bg-center bg-no-repeat
                    lg:hidden flex-1
                    relative"
                ></div>
              </div>
            </div>
            @if (count($collaborators) > 0)
              <?php
                ob_start();
                $output = '';
                foreach($collaborators as $collaborator):
                  $month = get_field('month', $collaborator);
                  // Check if the current month is previous to the month of the collaborator

                  $current_month = date('n'); // Numeric representation of the current month (1-12)
                  $current_year = date('Y'); // Current year

                  // Get the month and year of the collaborator
                  $year = null;
                  $year_terms= get_the_terms( $collaborator, 'collaborator-year' );
                  if (!empty($year_terms) && !is_wp_error($year_terms)) {
                    $collaborator_year = $year_terms[0]->name; //Year of the collaborator
                  } else {
                    continue;
                  }

                  if (is_null($collaborator_year)) {
                    continue;
                  }
                  //error_log("Year term for collaborator ". get_the_title($collaborator) .": " . $collaborator_year);

                  $collaborator_month = date('n', strtotime($month)); // Numeric representation of the collaborator's month (1-12)
                  //$collaborator_year = date('Y', strtotime($year->slug)); //

                  $is_current = ($current_month == $collaborator_month && $current_year == $collaborator_year);

                  $is_previous = ($current_year > $collaborator_year) ||
                                ($current_year == $collaborator_year && $current_month > $collaborator_month);

                  //error_log("Collaborator: ". get_the_title($collaborator).": Current month: $current_month, Collaborator month: $collaborator_month, Current year: $current_year, Collaborator year: $collaborator_year, Is current: $is_current, Is previous: $is_previous");
                  $is_active = $is_current || $is_previous;

                  $blocked_message = 'Published in '. $month;
                  if(get_field('block_collaborator', $collaborator)) {
                    $blocked_message = get_field('block_collaborator_message', $collaborator);
                    $is_active = false;
                  }
                ?>
                  <div class="collaborator
                    group
                    !flex flex-col
                    justify-end
                    pr-2
                  ">
                    <a href="{{ $is_active ? get_permalink($collaborator) : 'javascript:void(-1)' }}"
                      class="mbtb-only:flex mbtb-only:flex-1 mbtb-only:flex-col"
                    >
                      <div class="collaborator-month
                        font-sans
                        text-lg lg:text-xl 2xl:text-3xl
                        mb-5 2xl:mb-7">
                        {{ get_field('month', $collaborator) }}
                      </div>
                      <div class="mb-4">
                        <h2 class="font-serif
                          text-xl lg:text-xl 2xl:text-2xl
                          font-normal
                          line-clamp-1 lg:line-clamp-none
                        ">
                          @php($name = explode(' ', get_the_title($collaborator)))
                          <span class="italic">{{ $name[0] }}</span> {{ implode(' ', array_slice($name, 1)) }}
                        </h2>
                        <?php
                          $cv = '';
                          // Check if position and location exists, and add a comma if both are present
                          $position = '<strong>'.get_field('position', $collaborator) .'</strong>';
                          $location = get_field('location', $collaborator);
                          if ($position  && $location) {
                            $cv = $position. '<strong>,</strong> '.$location ;
                          } else {
                            $cv = get_field('position', $collaborator) . get_field('location', $collaborator);
                          }
                          ?>
                          @if($cv)
                          <p class="collborator-cv
                            text-sm mt-3 font-serif line-clamp-1 lg:line-clamp-none">
                            {!! $cv !!}
                          </p>
                          @endif
                      </div>
                      {{-- Desktop Image --}}
                      <div class="hidden lg:block
                        aspect-[20/24] max-h-[18vw]
                        w-full
                        group-hover:max-h-[24vw]
                        transition-all duration-300
                        relative">
                        <img
                          class="w-full h-full object-cover"
                          src="{{ get_the_post_thumbnail_url($collaborator) }}"
                          alt="{{ get_the_title($collaborator) }}"
                        />
                        @if (!$is_active)
                          <div class="absolute inset-0
                            bg-black bg-opacity-60
                            flex items-end justify-start
                            opacity-0 group-hover:opacity-100
                            transition-opacity duration-300">
                            <span class="font-serif italic
                              font-normal text-citrus text-sm
                              line-clamp-none
                              mb-2 ml-2">{{ $blocked_message }}</span>
                          </div>
                        @endif
                      </div>

                      {{-- Mobile Image --}}
                      <div
                        class="w-full
                          bg-cover bg-center bg-no-repeat
                          lg:hidden flex-1
                          relative"
                        style="background-image: url('{{ get_the_post_thumbnail_url($collaborator) }}')"
                      >
                        @if (!$is_active)
                          <div class="absolute inset-0
                            bg-black bg-opacity-60
                            flex items-end justify-start">
                            <span class="font-serif italic
                              font-normal text-citrus text-sm
                              line-clamp-none
                              mb-2 ml-2
                            ">Published in {{ $month }}</span>
                          </div>
                        @endif
                      </div>

                    </a>
                  </div>
                <?php

                endforeach;
                $output = ob_get_clean(); // Capture output buffer and clean it
                ?>

              <div
                class="flex gap-0 lg:my-8 lg:hidden tiny-carousel"
                data-autoplay-timeout="{{ get_field('slider_speed') }}"
              >
              {!! $output !!}
              </div>
              <div class="absolute
                hidden lg:flex  gap-0
                right-[40px] 2xl:right-[70px]
                bottom-[40px]"  >
              {!! $output !!}
              </div>
            @else
              <div class="lg:my-8 block lg:h-[418px] 2xl:h-[456px]">
                <span class="text-sm text-center font-medium">
                  {!! get_field('no_items_text', $year) !!}
                </span>
              </div>
            @endif
          </div>
        @endforeach
      @endforeach
    </div>
  </div>
@endsection
<!-- End /codigo/resources/views/template-collaborators.blade.php -->
