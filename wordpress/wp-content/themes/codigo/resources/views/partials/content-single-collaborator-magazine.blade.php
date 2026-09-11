{{--
    @name Content Single Collaborator (Magazine)
    @desc Used when a collaborator post contains the Magazine block.
          Renders the block content bare so the horizontal spread fills the viewport.
--}}
<!-- /resources/views/partials/content-single-collaborator-magazine.blade.php -->
<article @php(post_class('single-collaborator single-collaborator--magazine'))>
  @php(the_content())
</article>
<!-- End /resources/views/partials/content-single-collaborator-magazine.blade.php -->
