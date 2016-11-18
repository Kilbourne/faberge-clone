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

$opts=[
  "bundle"=>[
    "underscore",'jquery-cookie','wp-util','jquery-blockui',"wc-country-select","wc-address-i18n",'wc-add-to-cart-variation','woocommerce',"wc-checkout",'touch','responsive-menu-pro','wc-cart-fragments','wpmenucart','wc_additional_variation_images_script','wc-add-to-cart','add-to-cart-variation_ajax','yith_wccl_frontend',"yith-wcms-step",'google_maps','sitepress','language-selector'
  ],
  "not_async"=>[
    'jquery','prettyPhoto',"password-strength-meter","zxcvbn-async","stripe",'select2'
  ],
  "css"=>[
    'responsive-menu-pro','ct-styles','woocommerce-layout','woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive','sitepress','language-selector'
  ]
];
new AssetBuilder($opts);
add_action( 'wp_print_scripts', __NAMESPACE__ . '\\wp_cookie',999);
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 998);

function enqueue_assets(){
  wp_enqueue_style('sage_css', Assets\asset_path('styles/main.css'), false, null);
  wp_deregister_script('wp-embed');
  wp_deregister_script('jquery');
  if(is_checkout()){
    wp_enqueue_script('sage_checkout',  Assets\asset_path('scripts/checkout.js'), array(),null, true);
  }
  wp_enqueue_script('jquery',  Assets\asset_path('scripts/jquery.js'), array(),null, true);
  //wp_enqueue_script('wpml-browser-redirect',ICL_PLUGIN_URL . '/res/js/browser-redirect.js',['jquery'],ICL_SITEPRESS_VERSION,true);
  wp_enqueue_script('sage_js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
  wp_localize_script( 'sage_js', 'faberge', array(
    'ajax_url' => admin_url( 'admin-ajax.php' ),
    'lang'=> ICL_LANGUAGE_CODE
  ));
}

function wp_cookie(){
  global $wp_scripts;
  $wp_scripts->registered['wpml-browser-redirect']->deps[1]='jquery-cookie';
}

class AssetBuilder{
  public $bundle = [];
  public $not_async = [];
  public $head_scripts = [];
  public $with_version = [];
  public $head_to_do=[];
  public $css=[];

  public function __construct($opts) {
    if(isset($opts['bundle'])) $this->bundle = $opts['bundle'];
    if(isset($opts['not_async'])) $this->not_async = $opts['not_async'];
    if(isset($opts['head_scripts'])) $this->head_scripts = $opts['head_scripts'];
    if(isset($opts['with_version'])) $this->with_version = $opts['with_version'];
    if(isset($opts['css'])) $this->css = $opts['css'];
    $this->bind_hook();
  }
  public function remove_bundled_style($src, $handle){
    if ( is_admin() || did_action('login_head') || ! isset($GLOBALS['wp_scripts']) ) {      ;
    }
    if(in_array($handle, $this->css)) return false;
    return $src;
  }
  public function remove_bundled_script($src, $handle){
   if ( is_admin() || did_action('login_head') || ! isset($GLOBALS['wp_scripts']) ) {
      return $src;
    }

    if(in_array($handle, $this->bundle)) return false;
    return $src;
  }

  public function bind_hook(){
    add_filter('print_scripts_array',array($this,'filter_script'));
    add_filter( 'script_loader_tag',array($this,'add_async_attr'),999,3);
    add_action( 'body_open', array($this,'open_body_ob'));
    add_action( 'body_close', array($this,'close_body_ob'));
    add_filter( 'style_loader_src', array($this,'remove_bundled_style'),999,2);
    add_filter( 'script_loader_src', array($this,'remove_bundled_script'),999,2);
  }
  public function filter_script($to_do){
    if ( is_admin() || did_action('login_head') || ! isset($GLOBALS['wp_scripts']) ) {
      return $to_do;
    }
    $wp_scripts = &$GLOBALS[ 'wp_scripts' ];
    foreach ($wp_scripts->to_do as $handle) {
      if( !isset( $wp_scripts->registered[$handle] ) ) continue;
      if( !in_array( $handle, $this->with_version ) && $wp_scripts->registered[$handle]->ver !== null ) $wp_scripts->registered[$handle]->ver = null;
      if( !in_array( $handle, $this->head_scripts ) && !in_array($handle,$wp_scripts->in_footer)  ) $wp_scripts->in_footer[]=$handle;
    }

    if( did_action( 'body_open' ) === 0){
      if( $wp_scripts->to_do  ){
        $this->head_to_do = array_unique(array_merge($this->head_to_do,$wp_scripts->to_do ));
        $to_do=[];
      }
    }
    return $to_do;
  }

  public function open_body_ob(){
    ob_start();
  }

  public function close_body_ob(){
    $ob=ob_get_clean();
    global $wp_scripts;
    $pos=strpos($ob,'<script');
    if($pos !== false){
       $matches=[];
    $aaa=true;
    $aaa=preg_match_all("/<script(.|\n)*?\/script>/",$ob, $matches);
if(isset($matches[0]) && is_array($matches[0])){
    foreach ($matches[0] as $key => $match) {
      $ob=str_replace($match,"",$ob);
    }
}
if($aaa !== false) echo $ob;
    $wp_scripts->do_items($this->head_to_do);
    if($aaa === true) echo $ob;
    if(isset($matches[0]) && is_array($matches[0])) echo implode("",$matches[0]);
    
    }else{
    echo $ob;
    }
 
    
  }


  public function add_async_attr($tag, $handle){
    if ( is_admin() || did_action('login_head') || ! isset($GLOBALS['wp_scripts']) ) {
      return $tag;
    }
    if( ! in_array( $handle, $this->not_async )) return str_replace( ' src', ' async="async" src', $tag );
    return $tag;
  }

  public function deps($handle){
    global $wp_scripts;
    return  isset($wp_scripts->registered[$handle])&& $wp_scripts->registered[$handle]->deps ? $wp_scripts->registered[$handle]->deps:false;
  }

  public function recursive_deps($array){
      if(is_array($array)){
          $new=[];
          foreach ($array as $key => $value) {
             $new[$value]=$this->recursive_deps($this->deps($value));
          }
      }else{
        $new=false;
      }
       return $new;
  }

  static function flat_deps($arr){
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

  static function manifest( $bundle,$css = false ){
    if($css){ global $wp_styles; $global = $wp_styles; }
    else{ global $wp_scripts; $global = $wp_scripts; }
    $manifest=[];
    $manifest[0]=[];
    $manifest[1]=[];
    foreach( $bundle as $handle ) {
      if(isset($global->registered[$handle])){
        $manifest[0][]=$handle;
        $manifest[1][]=$global->registered[$handle]->src;
      }
    }
    return json_encode($manifest);
  }

}

/*
!bug:not setted base price
    immagine iniziale
    menutab;

    account
    homepag link

store locator
blog
upgrade plugins
check if theme
*/
