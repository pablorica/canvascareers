<div class="fluid-container pt-5 pb-0 flex flex-col h-full">
  <div>
    <div class="flex flex-wrap items-center justify-between w-full">
      <div>
        <a
          href="{{ home_url('/') }}"
          class="brand-header text-7xl text-chalk leading-[0.75]"
        >
          {{ __('Canvas', 'codigo') }}
        </a>
      </div>
      <button
        aria-label="Toggle Menu"
        class="px-2 py-1 ml-auto md:hidden"
        aria-expanded="false"
        @click="this.toggleMenu"
      >
        <svg
          class="transition-transform duration-300"
          :class="{ 'rotate transform rotate-45': this.menuCollapse }"
          width="35" height="35" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg"
        >
          <circle cx="25" cy="25" r="22" stroke="#E6E1DC" stroke-width="1.5" fill="none"></circle>
          <line x1="25" y1="10" x2="25" y2="40" stroke="#E6E1DC" stroke-width="1.5"></line>
          <line x1="10" y1="25" x2="40" y2="25" stroke="#E6E1DC" stroke-width="1.5"></line>
        </svg>
      </button>
    </div>

    <ul class="grid list-none mt-6 w-full grid-cols-2 gap-2">
      @php($menu_items = wp_get_nav_menu_items('Jobs Filters Menu'))

      @foreach($menu_items as $item)
        <li>
          <a
            href="{{ $item->url }}"
            class="
              text-md py-2 px-5 rounded-full
              bg-charcoal hover:bg-citrus
              transition-colors duration-300
              border border-chalk block hover:border-citrus
              leading-none text-center hover:text-charcoal
              overflow-ellipsis overflow-hidden whitespace-nowrap
              {{ $item->object_id == get_the_ID() ? '!bg-chalk !text-charcoal' : 'text-chalk' }}
            "
          >
            {{ $item->title }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  <div class="flex-1 flex justify-center flex-col">
    <div class="mb-12 flex flex-col-reverse gap-2.5">
      @php($menu_items = wp_get_nav_menu_items('Main Menu'))

      @foreach($menu_items as $item)
        <a
          href="{{ $item->url }}"
          class="
            text-3xl leading-none
            hover:text-citrus block
            transition-colors duration-300
            {{ $item->object_id == get_the_ID() ? '!text-citrus' : 'text-chalk' }}
          "
        >
          {{ $item->title }}
        </a>
      @endforeach
    </div>
    <div class="flex flex-col-reverse gap-2.5">
      @php($menu_items = wp_get_nav_menu_items('Secondary Menu'))

      @foreach($menu_items as $item)
        <a
          href="{{ $item->url }}"
          class="
            text-3xl leading-none
            hover:text-citrus block
            transition-colors duration-300
            {{ $item->object_id == get_the_ID() ? '!text-citrus' : 'text-chalk' }}
          "
        >
          {{ $item->title }}
        </a>
      @endforeach
    </div>
  </div>

  <div class="py-1">
      <div class="md:hidden text-right">
        <a
          href="{{ home_url('/') }}"
          class="brand-footer text-7xl text-chalk"
        >
          {{ __('Careers', 'codigo') }}
        </a>
      </div>
  </div>
</div>
