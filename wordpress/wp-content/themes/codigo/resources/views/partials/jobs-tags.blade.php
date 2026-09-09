@php($tags = get_terms('job-tag', ['hide_empty' => false]))

<div class="job-tags
  button-group
  lg:grid lg:grid-cols-12
  lg:absolute lg:left-0 lg:bottom-5
  md:border-0 border-charcoal
  md:w-full
  px-5 py-6 md:pb-0 md:px-0 lg:px-0 lg:py-0
  -mx-5 -mb-5 md:mx-0 md:mb-0
  overflow-y-hidden
">
  <a
    class="
      job-filters-mobile whitespace-nowrap
      text-sm md:text-md py-2 px-1 md:px-3 rounded-full
      bg-chalk cursor-pointer
      transition-colors duration-300
      border border-charcoal block md:hidden
      leading-none text-center w-[120px] md:w-[150px]
      overflow-ellipsis overflow-hidden
    "
  >
    {{ __('Sectors', 'codigo') }}
  </a>

  <div class="job-filter-content
    max-h-0 md:max-h-full
    transition-all duration-300 ease-in-out
    lg:col-start-6 xl:col-start-4 2xl:col-start-5
    lg:col-span-7 xl:col-span-8 2xl:col-span-8
    lg:px-6 2xl:px-8
    flex items-center flex-wrap gap-2
  ">
    <div class="pt-5 w-full relative md:hidden">
      <div class="border-b border-charcoal absolute h-1 -left-5 -right-5"></div>
    </div>

    <div class="md:hidden w-full pb-3 pt-1.5">
      <span class="font-sans text-sm">{{ __('Sector', 'codigo') }}</span>
    </div>

    @foreach($tags as $tag)
      <a
        class="
          job-filter whitespace-nowrap rounded-full
          text-sm 2xl:text-md
          py-2 px-1 md:py-[5px] md:px-[8px] 2xl:py-2 2xl:px-2
          bg-chalk hover:bg-citrus cursor-pointer
          transition-colors duration-300
          border border-charcoal block
          leading-none text-center w-[120px] md:w-[118px]
          overflow-ellipsis overflow-hidden
        "
        data-filter=".{{ $tag->slug }}"
      >
        {{ $tag->name }}
      </a>
    @endforeach

    <div class="w-full pt-4 md:hidden"></div>

    <a
      class="
        job-filter whitespace-nowrap
        text-sm md:text-md py-2 px-1 md:px-3 rounded-full
        bg-chalk cursor-pointer
        transition-colors duration-300
        border border-charcoal block
        leading-none text-center w-[120px] md:w-[150px]
        overflow-ellipsis overflow-hidden md:hidden
      "
      data-filter=""
    >
      {{ __('Clear Sectors', 'codigo') }}
    </a>
  </div>
</div>
