<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-disable-trackbacks');
  add_theme_support('soil-disable-asset-versioning');
  //add_theme_support('soil-jquery-cdn');
  //add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'footer_navigation' => __('Footer Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  add_theme_support('woocommerce');

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
false
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
global $old_scripts;
global $not_registered;
global $last_deps;
$last_deps=[];
//$not_registered=[];
add_action( 'wp_print_scripts', __NAMESPACE__ . '\\wp_cookie',999);
//add_action( 'wp_head', __NAMESPACE__ . '\\asset_bundler_caller', 999);
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\in_footer', 999);
//add_action( 'wp_head', __NAMESPACE__ . '\\in_footer', 999);
//add_action( 'wp_print_scripts', __NAMESPACE__ . '\\in_footer', 999);
//add_filter( 'wp_print_styles', __NAMESPACE__ . '\\asset_bundler_caller', 999);
//add_filter( 'wp_print_scripts', __NAMESPACE__ . '\\asset_bundler_caller', 999);
add_action( 'wp_footer', __NAMESPACE__ . '\\dump_tree', 999);
//add_filter( 'wp_head', __NAMESPACE__ . '\\asset_bundler_caller', 1);
//add_filter( 'wp_enqueue_scripts', __NAMESPACE__ . '\\asset_bundler_caller', 1);
//add_filter( 'wp_print_styles', __NAMESPACE__ . '\\asset_bundler_caller', 1);
//add_filter( 'wp_print_scripts', __NAMESPACE__ . '\\asset_bundler_caller', 1);
//add_filter( 'wp_footer', __NAMESPACE__ . '\\asset_bundler_caller', 1);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 998);
add_filter( 'script_loader_src',__NAMESPACE__ . '\\remove_bundled_script', 998,2  );
//add_filter( 'script_loader_tag',__NAMESPACE__ . '\\js_async_attr', 998,3  );
add_filter( 'style_loader_src',__NAMESPACE__ . '\\remove_bundled_style', 998,2  );
//add_filter( 'style_loader_tag',__NAMESPACE__ . '\\remove_bundled_style2', 998,3  );
function in_footer(){
  global $wp_scripts;
 foreach ($wp_scripts->queue as $queued_script) {
  if($wp_scripts->registered[$queued_script]){
    $wp_scripts->registered[$queued_script]->ver=false;
     $wp_scripts->add_data( $queued_script, 'group', 1 );
  }


  }

}
function js_async_attr($tag,$handle,$src){

    # Do not add async to these scripts
    $scripts_to_exclude = array('jquery','wp-checkout');
    $scripts_to_include = array();
    foreach($scripts_to_exclude as $exclude_script){

      if ( $handle === $exclude_script ) return $tag;
    }
          //foreach($scripts_to_include as $include_script){
       // if(true != strpos($tag, $include_script ) )
    return str_replace( ' src', ' async="async" src', $tag );
          //  }
    //return $tag;
    # Add async to all remaining scripts
}
function remove_bundled_script($src, $handle){
   $bundle=["underscore",'jquery-cookie','wp-util','jquery-blockui','touch','responsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','wc-add-to-cart-variation','add-to-cart-variation-ajax','yith_wccl_frontend',"wc-country-select","yith-wcms-step"];
  if(in_array($handle, $bundle)) return '//:0';
  return $src;

}

