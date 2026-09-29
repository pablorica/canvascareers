{{--
  Template Name: Home
--}}

@extends('layouts.app')

<!-- /codigo/resources/views/template-home.blade.php -->
@section('content')
  <div id="home"
    class="@option('layout_container')
      flex w-full flex-col md:flex-row md:pr-0"
  >
    @php($collaborator = get_field('collaborator'))

    @if($collaborator)
      <div class="w-full md:w-[410px] 2xl:w-[455px] flex-shrink-0 flex flex-col">
        <div class="header-spacer hidden md:block"></div>
        <div class="md:flex-1 flex flex-col justify-center items-start">
          <span class="block
            text-md md:text-lg
            collaborator-fade-in-up
          ">
            {{ get_field('home_intro_label', $collaborator) }}
          </span>
          <?php
          $home_description = get_field('home_description', $collaborator);
           // Ensure $home_description is not null or empty before applying filters
          if (!empty($home_description)) {
              $collaborator_description = apply_filters('the_content', $home_description);
          } else {
              $collaborator_description = 'No description available.';
          }


          $collaborator_permalink = get_permalink( $collaborator );
          // $cta_permalink = $collaborator_permalink;
          // if( !get_field('cta_collaborator_linked', $collaborator)
          //   && get_field('cta_url', $collaborator)
          // ) {
          //   $cta_permalink = get_field('cta_url', $collaborator);
          // }
          //error_log('cta_collaborator_linked: '.get_field('cta_collaborator_linked', $collaborator));
          //error_log('cta_url: '.get_field('cta_url', $collaborator));

          //$cta_target = get_field('cta_collaborator_target', $collaborator) ? '_blank' : '_self'
          ?>
          <a href="{{ $collaborator_permalink }}"
            class="group relative inline-block"
          >
            <h2 class="text-md md:text-3xl 2xl:text-4xl
              font-serif font-light md:font-normal
              mt-4 md:mt-6
              collaborator-fade-in-up
              relative inline-block
              before:absolute before:bottom-[4px] before:left-0
              before:h-[1px] before:w-0 before:bg-black
              before:transition-all before:duration-[0.6s]
              group-hover:before:w-full
            ">
              @php($name = explode(' ', $collaborator->post_title))
              <span class="italic">{{ $name[0] }}</span> {{ implode(' ', array_slice($name, 1)) }}
            </h2>
          </a>
          <span class="block
            text-md md:text-sm 2xl:text-base
            mt-1 md:mt-6
            collaborator-fade-in-up
          ">
            {{ get_field('home_headline', $collaborator) }}
          </span>
          <div class="text-md md:text-sm 2xl:text-base
            mt-4 mb-4
            max-w-[215px] 2xl:max-w-[260px]
            hidden md:block
            collaborator-fade-in-up
          ">
            {!! $collaborator_description !!}
          </div>
          <?php
            $cta = get_field('cta', $collaborator);
            //error_log('CTA: '.print_r($cta, true));
            $cta_target = '_self';
            $cta_permalink = '/collaborators';
            $cta_label = 'Discover our Collaborators';
            if(is_array($cta)) {
              $cta_target = $cta['target'] ? $cta['target'] : '_self';
              $cta_permalink = $cta['url'];
              $cta_label = $cta['title'];
              //$cta_label = get_field('cta_label', $collaborator)
            }
          ?>

          <a
            href="{{ $cta_permalink }}"
            class="
              text-md md:text-sm 2xl:text-base
              py-2 px-7 rounded-full
              mb-8 mt-3
              bg-chalk hover:bg-citrus
              transition-colors duration-300
              border border-charcoal md:inline-block
              leading-none text-center hidden
              overflow-ellipsis overflow-hidden whitespace-nowrap
              collaborator-fade-in-up
            "
            target = "{{ $cta_target }}"
          >{{ $cta_label }}</a>
        </div>
      </div>
      <div
        class=" flex-1
          mt-6 md:mt-0 md:mr-0
          relative"
      >

      @php($media_type = get_field('home_media_type', $collaborator->ID) ?: 'images')
      @php($video = get_field('home_video', $collaborator->ID))
      @php($video_poster = get_field('home_video_poster', $collaborator->ID))
      @php($first_image = get_field('home_first_image', $collaborator->ID))
      @php($second_image = get_field('home_second_image', $collaborator->ID))

      @if($media_type === 'video' && !empty($video['url']))
        <div class="flex h-full">
          <figure class="group w-full
            p-0 relative overflow-hidden bg-charcoal
            collaborator-fade-in-up
          " data-home-video>
            {{-- No autoplay attribute: playback is started from JS so we can
                 catch blocked autoplay and respect prefers-reduced-motion --}}
            <video
              class="w-full h-full object-cover absolute inset-0"
              muted
              playsinline
              loop
              preload="metadata"
              @if($video_poster) poster="{{ $video_poster }}" @endif
              aria-label="{{ $collaborator->post_title }}"
            >
              <source src="{{ $video['url'] }}" type="{{ $video['mime_type'] ?? 'video/mp4' }}">
            </video>

            {{-- Fallback play button, shown only if autoplay is blocked or reduced motion is on --}}
            <button type="button"
              class="hidden
                absolute inset-0 z-10 m-auto
                w-20 h-20 rounded-full
                flex items-center justify-center
                bg-chalk/90 hover:bg-citrus text-charcoal
                border border-charcoal
                transition-colors duration-300
                focus:outline-none focus-visible:ring-2 focus-visible:ring-citrus focus-visible:ring-offset-2
              "
              aria-label="Play video"
              data-video-play
            >
              <svg class="w-7 h-7 ml-1" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M7 4.5v15l13-7.5z"/>
              </svg>
            </button>

            {{-- Controls, bottom-right. Hidden until the video is hovered or a
                 control has keyboard focus; always visible on touch screens,
                 which have no hover. --}}
            <div class="absolute bottom-4 right-4 md:bottom-6 md:right-6 z-10
                flex gap-2
                opacity-0 group-hover:opacity-100 group-focus-within:opacity-100
                [@media(hover:none)]:opacity-100
                transition-opacity duration-300
              "
              data-video-controls
            >
              {{-- Play / pause --}}
              <button type="button"
                class="w-11 h-11 rounded-full
                  flex items-center justify-center
                  bg-chalk/90 hover:bg-citrus text-charcoal
                  border border-charcoal
                  transition-colors duration-300
                  focus:outline-none focus-visible:ring-2 focus-visible:ring-citrus focus-visible:ring-offset-2
                "
                aria-label="Play video"
                data-video-toggle
              >
                {{-- Play icon --}}
                <svg class="w-5 h-5 ml-0.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-icon-play>
                  <path d="M7 4.5v15l13-7.5z"/>
                </svg>
                {{-- Pause icon --}}
                <svg class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" data-icon-pause>
                  <path d="M7 5h3.5v14H7zM13.5 5H17v14h-3.5z"/>
                </svg>
              </button>

              {{-- Sound toggle --}}
              <button type="button"
                class="w-11 h-11 rounded-full
                  flex items-center justify-center
                  bg-chalk/90 hover:bg-citrus text-charcoal
                  border border-charcoal
                  transition-colors duration-300
                  focus:outline-none focus-visible:ring-2 focus-visible:ring-citrus focus-visible:ring-offset-2
                "
                aria-label="Turn sound on"
                aria-pressed="false"
                data-video-sound
              >
                {{-- Muted icon --}}
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" data-icon-muted>
                  <path d="M4 9h4l5-4v14l-5-4H4z" fill="currentColor"/>
                  <path d="M17 9l5 6M22 9l-5 6" stroke-linecap="round"/>
                </svg>
                {{-- Sound on icon --}}
                <svg class="w-5 h-5 hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true" data-icon-sound>
                  <path d="M4 9h4l5-4v14l-5-4H4z" fill="currentColor"/>
                  <path d="M16.5 8.5a5 5 0 0 1 0 7M19 6a8.5 8.5 0 0 1 0 12" stroke-linecap="round"/>
                </svg>
              </button>
            </div>
          </figure>
        </div>
      @elseif($first_image && $second_image)
        <div class="flex flex-wrap h-full gap-0">
          <figure class="w-full lg:w-1/2
            p-0 relative
            collaborator-fade-in-up
          ">
            <img
              class="w-full h-full object-cover absolute inset-0"
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
              class="w-full h-full object-cover absolute inset-0"
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
          href="{{ $cta_permalink }}"
          class="collaborator-link
            text-md text-white underline
            leading-none text-center md:hidden
            absolute bottom-6 left-0 right-0
            collaborator-fade-in-up
          "
          target = "{{ $cta_target }}"
        >{{ $cta_label }}</a>
      </div>
    @endif
  </div>
@endsection
<!-- End /codigo/resources/views/template-home.blade.php -->