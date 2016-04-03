<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use WP_Query;
/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
    //$classes[]='page-wrapper';
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }
  if(is_product_category()){
    global $wp_query;
      $cat = $wp_query->get_queried_object();

      $parent=$cat->parent;
      if($parent !== 0){ $classes[]= 'single-product';}
  }
  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

add_filter('wp_nav_menu_items', __NAMESPACE__ . '\\add_biogena_logo_menu', 10, 2);
function add_biogena_logo_menu( $items, $args ){

    if( $args->menu == 'menu-1' ) // only for primary menu
    {
      $new_item       = array( '<li class="divisor menu-item menu-item-type-post_type menu-item-object-page"><hr/></li>' );
        $items          = preg_replace( '/<\/li>\s<li/', '</li>-BIOGENADELIMITER-<li',  $items );

        $array_items    = explode( '-BIOGENADELIMITER-', $items );
        array_splice( $array_items, 1, 0, $new_item ); // splice in at position 3
        $items          = implode( '', $array_items );
    }
    return $items;
}


function faberge_panels_layout_classes( $classes, $grid ) {
  $classes[] = 'parallax';
  return $classes;
}
add_filter( 'siteorigin_panels_layout_classes', __NAMESPACE__ . '\\faberge_panels_layout_classes', 10, 2 );

function remove_admin_css() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('admin_bar_init', __NAMESPACE__ . '\\remove_admin_css');
