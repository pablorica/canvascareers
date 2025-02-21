{{--
    @name Header
    @desc The sites header rendered on each page.
--}}
<!-- /resources/views/sections/header.blade.php -->
<header id="mainMenu"
  class="banner w-full">
    <nav class="relative
        flex
        flex-wrap
        items-center
        justify-between
        py-8
        mx-auto
        lg:justify-between
        nav-primary
        @option('header_layout_container')
        "
        aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
    >
        <div class="flex flex-wrap items-center justify-between w-full lg:w-auto">
            <a class="brand" href="{{ home_url('/') }}">
                {!! $siteName !!}
            </a>
            <button aria-label="Toggle Menu"
                class="px-2 py-1 ml-auto text-gray-500 rounded-md lg:hidden hover:text-indigo-500 focus:text-indigo-500 focus:bg-indigo-100 focus:outline-none dark:text-gray-300 dark:focus:bg-trueGray-700" id=""
                type="button"
                aria-expanded="false"
                @click="this.toggleMenu"
            >
              <svg v-if="this.menuCollapse"
                class="w-6 h-6 fill-current"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
              ><path fill-rule="evenodd"
                clip-rule="evenodd"
                d="M18.278 16.864a1 1 0 0 1-1.414 1.414l-4.829-4.828-4.828 4.828a1 1 0 0 1-1.414-1.414l4.828-4.829-4.828-4.828a1 1 0 0 1 1.414-1.414l4.829 4.828 4.828-4.828a1 1 0 1 1 1.414 1.414l-4.828 4.829 4.828 4.828z"
                ></path
              ></svg>
                <svg v-if="!this.menuCollapse"
                class="w-6 h-6 fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                >
                    <path fill-rule="evenodd"
                        d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"></path>
                </svg>
            </button>
        </div>
        @if (has_nav_menu('primary_navigation'))
        <div :class="{ hidden: !this.menuCollapse }"
          class="text-center lg:flex lg:items-center"
          >

            {!! wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'menu_class' => 'nav items-center justify-end flex-1 pt-6 list-none lg:pt-0 lg:flex',
                'echo' => false,
            ]) !!}
        </div>
        @endif

        <div class="hidden mr-3 space-x-4 lg:flex nav__item">
            <a class="px-6 py-2 text-white bg-indigo-600 rounded-md md:ml-5" href="/">Get Started</a>
            <div class="flex items-center">
                <button class="text-gray-500 rounded-full outline-none focus:outline-none focus-visible:ring focus-visible:ring-gray-100 focus:ring-opacity-20">
                    <span class="sr-only">Dark Mode</span>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="5"></circle>
                        <path d="M12 1v2M12 21v2M4.2 4.2l1.4 1.4M18.4 18.4l1.4 1.4M1 12h2M21 12h2M4.2 19.8l1.4-1.4M18.4 5.6l1.4-1.4"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>
</header>
<!-- End /resources/views/sections/header.blade.php -->
