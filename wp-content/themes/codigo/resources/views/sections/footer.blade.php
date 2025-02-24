{{--
    @name Footer
    @desc The sites footer rendered on each page.
--}}

<!-- /codigo/resources/views/sections/footer.blade.php -->
<footer class="
    md:fixed bottom-0 w-full md:block hidden
    border-t border-charcoal
    pt-8 pb-10
    @option('footer_layout_container')
">
  <div class="flex justify-between">
    <ul class="flex list-none flex-1 flex-wrap">
      @php($menu_items = wp_get_nav_menu_items('Main Menu'))

      @foreach($menu_items as $item)
        <li class="mr-2 xl:mt-2 mt-1">
          <a
            href="{{ $item->url }}"
            class="
              text-sm py-1.5 px-5 rounded-full
              hover:text-chalk
              bg-chalk hover:bg-charcoal
              transition-colors duration-300
              border border-charcoal block
              leading-none text-center
              {{ $item->object_id == get_the_ID() ? 'bg-charcoal text-chalk' : 'text-charcoal' }}
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
              hover:text-chalk
              bg-chalk hover:bg-charcoal
              transition-colors duration-300
              border border-charcoal block
              leading-none text-center
              {{ $item->object_id == get_the_ID() ? 'bg-charcoal text-chalk' : 'text-charcoal' }}
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
          class="brand-footer xl:text-9xl lg:text-7xl text-6xl text-charcoal leading-[0.75]"
        >
          {{ __('Careers', 'codigo') }}
        </a>
      </div>
    </div>
  </div>
</footer>
