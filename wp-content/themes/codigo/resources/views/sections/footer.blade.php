{{--
    @name Footer
    @desc The sites footer rendered on each page.
--}}

<!-- /codigo/resources/views/sections/footer.blade.php -->
<footer class="footer
    w-full
    md:border-t border-charcoal
    py-1 md:pt-5 md:pb-7 bg-chalk
    @option('footer_layout_container')
    @if(!get_field('mobile_bigheaderfooter',get_the_ID())) hidden md:block @endif
">
  <div class="justify-between md:flex hidden">
    <ul class="flex list-none flex-1 flex-wrap">
      @php($menu_items = wp_get_nav_menu_items('Main Menu'))

      @foreach($menu_items as $item)
        <li class="mr-2 xl:mt-2 mt-1">
          <a
            href="{{ $item->url }}"
            target="{{ $item->target }}"
            class="block leading-none text-center
          "><span data-title="{{ $item->title }}"
            class="button-menu growing-button
            bg-chalk hover:bg-citrus
            transition-colors duration-300
            text-sm 2xl:text-md py-1.5 px-5 rounded-full
            border border-charcoal inline-block
            {{ $item->object_id == get_the_ID() ? '!bg-charcoal !text-chalk' : 'text-charcoal' }}
            ">{{ $item->title }}</span>
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
              class="block
              leading-none text-center
            "><span data-title="{{ $item->title }}"
              class="button-menu growing-button
              text-sm 2xl:text-md py-1.5 px-5 rounded-full
              border border-charcoal inline-block
              transition-colors duration-300
              bg-chalk hover:bg-citrus
              {{ $item->object_id == get_the_ID() ? '!bg-charcoal !text-chalk' : 'text-charcoal' }}
               ">{{ $item->title }}</span>
            </a>
          </li>
        @endforeach
      </ul>
      @if (is_front_page())
      {{-- Animated Brand --}}
        <div class="splash-logo splash-logo--footer">
          <a
            href="{{ home_url('/') }}"
            class="brand-footer
            text-7xl md:text-8xl 2xl:text-9xl
            text-charcoal leading-[0.75]"
          ><span class="block">{{ __('Careers', 'codigo') }}</span></a>
        </div>
      {{-- End Animated Brand --}}
      @endif
      <a
          href="{{ home_url('/') }}"
          class="brand-footer
          text-7xl md:text-8xl 2xl:text-9xl
          text-charcoal leading-[0.75]"
        ><span class="block">{{ __('Careers', 'codigo') }}</span></a>
    </div>
  </div>

  <div class="md:hidden text-right">
    @if (is_front_page())
      {{-- Animated Brand --}}
        <div class="splash-logo splash-logo--footer">
          <a
            href="{{ home_url('/') }}"
            class="brand-footer
            text-7xl md:text-8xl 2xl:text-9xl
            text-charcoal leading-[0.75]"
          ><span class="block">{{ __('Careers', 'codigo') }}</span></a>
        </div>
      {{-- End Animated Brand --}}
      @endif
    <a
      href="{{ home_url('/') }}"
      class="brand-footer 2xl:text-9xl text-7xl text-charcoal"
    >
      {{ __('Careers', 'codigo') }}
    </a>
  </div>
</footer>
