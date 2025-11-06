{{--
    @name Default
    @desc The default template with an outer wrapper grid as defined in tailwind.config.js. It makes sure all blocks on a page get evenly spaced without having to worry about margins or paddings.

    mb-auto
    xl:!border-b-0 !border-r-0 xl:!border-r-[1px]
    max-w-[260px] max-w-[280px] 2xl:max-w-full
    bg-contain bg-cover
--}}

<!-- /codigo/resources/views/layouts/app.blade.php -->
<a class="sr-only focus:not-sr-only" href="#main">
  {{ __('Skip to content') }}
</a>

@include('sections.header')

  <main
    id="main"
    class="main
      @if( get_field('mobile_bigheaderfooter',get_the_ID()) ) mb-0 @endif
      @if( get_field('pagination',get_the_ID()) ) relative @endif
    "
  >
    @yield('content')
  </main>

  @hasSection('sidebar')
    <aside class="sidebar @option('header_layout_container')">
      @yield('sidebar')
    </aside>
  @endif

@include('sections.footer')
<!-- End /codigo/resources/views/layouts/app.blade.php -->
