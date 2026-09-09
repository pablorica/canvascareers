{{--
  Template Name: Jobs
--}}

<?php
$pagination = get_field('pagination') ? get_field('jobs_per_page') : null;
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

@section('content')
  <?php
  $jobs = get_posts($args);
  $pages = 1;
  if($pagination && count($jobs) > $pagination ) {
    $pages = ceil(count($jobs) / $pagination);
  }
  $current_page = 1;
  ?>

<!-- /codigo/resources/views/template-jobs.blade.php -->
  <div class="jobs-list
    md:px-8 2xl:px-14
    lg:mt-2
  ">
    <div class="mb-8">
      <div id="jobsListheader"
        class="hidden
          md:grid grid-cols-12
          items-center py-4
          font-sans text-xl
          border-b border-charcoal
      ">
        <div class="md:col-span-7 lg:col-span-5 xl:col-span-3 2xl:col-span-4 flex items-center px-4">
          <div class="w-12 pr-4"></div>
          {{ __('Position', 'codigo') }}
        </div>
        <div class="md:col-span-5 xl:col-span-3
          px-4
        ">
          <span class="inline-block w-[120px]">{{ __('Contract', 'codigo') }}</span>
          <span class="inline-block">{{ __('Sector', 'codigo') }}</span>
        </div>
      </div>

      <div id="jobs">
        @php($job_int = 0)
        @foreach($jobs as $job)
          @php($terms = get_the_terms($job, 'job-tag'))
          @php($terms_slugs = [])
          @foreach($terms as $term)
            @php($terms_slugs[] = $term->slug)
          @endforeach
          <?php
          $job_int++;
          if($pagination && $job_int>$pagination ){
            $current_page++;
            $job_int = 1;
          }

          $job_hidden = '';
          if($current_page > 1){
            $job_hidden = 'hidden';
          }
          ?>

          <div
            class="job-item page-{{ $current_page }}
              {{ $job_hidden }}
              relative
              border-b border-charcoal
              px-5 md:px-0
              {{ implode(' ', $terms_slugs) }}"
          >
            <div class="job-accordion
              grid grid-cols-12
              items-center  cursor-pointer
              py-3 md:py-1 2xl:py-3">
              <div class="
                col-span-12 md:col-span-7
                lg:col-span-5 xl:col-span-3 2xl:col-span-4
                md:px-4 mb-8 md:mb-0
                flex items-center flex-row-reverse md:flex-row
                justify-between md:justify-start
              ">
                <svg class="shrink-0 rotate-x transition-transform duration-300 w-auto md:w-12 md:pr-4 icon-{{ $loop->index }}" width="40" height="32" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                  <polyline points="10,20 25,35 40,20" stroke="black" stroke-width="2" fill="none"/>
                </svg>
                <h3 class="text-xl 2xl:text-2xl font-sans font-light">{{ $job->post_title }}</h3>
              </div>
              <div class="col-span-12 md:col-span-5 xl:col-span-6
                md:px-4
                flex xl:block
                justify-between md:justify-start
                gap-2 flex-nowrap
              ">
                <span class="inline-block
                  w-[120px] min-w-[120px]
                  text-base md:text-xl 2xl:text-2xl
                  font-sans font-light"
                >{{ get_field('contract', $job) }}</span>
                <span class="inline-block
                  text-base md:text-xl 2xl:text-2xl
                  font-sans font-light"
                >
                  @foreach($terms as $term)
                    <span>{{ $term->name }}@if(!$loop->last), @endif</span>
                  @endforeach
                </span>
              </div>
            </div>

            <div
              id="collapse-{{ $loop->index }}"
              class="job-body accordion-collapse overflow-hidden max-h-0 transition-all duration-300 ease-in-out"
            >
            {{--
              md:
              nav : 144.5px
              footer: 108.9px
              jobs-header: 95px;

              2xl:
              nav : 167.5px
              footer: 123.65px
              jobs-header: 110px;

              md:min-h-[calc(100vh-144.5px-108.9px-95px)]
              2xl:min-h-[calc(100vh-167.5px-123.65px-110px)]

              This is overwritten by the JS in resources/scripts/modules/jobs.js
            --}}
              <div class="job-grid
                  flex flex-col justify-start items-start
                  pt-4 pb-8
              ">
                <div class="md:pl-16">
                  <div class="job-info
                    pb-6 md:pb-8
                    font-sans text-base font-light"
                  >
                    <div class="flex mb-2">
                      <div class="w-20 mr-2">{{ __('Salary', 'codigo') }}</div>
                      <div>{{ get_field('salary', $job) }}</div>
                    </div>

                    {{-- <div class="hidden md:flex font-light">
                      <div class="w-20 mr-2">{{ __('Sector', 'codigo') }}</div>
                      <div>
                        @foreach($terms as $term)
                          <span>{{ $term->name }}@if(!$loop->last), @endif</span>
                        @endforeach
                      </div>
                    </div> --}}
                  </div>
                </div>

                <div class="w-full grid grid-cols-12">
                  @if(get_field('start_column', $job))
                    <div class="
                      col-span-12 md:col-span-7 lg:col-span-5 xl:col-span-3 2xl:col-span-4
                      md:pl-16 md:pr-8
                      md:max-w-[400px]
                    ">
                      {!! get_field('start_column', $job) !!}
                    </div>
                  @endif

                  @if(get_field('middle_column', $job))
                    <div class="
                      col-span-12 md:col-span-7 lg:col-span-4 xl:col-span-3
                      lg:pl-4 md:pr-8 md:pl-16
                      md:max-w-[400px]
                      pt-6 lg:pt-0
                    ">
                      {!! get_field('middle_column', $job) !!}
                    </div>
                  @endif

                  @if(get_field('end_column', $job))
                    <div class="
                      col-span-12 md:col-span-7 lg:col-span-5 xl:col-span-3
                      xl:pl-4 md:pr-8 md:pl-16
                      md:max-w-[400px] xl:max-w-[350px]
                      pt-6 xl:pt-0
                    ">
                      {!! get_field('end_column', $job) !!}
                    </div>
                  @endif

                  @if($form_id = get_field('contact_form'))
                    <div
                      class="job-form
                      col-span-12
                      mt-10 md:mt-0
                      flex md:items-end flex-col md:flex-row"
                      data-job-id="{{ $job->ID }}"
                      data-job-title="{{ $job->post_title }}"
                    >
                      <a
                        class="
                          text-sm 2xl:text-md
                          py-2 px-1 md:py-[5px] md:px-[8px] 2xl:py-2 2xl:px-2
                          rounded-full cursor-pointer
                          bg-chalk md:hover:bg-citrus
                          transition-colors duration-300
                          border border-charcoal block whitespace-nowrap
                          leading-none text-center w-[120px] md:w-[150px]
                          overflow-ellipsis overflow-hidden md:ml-auto toggle-form
                        "
                      >
                        {{ __('Apply', 'codigo') }}
                      </a>

                      <div class="form-container hidden
                        relative md:absolute
                        right-0 md:top-1/2 md:-translate-y-1/2
                        md:max-w-[300px]
                        px-3 md:px-4 pt-6 md:py-4
                        border-t md:border border-charcoal
                        bg-chalk
                        mt-6 md:mt-0
                      ">
                        <div class="w-auto text-right md:relative absolute top-6 right-3 md:top-0 md:right-0">
                          <svg class="toggle-form cursor-pointer ml-auto mb-4" width="30" height="30" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg" style="transform: rotate(45deg);">
                            <line x1="25" y1="10" x2="25" y2="40" stroke="gray" stroke-width="1"></line>
                            <line x1="10" y1="25" x2="40" y2="25" stroke="gray" stroke-width="1"></line>
                          </svg>
                        </div>

                        {!! do_shortcode('[contact-form-7 id="' . $form_id . '"]') !!}
                      </div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  @if($pages > 1)
  <div id="jobsPagination"
    class="absolute w-full bottom-0
      bg-chalk
      flex justify-center items-center
      gap-2 md:gap-2
      py-4 md:py-6"
    data-perpage="{{ $pagination }}"
  >
    @for($i=1; $i<=$pages; $i++)
      <span
        class="pagination-item
          cursor-pointer
          block
          w-[6px] h-[6px] md:w-[6px] md:h-[6px]
          @if($i==1) bg-charcoal  @else bg-gray @endif
          rounded-full"
        data-page="{{ $i }}"
      ></span>
    @endfor
  @endif

@endsection
<!-- End /codigo/resources/views/template-jobs.blade.php -->
