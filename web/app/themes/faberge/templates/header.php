<header class="banner">
  <div class="container">

    <nav class="nav-primary">
      <?php echo do_shortcode('[responsive_menu_pro_button] ' ); ?>
      <li></li>
      <li class="logo" ><div><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo.svg" alt=""></div></li>
      <li></li>
      <?php 
        $search = '<div id="sb-search" class="search sb-search">';
	    $search .= '<form method="get" id="searchform" action="'.home_url().'">';
	    $search .= '<input type="text" class="field sb-search-input" name="s" id="s" />';
	    $search .= '<input type="submit" class="submit sb-search-submit" name="submit" id="searchsubmit" value="Cerca" />';
	    $search .= '<i class="icon-search sb-icon-search fa-search"></i>';
	    $search .= '</form>';
	    $search .= '</div>';
	    echo $search;
      ?>
    </nav>
  </div>
</header>