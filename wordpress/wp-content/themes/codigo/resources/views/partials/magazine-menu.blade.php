{{--
    @name Magazine Menu
    @desc Hidden site menu on magazine articles. Slides in from the left on desktop
          (see resources/scripts/modules/magazineMenu.js).
--}}
<!-- /resources/views/partials/magazine-menu.blade.php -->
<div class="magazine-menu" data-magazine-menu>
  <div class="magazine-menu__zone" data-magazine-menu-zone aria-hidden="true"></div>

  <nav class="magazine-menu__panel" aria-label="{{ __('Site menu', 'codigo') }}">
    <div>
      <a
        href="{{ home_url('/') }}"
        class="brand-header block no-underline text-7xl md:text-8xl 2xl:text-9xl text-charcoal leading-[0.75]"
      >{{ __('Canvas', 'codigo') }}</a>

      @if($jobLinks)
        <ul class="magazine-menu__jobs grid grid-cols-2 gap-2 list-none mt-6">
          @foreach($jobLinks as $item)
            <li>
              <a href="{{ $item->url }}" class="block leading-none text-center no-underline">
                <span class="magazine-menu__button text-sm 2xl:text-base py-[5px] px-[8px] 2xl:py-2 2xl:px-5 rounded-full bg-chalk hover:bg-citrus text-charcoal transition-colors duration-300 border border-charcoal block whitespace-nowrap">{{ $item->title }}</span>
              </a>
            </li>
          @endforeach
        </ul>
      @endif
    </div>

    @if($collaboratorsTitle)
      <div class="magazine-menu__collaborators">
        <a href="{{ $collaboratorsUrl }}" class="h4 block no-underline text-xl 2xl:text-3xl">{{ $collaboratorsTitle }}</a>

        <div class="magazine-menu__intro text-sm 2xl:text-md mt-6">
          {!! $collaboratorsIntro !!}
        </div>

        @if($years)
          <ul class="flex flex-wrap gap-2 list-none mt-6">
            @foreach($years as $year)
              <li>
                <a
                  href="{{ add_query_arg('filter-year', $year->slug, $collaboratorsUrl) }}"
                  class="text-sm 2xl:text-base py-[5px] px-[8px] 2xl:py-2 2xl:px-5 rounded-full bg-chalk hover:bg-citrus text-charcoal transition-colors duration-300 border border-charcoal inline-block no-underline"
                >{{ $year->name }}</a>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    @endif
  </nav>
</div>
<!-- End /resources/views/partials/magazine-menu.blade.php -->
