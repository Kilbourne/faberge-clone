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
      $children=get_term_children( $cat->ID, "product_cat" );

      if($parent !== 0 || count($children)===0){ $classes[]= 'single-product';}
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



 function remove_medialibrary_tab($strings) {

            unset($strings["mediaLibraryTitle"]);
        return $strings;

    }
    add_filter('media_view_strings',__NAMESPACE__ . '\\remove_medialibrary_tab');

add_filter( 'woocommerce_account_menu_items',function(){ return array(
    'dashboard'       => __( 'Profile details', 'woocommerce' ),
    'orders'          => __( 'Orders', 'woocommerce' ),
    'edit-address'    => __( 'Addresses', 'woocommerce' ),
    'edit-address-billing'    => __( 'Billing address', 'woocommerce' ),
    'edit-address-shipping'    => __( 'Shipping address', 'woocommerce' ),
    'payment-methods' => __( 'Payment Methods', 'woocommerce' )
  );} );

 function language_selector(){
$languages = icl_get_languages('skip_missing=0');
if(!empty($languages)){
echo '<ul id="lansel">';
foreach($languages as $l){
echo '<li '.($l['active']?'class="active"':'').' data-lang="'.$l['language_code'].'" >';
if(!$l['active']) echo '<a href="'.$l['url'].'">';
echo ''.$l['language_code'].'';
if(!$l['active']) echo '</a>';
echo '</li>';
}
}
echo '</ul>';
}

add_filter( 'wpseo_xml_sitemap_post_priority', __NAMESPACE__ . '\\my_custom_post_xml_priority', 10, 3 );

function my_custom_post_xml_priority( $return, $type, $post) {
    if ($type == 'page'){
      if(get_the_title($post->ID)=='Homepage'){
      $return = 1;
      }else{
      $return = 0.6;
      }
    }
    else if ($type == 'post')
        $return = 0.3;
    else if ($type == 'product')
        $return = 1;
    return $return;
}

if (isset($sitepress)){
  add_filter('wpseo_posts_join', __NAMESPACE__ . '\\sitemap_per_language', 10, 2);
  add_filter('wpseo_sitemap_entry', __NAMESPACE__ . '\\sitemap_per_language2', 10, 3);
}

function sitemap_per_language($join, $type) {
    global $wpdb, $sitepress;
    $lang = $sitepress->get_current_language();
    return " JOIN " . $wpdb->prefix . "icl_translations ON element_id = ID AND element_type = 'post_$type' AND language_code = '$lang'";
}
function sitemap_per_language2($url, $type,$obj){

  if($type==='term'){
    global $sitepress;
  $lang = $sitepress->get_current_language();
  $string=parse_url($url['loc'], PHP_URL_PATH);
  $query='/'.$lang.'/';
  $start=0;
  if($lang==='en'){
    $query='/';
    $start=3;
     if(substr($string, $start, strlen($query)) === $query)
   return false;}elseif(substr($string, $start, strlen($query)) !== $query ){ return false;}
  }

return $url;
}

add_filter('woocommerce_variable_price_html', __NAMESPACE__ . '\\custom_variation_price', 10, 2);

    function custom_variation_price( $price, $product ) {

        foreach($product->get_available_variations() as $pav){
            $def=true;
            foreach($product->get_variation_default_attributes() as $defkey=>$defval){

                if(isset($pav['attributes']['attribute_'.$defkey]) && $pav['attributes']['attribute_'.$defkey]!=$defval){
                    $def=false;
                }
            }
            if($def){
                $price = $pav['display_price'];
            }
        }

        return '<span class="woocommerce-Price-amount amount">'.woocommerce_price($price).'</span>' ;

    }
