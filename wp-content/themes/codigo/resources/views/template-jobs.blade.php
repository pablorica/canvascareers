{{--
  Template Name: Jobs
--}}

<?php
$category = get_field('job_category');

$args = [
  'post_type' => 'job',
  'posts_per_page' => -1,
  'status' => 'publish',
  'orderby' => 'menu_order',
];

if ($category) {
  $args['tax_query'] = [
    [
      'taxonomy' => 'job-category',
      'field' => 'term_id',
      'terms' => $category,
    ],
  ];
}

?>

@extends('layouts.app')

<!-- /codigo/resources/views/template-jobs.blade.php -->
@section('content')
  @php($jobs = get_posts($args))

  <div class="jobs-list md:px-14 lg:mt-2">
    <div class="mb-8">
      <div class="hidden md:grid grid-cols-12 items-center py-4 font-sans text-xl border-b border-charcoal">
        <div class="md:col-span-7 lg:col-span-5 xl:col-span-4 flex items-center px-4">
          <div class="w-12 pr-4"></div>
          {{ __('Position', 'codigo') }}
        </div>
        <div class="md:col-span-5 xl:col-span-3 px-4">
          {{ __('Contract', 'codigo') }}
        </div>
      </div>

      <div id="jobs">
        @foreach($jobs as $job)
          @php($terms = get_the_terms($job, 'job-tag'))
          @php($terms_slugs = [])
          @foreach($terms as $term)
            @php($terms_slugs[] = $term->slug)
          @endforeach

          <div
            class="job-item border-b border-charcoal px-5 md:px-0 {{ implode(' ', $terms_slugs) }}"
          >
            <div class="grid grid-cols-12 items-center job-accordion cursor-pointer py-3">
              <div class="
                col-span-12 md:col-span-7 lg:col-span-5 xl:col-span-4 md:px-4 mb-8 md:mb-0
                flex items-center flex-row-reverse md:flex-row justify-between md:justify-start
              ">
                <svg class="shrink-0 rotate-x transition-transform duration-300 w-auto md:w-12 md:pr-4 icon-{{ $loop->index }}" width="40" height="32" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                  <polyline points="10,20 25,35 40,20" stroke="black" stroke-width="2" fill="none"/>
                </svg>
                <h3 class="text-2xl font-sans font-light">{{ $job->post_title }}</h3>
              </div>
              <div class="col-span-12 md:col-span-5 xl:col-span-3 md:px-4 flex justify-between md:block gap-2 flex-wrap">
                <span class="text-base md:text-2xl font-sans font-light">{{ get_field('contract', $job) }}</span>
                <span class="md:hidden text-base font-sans">
                  @foreach($terms as $term)
                    <span>{{ $term->name }} @if(!$loop->last), @endif</span>
                  @endforeach
                </span>
              </div>
            </div>

            <div
              id="collapse-{{ $loop->index }}"
              class="job-body accordion-collapse overflow-hidden max-h-0 transition-all duration-300 ease-in-out"
            >
              <div class="grid grid-cols-12 pt-4 pb-8 relative md:min-h-[315px]">
                <div class="col-span-12 md:pl-16">
                  <div class="job-info pb-6 md:pb-8 font-sans text-base md:text-lg font-light">
                    <div class="flex mb-2">
                      <div class="w-20 mr-2">{{ __('Salary', 'codigo') }}</div>
                      <div>{{ get_field('salary', $job) }}</div>
                    </div>

                    <div class="md:flex hidden font-light">
                      <div class="w-20 mr-2">{{ __('Sector', 'codigo') }}</div>
                      <div>
                        @foreach($terms as $term)
                          <span>{{ $term->name }} @if(!$loop->last), @endif</span>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-span-12"></div>

                @if(get_field('start_column', $job))
                  <div class="
                    col-span-12 md:col-span-7 lg:col-span-5 xl:col-span-4 md:pl-16 md:pr-8 md:max-w-[500px]
                  ">
                    {!! get_field('start_column', $job) !!}
                  </div>
                @endif

                @if(get_field('middle_column', $job))
                  <div class="
                    col-span-12 md:col-span-7 lg:col-span-4 xl:col-span-3 lg:pl-4 md:pr-8 md:pl-16 md:max-w-[500px] pt-6 lg:pt-0
                  ">
                    {!! get_field('middle_column', $job) !!}
                  </div>
                @endif

                @if(get_field('end_column', $job))
                  <div class="
                    col-span-12 md:col-span-7 lg:col-span-5 xl:col-span-3 xl:pl-4 md:pr-8 md:pl-16 md:max-w-[500px] xl:max-w-[350px] pt-6 xl:pt-0
                  ">
                    {!! get_field('end_column', $job) !!}
                  </div>
                @endif

                @if($form_id = get_field('contact_form'))
                  <div
                    class="job-form md:absolute right-0 bottom-8 col-span-12 mt-10 md:mt-0"
                    data-job-id="{{ $job->ID }}"
                    data-job-title="{{ $job->post_title }}"
                  >
                    <a
                      class="
                        text-sm md:text-md py-2 px-1 md:px-3 rounded-full
                        bg-chalk md:hover:bg-citrus cursor-pointer
                        transition-colors duration-300
                        border border-charcoal block whitespace-nowrap
                        leading-none text-center w-[120px] md:w-[150px]
                        overflow-ellipsis overflow-hidden md:ml-auto toggle-form
                      "
                    >
                      {{ __('Apply', 'codigo') }}
                    </a>

                    <div class="
                      md:max-w-[300px] px-3 md:px-6 pt-6 md:py-4 border-t md:border border-charcoal
                      bg-chalk hidden form-container mt-6 md:mt-0 relative
                    ">
                      <div class="w-auto text-right md:relative absolute top-6 right-3 md:top-0 md:right-0">
                        <svg class="toggle-form cursor-pointer ml-auto mb-4" width="30" height="30" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(45deg);">
                          <line x1="25" y1="10" x2="25" y2="40" stroke="black" stroke-width="1.5"></line>
                          <line x1="10" y1="25" x2="40" y2="25" stroke="black" stroke-width="1.5"></line>
                        </svg>
                      </div>

                      {!! do_shortcode('[contact-form-7 id="' . $form_id . '"]') !!}
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
<!-- End /codigo/resources/views/template-jobs.blade.php -->
