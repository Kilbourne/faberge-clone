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
function assets() {
  wp_enqueue_style('sage_css', Assets\asset_path('styles/main.css'), false, null);

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
 if( !is_admin()){
    wp_deregister_script('jquery' );

  wp_enqueue_script('jquery',  Assets\asset_path('scripts/jquery.js'), array(),null, false);



  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\wpse8170_enqueue_my_scripts', 0 );
// or if you enqueue your scripts on init action
// add_action( 'init', 'wpse8170_enqueue_my_scripts', 0 );

function wpse8170_enqueue_my_scripts() {
  wp_enqueue_script('sage_js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
  wp_localize_script( 'sage_js', 'cssTarget', 'style-svg' );
  wp_localize_script( 'sage_js', 'woocommerce_params'
, array(
          'ajax_url'    => WC()->ajax_url(),
          'wc_ajax_url' => \WC_AJAX::get_endpoint( "%%endpoint%%" )
        ) );
      wp_localize_script( 'sage_js', 'faberge', array(
    'ajax_url' => admin_url( 'admin-ajax.php' )
  ));
      wp_localize_script( 'sage_js', 'wc_cart_fragments_params', array(
          'ajax_url'      => WC()->ajax_url(),
          'wc_ajax_url'   => \WC_AJAX::get_endpoint( "%%endpoint%%" ),
          'fragment_name' => apply_filters( 'woocommerce_cart_fragment_name', 'wc_fragments' )
        ) );
      wp_localize_script( 'sage_js', 'wc_add_to_cart_params', array(
          'ajax_url'                => WC()->ajax_url(),
          'wc_ajax_url'             => \WC_AJAX::get_endpoint( "%%endpoint%%" ),
          'i18n_view_cart'          => esc_attr__( 'View Cart', 'woocommerce' ),
          'cart_url'                => apply_filters( 'woocommerce_add_to_cart_redirect', wc_get_cart_url() ),
          'is_cart'                 => is_cart(),
          'cart_redirect_after_add' => get_option( 'woocommerce_cart_redirect_after_add' )
        ) );
      wp_localize_script( 'sage_js', 'wc_add_to_cart_variation_params', array(
          'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce' ),
          'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'woocommerce' ),
          'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce' )
        ) );
      wc_get_template( 'single-product/add-to-cart/variation.php' );
      wp_localize_script( 'sage_js', 'wc_additional_variation_images_local', array(
      'ajaxurl'              => admin_url( 'admin-ajax.php' ),
      'ajaxImageSwapNonce'   => wp_create_nonce( '_wc_additional_variation_images_nonce' ),
      'gallery_images_class' => apply_filters( 'wc_additional_variation_images_gallery_images_class', '.product .images .thumbnails' ),
      'main_images_class'    => apply_filters( 'wc_additional_variation_images_main_images_class', '.product .images > a' ),
      'lightbox_images'      => apply_filters( 'wc_additional_variation_images_main_lightbox_images_class', '.product .images a.zoom' ),
      'custom_swap'          => apply_filters( 'wc_additional_variation_images_custom_swap', false ),
      'custom_original_swap' => apply_filters( 'wc_additional_variation_images_custom_original_swap', false ),
      'custom_reset_swap'    => apply_filters( 'wc_additional_variation_images_custom_reset_swap', false ),
    ) );
          wp_localize_script(
      'sage_js',
      'wpmenucart_ajax',
      array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce('wpmenucart')
      )
    );


}
    add_action( 'wp_head',  __NAMESPACE__ . '\\deregister_assets', 7 );
    add_action( 'wp_footer', __NAMESPACE__ . '\\deregister_assets' );
    add_action( 'wp_print_scripts', __NAMESPACE__ . '\\deregister_printed_assets',100 );

    function deregister_assets() {

    $assets=["scripts"=>['touch','responsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','wc-add-to-cart-variation','add-to-cart-variation_ajax'],"styles"=>['responsive-menu-pro','ct-styles','woocommerce-layout','woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive']];

    if ( !empty( $assets['scripts'] ) ) {
      foreach( $assets['scripts'] as $handle ) {
        wp_deregister_script( $handle );
      }
    }

    if ( !empty( $assets['styles'] ) ) {
      foreach( $assets['styles'] as $handle ) {
        wp_deregister_style( $handle );
      }
    }
  }
 function deregister_printed_assets(){
    wp_deregister_script( 'wpml-browser-redirect' );
    wp_register_script('wpml-browser-redirect', ICL_PLUGIN_URL . '/res/js/browser-redirect.js', array('jquery'), ICL_SITEPRESS_VERSION);

        $args['skip_missing'] = intval( apply_filters( 'wpml_setting', false, 'automatic_redirect' ) == 1 );

        // Build multi language urls array
        $languages      = apply_filters( 'wpml_active_languages', NULL, $args);
        $language_urls  = array();
        foreach($languages as $language) {
      if(isset($language['default_locale']) && $language['default_locale']) {
        $language_urls[$language['default_locale']] = $language['url'];
        $language_parts = explode('_', $language['default_locale']);
        if(count($language_parts)>1) {
          foreach($language_parts as $language_part) {
            if(!isset($language_urls[$language_part])) {
              $language_urls[$language_part] = $language['url'];
            }
          }
        }
      }
      $language_urls[$language['language_code']] = $language['url'];
        }
        // Cookie parameters
        $http_host = $_SERVER['HTTP_HOST'] == 'localhost' ? '' : $_SERVER['HTTP_HOST'];
        $cookie = array(
            'name' => '_icl_visitor_lang_js',
            'domain' => (defined('COOKIE_DOMAIN') && COOKIE_DOMAIN? COOKIE_DOMAIN : $http_host),
            'path' => (defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/'),
            'expiration' => apply_filters( 'wpml_setting', false, 'remember_language' ),
        );

        // Send params to javascript
        $params = array(
            'pageLanguage'      => defined('ICL_LANGUAGE_CODE')? ICL_LANGUAGE_CODE : get_bloginfo('language'),
            'languageUrls'      => $language_urls,
            'cookie'            => $cookie
        );
        wp_localize_script('wpml-browser-redirect', 'wpml_browser_redirect_params', $params);
        wp_enqueue_script('wpml-browser-redirect');
 }
function js_async_attr($tag){

    # Do not add async to these scripts
    $scripts_to_exclude = array('jquery');
    $scripts_to_include = array();
    foreach($scripts_to_exclude as $exclude_script){
          global $wp_scripts;
          $scripts=get_object_vars ($wp_scripts);
        if(true == strpos($tag, basename($scripts['registered'][$exclude_script]->src) ) )
        return $tag;

    }
//foreach($scripts_to_include as $include_script){
       // if(true != strpos($tag, $include_script ) )
        return str_replace( ' src', ' async="async" src', $tag );
  //  }
    //return $tag;
    # Add async to all remaining scripts


}
add_filter( 'script_loader_tag', __NAMESPACE__ . '\\js_async_attr', 10 );
