{{--
    @name Content Single Collaborator
    @desc The content layout for posts
--}}

<!-- /codigo/resources/views/partials/content-single-collaborator.blade.php -->
<article @php(post_class('h-entry h-full lg:pr-0 '.get_field("layout_container", "option") )) >
  <div class="grid grid-cols-12 w-full h-full">
    <div class="col-span-12 px-2 lg:hidden order-1">
      <h1 class="text-charcoal font-light text-xl
          flex gap-1 justify-between flex-wrap
          mt-2 pb-7 lg:hidden">
        <span class="block">{{ __('In Conversation:', 'codigo') }}</span>
        {{ get_the_title() }}
      </h1>

      <figure class="w-full">
        <img
          class="w-full h-full object-cover"
          src="{{ get_the_post_thumbnail_url(get_the_ID(), 'full') }}"
          alt="{{ get_the_title() }}"
        >
      </figure>
    </div>

    <div class="col-span-12 lg:col-span-5
      px-2 lg:pl-0 md:px-4 lg:pr-8 pb-10 lg:pb-0
      flex flex-col order-5 lg:order-2
    ">
      <div class="header-spacer hidden lg:block"></div>

      @php($portfolio_images = get_field('portfolio_images'))
      @if($portfolio_images)
        <div class="wrapper-carousel
          flex items-center flex-1
          md:my-5 lg:mx-0 lg:mt-0
        ">
          <div class="cursor-pointer prev-button hidden lg:block">
            <svg width="30" height="30" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
              <polyline points="30,10 15,25 30,40" stroke="black" stroke-width="2" fill="none"/>
            </svg>
          </div>

          <div class="carousel-single-collaborator
            h-full flex
            w-full lg:max-w-[75%] 2xl:max-w-[60%]
            mx-auto
          ">
            <div
              class="tiny-carousel h-full"
              data-responsive-items="false"
              data-mouse-drag="true"
              data-navigation="true"
            >
              @foreach($portfolio_images as $image)
                <div
                  class="w-full relative">
                  <img class=" absolute
                    {{ $image['fit_mode'] == 'cover' ?
                      'object-cover top-0 left-1/2 -translate-x-1/2 aspect-[20/25] h-full  w-auto'
                      : 'object-contain top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-auto  w-auto max-w-full max-h-full'
                    }}"
                  src="{{ $image['image'] }}"
                /></div>
              @endforeach
            </div>
          </div>

          <div class="cursor-pointer next-button hidden lg:block">
            <svg width="30" height="30" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
              <polyline points="20,10 35,25 20,40" stroke="black" stroke-width="2" fill="none"/>
            </svg>
          </div>
        </div>
      @endif
    </div>

    <div class="col-span-12 lg:col-span-4
      flex flex-col
      mt-8 lg:mt-0 order-3
    ">
      <div class="pb-5
        border-b lg:border-l lg:border-x border-charcoal
        px-4
        hidden lg:block
      ">
        <div class="pt-7 pb-6 flex justify-between items-center text-sm font-bold">
          <span>
            @php($years = get_the_terms(get_the_ID(), 'collaborator-year'))
            @if($years)
              @foreach($years as $year)
                {{ $year->name }}
                @if(!$loop->last)
                  <span class="mx-1">/</span>
                @endif
              @endforeach
            @endif
          </span>
          <span>
            {{ get_field('position') }}
          </span>
          <span>
            {{ get_field('location') }}
          </span>
        </div>
        <h1 class="md:text-4xl 2xl:text-5xl text-charcoal text-left lg:px-8 font-light">
          <span class="block">{{ __('In Conversation:', 'codigo') }}</span>
          {{ get_the_title() }}
        </h1>
      </div>

      <div class="relative flex-1
        lg:border-l lg:border-x border-charcoal
      ">
        <div class="text-md
          lg:overflow-y-auto lg:absolute lg:inset-x-4 lg:inset-y-3
          px-2 lg:pl-4 lg:pr-0
          py-2 scroll-rtl
        ">
          <div class="content transition-all duration-300 ease-in-out">
            @php(the_content())
          </div>
          <div class="hidden read-more text-center md:!hidden pt-20 pb-16">
            <a
              class="
                text-sm py-1.5 px-5 rounded-full
                mb-2 bg-chalk hover:bg-citrus w-[300px]
                transition-colors duration-300 max-w-full
                border border-charcoal cursor-pointer
                leading-none text-center inline-block
                overflow-ellipsis overflow-hidden whitespace-nowrap
              "
            >
              {{ __('Continue Reading', 'codigo') }}
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-span-3 py-1.5 px-4 hidden lg:block order-4">
      @php($years = get_terms('collaborator-year', ['hide_empty' => false]))
      @foreach($years as $year)
        <div class="py-7 2xl:py-8 border-b border-charcoal">
          @php($description_title = get_field('description_title', $year))
          @if(!empty($year->description) || !empty($description_title))
            <div class="accordion-before-{{ $loop->index }} max-h-0 transition-all duration-300 ease-in-out overflow-hidden">
              <h3 class="text-xl font-light font-sans">
                {{ $description_title }}
              </h3>
              <p class="text-md mt-4 !mb-7">
                {!! nl2br($year->description) !!}
              </p>
            </div>
          @endif

          <div class="flex justify-between items-center text-2xl 2xl:text-3xl font-sans button-collapse cursor-pointer">
            {{ $year->name }}
            <svg class="transition-transform duration-300 icon-{{ $loop->index }}" width="25" height="25" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
              <line x1="25" y1="10" x2="25" y2="40" stroke="black" stroke-width="1.5"></line>
              <line x1="10" y1="25" x2="40" y2="25" stroke="black" stroke-width="1.5"></line>
            </svg>
          </div>
          <div
            id="collapse-{{ $loop->index }}"
            class="accordion-collapse overflow-hidden max-h-0 transition-all duration-300 ease-in-out"
            aria-labelledby="heading{{ $loop->index }}"
            data-bs-parent="#accordionExample"
          >
            <div class="accordion-body pt-7 2xl:pt-8 inline-flex flex-col max-w-full">
              @php($collaborators = get_posts([
                'post_type' => 'collaborator',
                'posts_per_page' => -1,
                'tax_query' => [[
                  'taxonomy' => 'collaborator-year',
                  'field' => 'slug',
                  'terms' => $year->slug,
                ]],
              ]))

              @if(count($collaborators) > 0)
                @foreach($collaborators as $collaborator)
                  <a
                    href="{{ get_permalink($collaborator) }}"
                    class="
                      text-sm py-1.5 px-5 rounded-full
                      mb-2 bg-chalk hover:bg-citrus
                      transition-colors duration-300
                      border border-charcoal
                      leading-none text-center
                      overflow-ellipsis overflow-hidden whitespace-nowrap
                      @if($collaborator->ID == get_the_ID()) !bg-charcoal !text-chalk @endif
                    "
                  >
                    {{ get_field('position', $collaborator) }} | {{ get_the_title($collaborator) }}
                  </a>
                @endforeach
              @else
                <span class="text-sm text-center">
                  {!! get_field('no_items_text', $year) !!}
                </span>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</article>
<!-- End /codigo/resources/views/partials/content-single-collaborator.blade.php -->
