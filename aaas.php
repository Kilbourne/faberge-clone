<?php


add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets', 998);

function enqueue_assets(){
  wp_enqueue_style('sage_css', Assets\asset_path('styles/main.css'), false, null);
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
  wp_enqueue_script('jquery',  Assets\asset_path('scripts/jquery.js'), array(),null, true);

  //wp_enqueue_script('wpml-browser-redirect',ICL_PLUGIN_URL . '/res/js/browser-redirect.js',['jquery'],ICL_SITEPRESS_VERSION,true);

  wp_enqueue_script('sage_js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);

}

function asset_bundler($bundles=[],$localize=[],$reregister=[],
$head_scripts=[]
){
  global $wp_scripts;
  global $wp_styles;

  $all_deps=[];
  var_dump($wp_scripts->all_deps('jquery-cookie'));
  foreach ($wp_scripts->queue as $handle) {
    if($wp_scripts->registered[$handle]->deps){
      foreach ($wp_scripts->registered[$handle]->deps as $key => $dep) {
        if(!isset($all_deps[$dep])) $all_deps[$dep]=[];
        $all_deps[$dep][$handle]=isset($wp_scripts->registered[$dep])?$wp_scripts->registered[$dep]->deps:false;
      }
    }
  }

  // $bundles=['bundle'=>['assets'=>['foo','bar'],'type'=>[],'deregister'=>[],'not-dequeue'=>[],'not-enqueue'=>[]]];
  $manifest=[];
  foreach ($bundles as $bundle_slug => $bundle) {
    if($bundle['type']==='styles'){
      $manifest[$bundle_slug]=[];
      $manifest[$bundle_slug]['deps']=[];
      foreach( $bundle['assets'] as $handle ) {
        $manifest[$bundle_slug][$handle]=$wp_styles->registered[$handle]->src;
        if($wp_styles->registered[$handle]->deps)$manifest[$bundle_slug]['deps'][$handle]=$wp_styles->registered[$handle]->deps;
        wp_dequeue_style( $handle );
      }
    }
    if($bundle['type']==='scripts'){
      $manifest[]=[];

      $manifest[$bundle_slug]['deps']=[];
      foreach( $bundle['assets'] as $handle ) {
        if(!in_array($handle, $bundle['not-enqueue'])){
          $manifest[$bundle_slug][$handle]=$wp_scripts->registered[$handle]->src;
          if($wp_scripts->registered[$handle]->deps)$manifest[$bundle_slug]['deps'][$handle]=$wp_scripts->registered[$handle]->deps;
        }
        if($wp_scripts->registered[$handle]->deps){
          foreach ($wp_scripts->registered[$handle]->deps as $key => $dep) {
            if(in_array($dep, $bundle['assets'])){
              $to_unset=true;
              if(!isset($all_deps[$dep]) ) {
                $to_unset=false;
              }elseif( array_diff(array_keys($all_deps[$dep]), $bundle['assets'])){
                $to_unset=false;
              }
              if($to_unset){
              foreach ($all_deps[$dep] as $key => $value) {
                  $diff=array_diff($value, $bundle['assets']);

                  if($diff && array_diff($diff, ['jquery'])) $to_unset=false;
              }
              }
               if($to_unset)unset($all_deps[$dep][$handle]);

              if(isset($all_deps[$dep]) && !$all_deps[$dep]) unset($all_deps[$dep]);
            }
          }
        }

        if(in_array($handle, $bundle['deregister'])){
          $wp_scripts->print_extra_script($handle);
          wp_deregister_script( $handle );
        }elseif(!in_array($handle, $bundle['not-dequeue'])){
          if($handle==='touch')var_dump($wp_scripts->registered['touch'],$wp_scripts->registered['jquery']);
          $wp_scripts->print_extra_script($handle);
          wp_dequeue_script( $handle );
          if($handle==='touch') var_dump($wp_scripts->registered[$handle],$wp_scripts->registered['jquery']);
        }
      }

    }
  }

  //$head_scripts=['foo','bar'];
  foreach ($wp_scripts->queue as $queued_script) {
    if(!in_array($queued_script, $head_scripts) && !in_array($queued_script, $wp_scripts->in_footer)) $wp_scripts->in_footer[]=$queued_script;
  }
  // $localize=[];
   foreach( $localize as $handle=>$prop ) {
        wp_localize_script( $handle, $prop['key'],$prop['value'] );
    }
// echo'<style type="text/css" media="screen">
//   body{
//     color:#fff;
//     white-space:pre;
//     padding:50px 2%;       ;
//   }
//   #wpadminbar{
//   white-space:normal;
// }
// </style>';
 // echo'<h3>Manifest</h3>';
  //var_dump($manifest);
 // echo'<h3>Dependencies</h3>';
 // var_dump($all_deps);
    unset($all_deps['jquery']);
    unset($all_deps['jquery-cookie']);
    var_dump($all_deps);
}
add_filter( 'wp_head', __NAMESPACE__ . '\\asset_bundler_caller', 999);

function asset_bundler_caller(){


  if(!( is_admin() || Is_Backend_LOGIN() )){
     echo'<style type="text/css" media="screen">
   body{
     color:#fff;
     white-space:pre;
     padding:50px 2%;       ;
   }
   #wpadminbar{
   white-space:normal;
 }</style>';
 /*
 concat
 group
 deps
 */
    global $wp_scripts;
  $wp_scripts->registered['wpml-browser-redirect']->deps[1]='jquery-cookie';
 foreach ( get_object_vars( $wp_scripts ) as $n => $v ) {

  if(in_array($n, [])) var_dump($n,$v);
 }
 $flat=[];
 var_dump(flat_deps($wp_scripts->queue,$flat),$flat);
}
}
$not_registered=[];



