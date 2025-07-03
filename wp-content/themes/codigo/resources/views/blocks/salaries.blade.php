<div class="salary-list
    md:px-8 2xl:px-14
    lg:mt-2
    {{ $block->classes }}"
  style="{{ $block->inlineStyle }}"
>
<?php
// get all terms of taxonomy 'salary-category'
$terms = get_terms([
  'taxonomy' => 'salary-category',
  'hide_empty' => false,
]);

?>
  <div class="mb-8 -mt-4 md:mt-0">
    <div id="salaryListheader"
      class="hidden
        md:grid grid-cols-12
        items-center py-4
        font-sans
        border-b border-charcoal
    ">
      <div class="md:col-span-4
        md:pl-16 md:pr-8"
      >
        {{ __('Role', 'codigo') }}
      </div>
      <div class="md:col-span-2"
      >
        {{ __('Low', 'codigo') }}
      </div>
      <div class="md:col-span-2"
      >
        {{ __('Typical', 'codigo') }}
      </div>
      <div class="md:col-span-2"
      >
        {{ __('High', 'codigo') }}
      </div>
    </div>
    @if ($terms)
    <div id="salaryCategories">
      @foreach ($terms as $index => $salary)
        <?php
          // Get all posts with post_type = 'salary' and term = $salary
          $roles = get_posts([
            'post_type' => 'salary',
            'posts_per_page' => -1,
            'tax_query' => [
              [
                'taxonomy' => 'salary-category',
                'field' => 'term_id',
                'terms' => $salary->term_id,
              ],
            ],
          ]);
        ?>
        <div
          class="salary-item relative border-b
            border-charcoal px-5 md:px-0"
        >
          <div class="salary-accordion
            grid grid-cols-12
            items-center  cursor-pointer
            py-3 md:py-1 2xl:py-3">
            <div class="
              col-span-12
              md:px-4
              mb-0
              flex items-center flex-row-reverse md:flex-row
              justify-between md:justify-start
            ">
              <svg class="shrink-0 rotate-x transition-transform duration-300 w-auto md:w-12 md:pr-4 icon-{{ $index }}" width="40" height="32" viewBox="0 0 50 50" xmlns="http://www.w3.org/2000/svg">
                <polyline points="10,20 25,35 40,20" stroke="black" stroke-width="2" fill="none"/>
              </svg>
              <h3 class="text-xl 2xl:text-2xl
                font-sans font-light"
              >{!! $salary->name !!}</h3>
            </div>
          </div>

          <div
            id="collapse-{{ $index }}"
            class="salary-body
              accordion-collapse overflow-hidden
              max-h-0 transition-all
              duration-300 ease-in-out"
          >

            <div class="salary-grid
                flex flex-col justify-start items-start
                pt-4 pb-8
            ">
              <div id="salaryListheader"
                class="grid md:hidden grid-cols-12
                  w-full
                  items-center py-4
                  font-sans"
              >
                <div class="col-span-6
                  md:pl-16 md:pr-8"
                >
                  {{ __('Role', 'codigo') }}
                </div>
                <div class="col-span-2"
                >
                  {{ __('Low', 'codigo') }}
                </div>
                <div class="col-span-2"
                >
                  {{ __('Typical', 'codigo') }}
                </div>
                <div class="col-span-2"
                >
                  {{ __('High', 'codigo') }}
                </div>
              </div>
              <div class="w-full grid grid-cols-12">
              @if ($roles)
                @foreach ($roles as $role)
                  <div class="col-span-6 md:col-span-4
                    md:pl-16 md:pr-8
                    has-sm-font-size
                  ">
                    {!! $role->post_title !!}
                  </div>
                  <div class="col-span-2 has-sm-font-size">
                    {!! get_field('low', $role->ID) !!}
                  </div>
                  <div class="col-span-2 has-sm-font-size">
                    {!! get_field('typical', $role->ID) !!}
                  </div>
                  <div class="col-span-2 has-sm-font-size">
                    {!! get_field('high', $role->ID) !!}
                  </div>
                @endforeach
              @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    @else
      <p>{{ $block->preview ? 'Add an category...' : 'No categories found!' }}</p>
    @endif
  </div>
  <div>
    <InnerBlocks template="{{ $block->template }}" />
  </div>
</div>
