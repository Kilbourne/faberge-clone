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
    <div class="credits">
      <div class="left">
      <span>©2016</span>
      <span>MAISON TATIANA FABERGE</span>
      <span>GENEVE</span>
      <span>Fondée en 1974</span>    </div>
      <div class="right"><span>web agency</span>
      <span><a href="http://www.menthalia.com"><img src="<?php echo get_stylesheet_directory_uri().'/dist/images/logo-menthalia.png' ?>" alt="MENTHALIA LOGO"></a> </span> </div>
    </div>
  </div>
</footer>
