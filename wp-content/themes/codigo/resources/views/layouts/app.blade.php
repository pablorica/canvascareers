{{--
    @name Default
    @desc The default template with an outer wrapper grid as defined in tailwind.config.js. It makes sure all blocks on a page get evenly spaced without having to worry about margins or paddings.
--}}

<!-- /codigo/resources/views/layouts/app.blade.php -->
<a class="sr-only focus:not-sr-only" href="#main">
  {{ __('Skip to content') }}
</a>

@include('sections.header')

  <main id="main" class="main">
    @yield('content')
  </main>

  @hasSection('sidebar')
    <aside class="sidebar @option('header_layout_container')">
      @yield('sidebar')
    </aside>
  @endif

@include('sections.footer')
<!-- End /codigo/resources/views/layouts/app.blade.php -->