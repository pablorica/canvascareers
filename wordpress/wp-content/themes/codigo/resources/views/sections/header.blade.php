{{--
    @name Header
    @desc The sites header rendered on each page.
--}}
<!-- /resources/views/sections/header.blade.php -->
<header
  id="mainMenu"
  class="banner w-full
    sticky top-0 z-50
    lg:static
    bg-chalk lg:bg-opacity-0
    {{ get_field('fixed_header') || is_singular('collaborator') ? 'lg:fixed lg:top-0 lg:w-auto' : '' }}"
>
  <nav
    class="nav-primary @option('header_layout_container') py-5 relative"
    aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
  >
    <div class="flex flex-wrap items-center justify-between w-full lg:w-auto">
      @if (is_front_page())
        {{-- Animation Brand --}}
        <div class="splash-logo splash-logo--header">
          <a
            href="{{ home_url('/') }}"
            class="brand-header
            text-7xl md:text-8xl 2xl:text-9xl
            text-charcoal leading-[0.75]"
          >
            <span class="hidden md:block
              @if( get_field('mobile_bigheaderfooter',get_the_ID()) ) !block @endif"
            >{{ __('Canvas', 'codigo') }}</span>
          </a>
        </div>
        {{-- End Animated Brand --}}
      @endif
      <a
        href="{{ home_url('/') }}"
        class="brand-header
        text-7xl md:text-8xl 2xl:text-9xl
        text-charcoal leading-[0.75]"
      >
        <span class="hidden md:block
          @if( get_field('mobile_bigheaderfooter',get_the_ID()) ) !block @endif"
        >{{ __('Canvas', 'codigo') }}</span>
        <span class="h-[56px] block md:hidden @if( get_field('mobile_bigheaderfooter',get_the_ID()) ) !hidden @endif">
          <svg class="h-full" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 1000 430.4" xml:space="preserve">
            <g>
              <path class="fill-charcoal" d="M37,119.1C37,64.3,74.9,37,115.9,37c37.1,0,64,20.4,69.7,52.3L159,95c-4.6-21.5-20.9-34.6-43.1-34.6   c-29.3,0-51.6,20.6-51.6,58.7c0,38.1,22,58.5,51.6,58.5c22.5,0,37.6-12.1,42.6-32.3l26.8,5.7c-7.8,30.9-33.5,50.2-69.5,50.2   C74.4,201.2,37,173.9,37,119.1z M247.8,101.7c-14,0-23.8,8.3-25.4,22l-22.5-4.1c3.7-22.7,23.4-37.6,47.9-37.6   c29.3,0,49.5,16.5,49.5,45.4v72h-24.5v-17.6c-6.6,11.7-20.9,19.5-36.2,19.5c-22.9,0-38.7-14.4-38.7-34.2   c0-22.7,17.6-34.8,53.2-38.5l21.8-2.3v-1.6C272.8,110.4,262.9,101.7,247.8,101.7z M241.6,181.9c19.5,0,30.9-13.5,31.2-32.3v-4.8   l-22,2.5c-18.8,2.1-28.4,8.9-28.4,19C222.4,175.5,229.9,181.9,241.6,181.9z M322.9,83.8h25v19.3c7.8-12.4,21.1-21.1,38-21.1   c24.5,0,41.7,16.3,41.7,41.3v76.1h-25V129c0-14.4-8.9-24.5-23.6-24.5c-19.5,0-31.2,16.5-31.2,44.2v50.7h-25V83.8z M436.6,83.8H462   l28.7,86.4l28.7-86.4H545l-42.2,115.5h-24.1L436.6,83.8z M598.4,101.7c-14,0-23.8,8.3-25.4,22l-22.5-4.1   c3.7-22.7,23.4-37.6,47.9-37.6c29.3,0,49.5,16.5,49.5,45.4v72h-24.5v-17.6c-6.6,11.7-20.9,19.5-36.2,19.5   c-22.9,0-38.7-14.4-38.7-34.2c0-22.7,17.6-34.8,53.2-38.5l21.8-2.3v-1.6C623.4,110.4,613.5,101.7,598.4,101.7z M592.2,181.9   c19.5,0,30.9-13.5,31.2-32.3v-4.8l-22,2.5c-18.8,2.1-28.4,8.9-28.4,19C572.9,175.5,580.5,181.9,592.2,181.9z M663.9,167.2l20.6-8.7   c3.9,12.4,12.8,22.7,28.9,22.7c11.9,0,19.9-6.9,19.9-15.1c0-25-64.4-8.7-64.4-52.5c0-18.1,15.8-31.6,40.8-31.6   c21.8,0,40.1,11.5,45.2,28.4l-20.6,8.7c-3-11.5-13.8-17.9-24.3-17.9c-11,0-17.9,4.4-17.9,11.9c0,22.2,64.9,5.3,64.9,52.7   c0,19.9-17.4,35.3-43.6,35.3C685.2,201.2,669.1,183.7,663.9,167.2z"/>
              <path class="fill-charcoal" d="M167.1,311.3c0-54.8,37.8-82.1,78.8-82.1c37.1,0,64,20.4,69.7,52.3l-26.6,5.7c-4.6-21.5-20.9-34.6-43.1-34.6   c-29.3,0-51.6,20.6-51.6,58.7s22,58.5,51.6,58.5c22.5,0,37.6-12.1,42.6-32.3l26.8,5.7c-7.8,30.9-33.5,50.2-69.5,50.2   C204.5,393.3,167.1,366,167.1,311.3z M377.9,293.8c-14,0-23.8,8.3-25.4,22l-22.5-4.1c3.7-22.7,23.4-37.6,47.9-37.6   c29.3,0,49.5,16.5,49.5,45.4v72h-24.5v-17.6c-6.6,11.7-20.9,19.5-36.2,19.5c-22.9,0-38.7-14.4-38.7-34.2   c0-22.7,17.6-34.8,53.2-38.5l21.8-2.3v-1.6C402.9,302.5,393,293.8,377.9,293.8z M371.7,374.1c19.5,0,30.9-13.5,31.2-32.3v-4.8   l-22,2.5c-18.8,2.1-28.4,8.9-28.4,19C352.5,367.6,360,374.1,371.7,374.1z M509.8,297.5c-17,0-31.9,15.1-31.9,50.9v43.1h-25V276h25   v22c6.2-13.8,21.3-23.8,35.3-23.8c4.4,0,9.4,0.7,12.8,2.1l-1.4,24.1C520.6,298.4,515.1,297.5,509.8,297.5z M588.3,274.1   c37.1,0,56.8,27,56.8,55.2c0,3.4-0.2,8.3-0.5,10.3h-88.2c2.3,19.9,15.1,32.3,33.5,32.3c15.1,0,25.9-7.1,28.9-19.7l23.6,6   c-6.2,22.2-25.9,35.1-52.9,35.1c-36.7,0-57.5-28.4-57.5-59.6C531.9,302.5,551.6,274.1,588.3,274.1z M618.5,320.7   c-1.6-15.6-11.9-26.8-30.3-26.8c-15.8,0-27,9.6-30.7,26.8H618.5z M714.6,274.1c37.1,0,56.8,27,56.8,55.2c0,3.4-0.2,8.3-0.5,10.3   h-88.2c2.3,19.9,15.1,32.3,33.5,32.3c15.1,0,25.9-7.1,28.9-19.7l23.6,6c-6.2,22.2-25.9,35.1-52.9,35.1c-36.7,0-57.5-28.4-57.5-59.6   C658.2,302.5,677.9,274.1,714.6,274.1z M744.8,320.7c-1.6-15.6-11.9-26.8-30.3-26.8c-15.8,0-27,9.6-30.7,26.8H744.8z M848.1,297.5   c-17,0-31.9,15.1-31.9,50.9v43.1h-25V276h25v22c6.2-13.8,21.3-23.8,35.3-23.8c4.4,0,9.4,0.7,12.8,2.1l-1.4,24.1   C858.9,298.4,853.4,297.5,848.1,297.5z M869.9,359.4l20.6-8.7c3.9,12.4,12.8,22.7,28.9,22.7c11.9,0,19.9-6.9,19.9-15.1   c0-25-64.4-8.7-64.4-52.5c0-18.1,15.8-31.6,40.8-31.6c21.8,0,40.1,11.5,45.2,28.4l-20.6,8.7c-3-11.5-13.8-17.9-24.3-17.9   c-11,0-17.9,4.4-17.9,11.9c0,22.2,64.9,5.3,64.9,52.7c0,19.9-17.4,35.3-43.6,35.3C891.2,393.3,875.2,375.9,869.9,359.4z"/>
            </g>
          </svg>
        </span>
      </a>
      <button
        aria-label="Toggle Menu"
        class="toggle-button
          collaborator-fade-in-up
          px-2 py-1 ml-auto md:hidden"
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

    <ul
      class="grid list-none mt-6
        w-full md:max-w-[300px] 2xl:max-w-[400px]
        grid-cols-2 gap-2 md:z-10 relative
      {{ get_field('fixed_header') ? 'md:min-w-[300px] 2xl:min-w-[400px]' : '' }}"
    >
      @php($menu_items = wp_get_nav_menu_items('Jobs Filters Menu'))

      @foreach($menu_items as $item)
        <li>
          <a
            href="{{ $item->url }}"
            class="block
              leading-none text-center
            ">
            <span data-title="{{ $item->title }}"
              class="button-menu growing-button
                text-md md:text-sm 2xl:text-base
                py-2 px-5 md:py-[5px] md:px-[8px] 2xl:py-2 2xl:px-5
                rounded-full
                bg-chalk hover:bg-citrus
                transition-colors duration-300
                overflow-ellipsis overflow-hidden whitespace-nowrap
                border border-charcoal inline-block
                {{ $item->object_id == get_the_ID() ? '!bg-charcoal !text-chalk' : 'text-charcoal' }}
            ">{{ $item->title }}</span>
          </a>
        </li>
      @endforeach
    </ul>

    @if(is_page_template('template-jobs.blade.php'))
      @include('partials.jobs-tags')
    @endif

    <div
      class="fixed inset-0 mobile-menu bg-charcoal animate-appearsmenu"
      style="display: none;"
      v-show="this.menuCollapse"
    >
     @include('partials.mobile-menu')
    </div>
  </nav>
</header>

<!-- End /resources/views/sections/header.blade.php -->