function remove_bundled_style($src, $handle){
   $bundle=['responsive-menu-pro','ct-styles','woocommerce-layout','
woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','
yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'];
  if(in_array($handle, $bundle)) return '//:0';
  return $src;

}

function enqueue_assets(){
  wp_enqueue_style('sage_css', Assets\asset_path('styles/main.css'), false, null);
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
  wp_deregister_script('jquery');
  wp_enqueue_script('jquery',  Assets\asset_path('scripts/jquery.js'), array(),null, true);

  //wp_enqueue_script('wpml-browser-redirect',ICL_PLUGIN_URL . '/res/js/browser-redirect.js',['jquery'],ICL_SITEPRESS_VERSION,true);

  wp_enqueue_script('sage_js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
 wp_localize_script( 'sage_js', 'faberge', array(
    'ajax_url' => admin_url( 'admin-ajax.php' )
  ));
}
function wp_cookie(){
  global $wp_scripts;
$wp_scripts->registered['wpml-browser-redirect']->deps[1]='jquery-cookie';
echo'<style type="text/css" media="screen">
   .var_dump{
     background-color:#fff;
     color:#000;
     white-space:pre;
     padding:50px 2%;
   }
  </style>';

}
function dump_tree(){
   global $wp_scripts;
  echo'<div class="var_dump">
    ';var_dump(recursive_deps($wp_scripts->queue));echo'
  </div>';
}
function asset_bundler_caller(){


  if(!( is_admin() || Is_Backend_LOGIN() )){

 /*
 concat
 group
 deps
 */
    global $wp_scripts;


 $bundles= [
   "main.js"=>[
     "assets"=>["underscore",'jquery-cookie','wp-util','jquery-blockui','touch','responsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','wc_additional_
ion_images_script','wc-add-to-cart','wc-add-to-cart-variation','add-to-cart-variati
x','yith_wccl_frontend',"wc-country-select","yith-wcms-step"],
      'type'=>'scripts',
      'deregister'=>[],'not-dequeue'=>[],'not-enqueue'=>['']
    ],
    "main.css"=>[
      "assets"=>['responsive-menu-pro','ct-styles','woocommerce-layout','
woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','
yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'],
      "type"=>"styles"

    ]
  ];
 asset_bundler($bundles);

 global $not_registered;
 var_dump("<h3>Not Registered</h3>",$not_registered);
 global $old_scripts;
//var_dump(//$wp_scripts->done,$wp_scripts->to_do,$wp_scripts->queue);
}
}
function Is_Backend_LOGIN(){
    $ABSPATH_MY = str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
    return (in_array($ABSPATH_MY.'wp-login.php', get_included_files()) || in_array($ABSPATH_MY.'wp-register.php', get_included_files()) );

}

function deps($handle){
  global $wp_scripts;
  global $not_registered;
  !isset($wp_scripts->registered[$handle])?($not_registered[]=$handle):false;
  return  isset($wp_scripts->registered[$handle])&& $wp_scripts->registered[$handle]->deps ? $wp_scripts->registered[$handle]->deps:false;
}

function recursive_deps($array){
  if(is_array($array)){
      $new=[];
      foreach ($array as $key => $value) {
         $new[$value]=recursive_deps(deps($value));
      }
  }else{
    $new=false;
  }
   return $new;
}
/*
  [
    "main.js"=>[
      "assets"=>["underscore",'jquery-cookie','wp-util','jquery-blockui','touch','//sponsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','//wc_additional_variati_images_script','wc-add-to-cart','wc-add-to-cart-variation',//'add-to-cart-variation_ajax'yith_wccl_frontend',"wc-country-select","//yith-wcms-step"],
      'type'=>'scripts',
      'deregister'=>[],'not-dequeue'=>[],'not-enqueue'=>['']
    ],
    "main.css"=>[
      "assets"=>['responsive-menu-pro','ct-styles','woocommerce-layout','//ocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','//th_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'],
      "type"=>"styles"

    ]
  ]
 */
function asset_bundler( $bundles=[] ){
  global $wp_scripts;
  global $wp_styles;

  $all_deps=[];
  foreach ($wp_scripts->queue as $handle) {
    if($wp_scripts->registered[$handle]->deps){
      foreach ($wp_scripts->registered[$handle]->deps as $key => $dep) {
        if(!isset($all_deps[$dep])) $all_deps[$dep]=[];
        $all_deps[$dep][$handle]=isset($wp_scripts->registered[$dep])?$wp_scripts->registered[$dep]->deps:false;
      }
    }
  }
  $manifest=[];
  foreach ($bundles as $bundle_slug => $bundle) {
    $manifest[$bundle_slug]=[];
    $manifest[$bundle_slug]['deps']=[];
    foreach( $bundle['assets'] as $handle ) {
      if($bundle['type']==='styles'){ $global = &$wp_styles; }
      elseif($bundle['type']==='scripts'){ $global = &$wp_scripts; }
      if(isset($global->registered[$handle])){
        $obj =$global->registered[$handle];
        $manifest[$bundle_slug][$handle]=$obj->src;
      }
    }
  }
  //var_dump("<h3>Manifest</h3>",$manifest);
  //var_dump("<h3>All deps</h3>",$all_deps);
}

// flat-dependency/async
// search !frontend-plugin,url/path,modifiedMin
// check if theme
// redirect