function flatten(array $array) {
    $return = array();
    array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
    return $return;
}

//add_filter( 'script_loader_tag', __NAMESPACE__ . '\\js_async_attr', 10 );
//    asset_bundler(
//  [
//    "main.js"=>[
//      "assets"=>["underscore",'jquery-cookie','wp-util','jquery-blockui','touch','//responsive-menu-pro','woocommerce','wc-cart-fragments','wpmenucart','//wc_additional_variation_images_script','wc-add-to-cart','wc-add-to-cart-variation',//'add-to-cart-variation_ajax','yith_wccl_frontend',"wc-country-select","//yith-wcms-step"],
//      'type'=>'scripts',
//      'deregister'=>[],'not-dequeue'=>[],'not-enqueue'=>['']
//    ],
//    "main.css"=>[
//      "assets"=>['responsive-menu-pro','ct-styles','woocommerce-layout','//woocommerce-smallscreen','woocommerce-general','wpmenucart-icons','wpmenucart','//yith_wccl_frontend','yith-wcms-checkout','yith-wcms-checkout-responsive'],
//      "type"=>"styles"
//
//    ]
//  ],
//  [
//    'sage_js' =>[
//      'key'=>'faberge',
//      "value"=>array(
//        'ajax_url' => admin_url( 'admin-ajax.php' )
//      )
//    ]
//  ],
//  ["scripts"=>['jquery'=>['src'=>Assets\asset_path('scripts/main.js'), 'deps'=>false,'ver'//=>false]],"styles"=>[]] );
//}
//
//}

function js_async_attr($tag){

    # Do not add async to these scripts
    $scripts_to_exclude = array('jquery','checkout');
    $scripts_to_include = array();
    foreach($scripts_to_exclude as $exclude_script){
      $manifest = new Assets\JsonManifest($manifest_path);
      global $wp_scripts;
      $scripts=get_object_vars ($wp_scripts);
      if ( array_key_exists($exclude_script, $manifest->get()) || ( $scripts->registered[$exclude_script] && $scripts->registered[$exclude_script] && true == strpos($tag, '/'.basename($scripts['registered'][$exclude_script]->src) ) ) ) return $tag;
    }
          //foreach($scripts_to_include as $include_script){
       // if(true != strpos($tag, $include_script ) )
    return str_replace( ' src', ' async="async" src', $tag );
          //  }
    //return $tag;
    # Add async to all remaining scripts
}
