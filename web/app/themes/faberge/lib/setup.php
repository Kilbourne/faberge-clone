<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use \RecursiveIteratorIterator;
use \RecursiveArrayIterator;
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
global $not_registered;
$not_registered=[];
//add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\asset_bundler_caller', 999);
//add_action( 'wp_footer', __NAMESPACE__ . '\\asset_bundler_caller', 999);
add_action( 'wp_print_scripts', __NAMESPACE__ . '\\wp_cookie',999);
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\in_footer', 999);
add_action( 'wp_print_scripts', __NAMESPACE__ . '\\in_footer', 999);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 998);
add_filter( 'script_loader_src',__NAMESPACE__ . '\\remove_bundled_script', 998,2  );
add_filter( 'script_loader_tag',__NAMESPACE__ . '\\js_async_attr', 998,3  );
add_filter( 'style_loader_src',__NAMESPACE__ . '\\remove_bundled_style', 998,2  );
//add_action( 'wp_footer', __NAMESPACE__ . '\\var_dump_queue', 998);
function var_dump_queue(){
  global $wp_scripts;
  dump_tree([current_filter(),'Queue:',count($wp_scripts->queue),'Todo:',count($wp_scripts->to_do),'Done:',count($wp_scripts->done)]);

}
function in_footer(){
  global $wp_scripts;
  $bundle=["underscore",'jquery-cookie','wp-util','jquery-blockui','touch','responsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','wc-add-to-cart-variation','add-to-cart-variation-ajax','yith_wccl_frontend',"wc-country-select","yith-wcms-step"];
 foreach ($wp_scripts->queue as $queued_script) {
  if($wp_scripts->registered[$queued_script]){
    if(!in_array($queued_script, $bundle)){

    $wp_scripts->registered[$queued_script]->ver=false;

     $wp_scripts->add_data( $queued_script, 'group', 1 );

   }else{
    $wp_scripts->registered[$queued_script]->deps=[];
   }

  }


  }

}
function js_async_attr($tag,$handle,$src){
    if(( is_admin() || Is_Backend_LOGIN() )) return;
    # Do not add async to these scripts
    $scripts_to_exclude = array('jquery','prettyPhoto',"password-strength-meter","zxcvbn-async","stripe");
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
   if(( is_admin() || Is_Backend_LOGIN() )) return;
   $bundle=["underscore",'wp-util',"jquery-blockui",'woocommerce','jquery-cookie','touch','responsive-menu-pro','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','add-to-cart-variation_ajax','yith_wccl_frontend',"wc-country-select","yith-wcms-step"];
    if(in_array($handle, $bundle)) return '//:0';
    return $src;

}

function remove_bundled_style($src, $handle){
    if(( is_admin() || Is_Backend_LOGIN() )) return;
    $bundle=['responsive-menu-pro','ct-styles','woocommerce-layout','woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'];
      if(in_array($handle, $bundle)) return '//:0';
      return $src;

}

function enqueue_assets(){

  wp_enqueue_style('sage_css', Assets\asset_path('styles/main.css'), false, null);
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
  wp_deregister_script('wp-embed');
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

}

function dump_tree($arr){

   global $wp_scripts;
     echo'<style type="text/css" media="screen">
     .var_dump{
       background-color:#fff;
       color:#000;
       white-space:pre;
       padding:50px 2%;
     }
    </style>';
    echo'<div class="var_dump">
    ';
    if(is_array($arr)){
      foreach ($arr as $key => $value) {
        if(is_array($value)) {var_dump($value);}
        else{ echo $value ;}
        echo '<br>';
      }
    }
      else{ echo $arr;}
    echo'
    </div>';
}
function asset_bundler_caller(){


  if(!( is_admin() || Is_Backend_LOGIN() )){



 $bundles= [
   "main.js"=>[
     "assets"=>["underscore",'jquery-cookie','wp-util','jquery-blockui',"wc-country-select","wc-address-i18n",'wc-add-to-cart-variation','woocommerce',"wc-checkout",'touch','responsive-menu-pro','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','add-to-cart-variation_ajax','yith_wccl_frontend',"yith-wcms-step"],
      'type'=>'scripts'
    ],
    "main.css"=>[
      "assets"=>['responsive-menu-pro','ct-styles','woocommerce-layout','
woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','
yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'],
      "type"=>"styles"
    ]
  ];
  global $wp_scripts;
global $not_registered;
 $manifest=asset_bundler($bundles);
 $dependency_tree=recursive_deps($wp_scripts->queue);
 $flat_deps=flat_deps($dependency_tree);
 $not_bundled_deps = not_bundled_deps($bundles["main.js"]['assets'], $flat_deps );
 dump_tree([ 'Dependency_Tree',$dependency_tree,'Flat_Deps', $flat_deps, 'Not_Registered' , $not_registered, 'NotInBundle',$not_bundled_deps ] );
dump_tree(stripslashes($manifest));

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
function flat_deps($arr){
  $total=[];
  foreach (new \RecursiveIteratorIterator(new \RecursiveArrayIterator($arr), RecursiveIteratorIterator::CHILD_FIRST) as $key => $value) {
    if(!isset($total[$key]))$total[$key]=[];
    if(is_array($value)){
      foreach($value as $k => $v) {
        if(!in_array($key,$total[$k]))$total[$k][]=$key;
      }
    }
  }
  return $total;
}
function asset_bundler( $bundles=[] ){
  global $wp_scripts;
  global $wp_styles;
  $manifest=[];

  foreach ($bundles as $bundle_slug => $bundle) {
    $manifest[$bundle_slug]=[];
    $manifest[$bundle_slug][0]=[];
$manifest[$bundle_slug][1]=[];
    foreach( $bundle['assets'] as $handle ) {
      if($bundle['type']==='styles'){ $global = &$wp_styles; }
      elseif($bundle['type']==='scripts'){ $global = &$wp_scripts; }
      if(isset($global->registered[$handle])){
        $obj =$global->registered[$handle];
        $manifest[$bundle_slug][0][]=$handle;
        $manifest[$bundle_slug][1][]=$obj->src;
      }
    }
  }

  return json_encode($manifest);
}
function not_bundled_deps($bundle,$flat){

  foreach( $bundle as $handle ) {
    if(isset($flat[$handle])) unset($flat[$handle]);
  }
  return $flat;
}
// not setted base price
// see how asset-queue search deps
// script head / body
// search !frontend-plugin,url/path,modifiedMin
// check if theme
// redirect
