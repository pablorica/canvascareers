{{--
    @name Header
    @desc The sites header rendered on each page.
--}}
<!-- /resources/views/sections/header.blade.php -->
<header id="mainMenu" class="banner w-full">
  <nav
    class="nav-primary @option('header_layout_container') py-5"
    aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
  >
    <div class="flex flex-wrap items-center justify-between w-full lg:w-auto">
      <div>
        <a
          href="{{ home_url('/') }}"
          class="brand-header xl:text-9xl text-7xl text-charcoal leading-[0.75]"
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
          <circle cx="25" cy="25" r="22" stroke="black" stroke-width="1.5" fill="none"></circle>
          <line x1="25" y1="10" x2="25" y2="40" stroke="black" stroke-width="1.5"></line>
          <line x1="10" y1="25" x2="40" y2="25" stroke="black" stroke-width="1.5"></line>
        </svg>
      </button>
    </div>

    <ul class="grid list-none mt-6 w-full md:max-w-[400px] grid-cols-2 gap-2">
      @php($menu_items = wp_get_nav_menu_items('Jobs Filters Menu'))

      @foreach($menu_items as $item)
        <li>
          <a
            href="{{ $item->url }}"
            class="
              text-md py-2 px-5 rounded-full
              hover:text-chalk
              bg-chalk hover:bg-charcoal
              transition-colors duration-300
              border border-charcoal block
              leading-none text-center
              overflow-ellipsis overflow-hidden whitespace-nowrap
              {{ $item->object_id == get_the_ID() ? 'bg-charcoal text-chalk' : 'text-charcoal' }}
            "
          >
            {{ $item->title }}
          </a>
        </li>
      @endforeach
    </ul>

    @if (has_nav_menu('primary_navigation'))
      <div
        :class="{ hidden: !this.menuCollapse }"
        class="text-center lg:flex lg:items-center"
      >
        <!-- Mobile Menu -->
      </div>
    @endif
  </nav>
</header>
<!-- End /resources/views/sections/header.blade.php -->
