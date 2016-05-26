<footer class="content-info">
  <div class="container">
    <nav class="nav-footer">
      <hr />
      <?php
      if (has_nav_menu('footer_navigation')) :
        wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</footer>
