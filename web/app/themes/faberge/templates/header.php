<header class="banner">
  <div class="container">

    <nav class="nav-primary">
      <?php echo do_shortcode('[responsive_menu_pro_button] '); ?>
      <li></li>
      <li class="logo" ><div><a href="<?php echo get_home_url(); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/logo2.svg" alt=""></a></div></li>
      <li></li>
      <?php
$search = '<div id="sb-search" class="search sb-search">';
$search .= '<form method="get" id="searchform" action="' . home_url() . '">';
$search .= '<input type="text" class="field sb-search-input" name="s" id="s" />';
$search .= '<input type="submit" class="submit sb-search-submit" name="submit" id="searchsubmit" value="' . __('Search', 'sage') . '" />';
$search .= '<i class="icon-search sb-icon-search fa-search"></i>';
$search .= '</form>';
$search .= '</div>';
do_action('myplugin_after_form_settings');
echo do_shortcode(' [wpmenucart-button]');
?>
    </nav>
  </div>
      <?php if (is_tax('product_cat') || is_singular('product')) {
    get_header('shop');
}
?>
</header>
