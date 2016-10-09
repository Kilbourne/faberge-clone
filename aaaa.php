<?php
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
 var_dump(recursive_deps($wp_scripts->queue));
}
}
function Is_Backend_LOGIN(){
    $ABSPATH_MY = str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ABSPATH);
    return (in_array($ABSPATH_MY.'wp-login.php', get_included_files()) || in_array($ABSPATH_MY.'wp-register.php', get_included_files()) );

}

function deps($handle){
  global $wp_scripts;

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
  		else($bundle['type']==='scripts'){ $global = &$wp_scripts; }
  		if(isset($global->registered[$handle])){
  			$obj =$global->registered[$handle];
  			$manifest[$bundle_slug][$handle]=$obj->src;
  		}
    }   
  }
  var_dump($manifest,$all_deps);
}