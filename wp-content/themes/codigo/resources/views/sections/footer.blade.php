{{--
    @name Footer
    @desc The sites footer rendered on each page.
--}}

<!-- /codigo/resources/views/sections/footer.blade.php -->
<footer class="
    content-info 
    @option('footer_layout_container') 
">
  @php(dynamic_sidebar('sidebar-footer'))
</footer>
