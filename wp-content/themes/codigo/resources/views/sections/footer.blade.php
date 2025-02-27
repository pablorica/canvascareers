{{--
    @name Footer
    @desc The sites footer rendered on each page.
--}}

<!-- /codigo/resources/views/sections/footer.blade.php -->
<footer class="
    w-full
    md:border-t border-charcoal
    py-1 md:pt-8 md:pb-10 bg-chalk
    @option('footer_layout_container')
    @if(!is_front_page()) hidden md:block @endif
">
  <div class="justify-between md:flex hidden">
    <ul class="flex list-none flex-1 flex-wrap">
      @php($menu_items = wp_get_nav_menu_items('Main Menu'))

      @foreach($menu_items as $item)
        <li class="mr-2 xl:mt-2 mt-1">
          <a
            href="{{ $item->url }}"
            class="
              text-sm py-1.5 px-5 rounded-full
              bg-chalk hover:bg-citrus
              transition-colors duration-300
              border border-charcoal block
              leading-none text-center
              {{ $item->object_id == get_the_ID() ? '!bg-charcoal !text-chalk' : 'text-charcoal' }}
            "
          >
            {{ $item->title }}
          </a>
        </li>
      @endforeach
    </ul>

    <div class="flex">
      <ul class="flex list-none 2xl:mr-10 xl:mr-6 mr-2">
        @php($menu_items = wp_get_nav_menu_items('Secondary Menu'))

        @foreach($menu_items as $item)
          <li class="mr-2 xl:mt-2 mt-1">
            <a
              href="{{ $item->url }}"
              class="
              text-sm py-1.5 px-5 rounded-full
              bg-chalk hover:bg-citrus
              transition-colors duration-300
              border border-charcoal block
              leading-none text-center
              {{ $item->object_id == get_the_ID() ? '!bg-charcoal !text-chalk' : 'text-charcoal' }}
            "
            >
              {{ $item->title }}
            </a>
          </li>
        @endforeach
      </ul>
      <div>
        <a
          href="{{ home_url('/') }}"
          class="brand-footer xl:text-9xl text-7xl text-charcoal leading-[0.75]"
        >
          {{ __('Careers', 'codigo') }}
        </a>
      </div>
    </div>
  </div>

  <div class="md:hidden text-right">
    <a
      href="{{ home_url('/') }}"
      class="brand-footer xl:text-9xl text-7xl text-charcoal"
    >
      {{ __('Careers', 'codigo') }}
    </a>
  </div>
</footer>
