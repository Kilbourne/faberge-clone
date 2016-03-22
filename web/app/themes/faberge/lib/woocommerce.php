<?php
use Roots\Sage\Assets;


//add_filter('woocommerce_show_page_title', '__return_false');
//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
// Remove default WooCommerce breadcrumbs and add Yoast ones instead
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta', 40, 0);
remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30, 0);
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10, 0);


//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description2', 20 );
//add_action( 'woocommerce_before_single_product_summary', 'faberge_woocommerce_single_product_variations', 21, 0 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_pre_single_product_summary', 1,2 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_title', 11,2 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_single_add_to_cart', 13,2 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 12,2 );
add_action( 'woocommerce_single_product_summary', 'attributes_woocommerce_single_product_summary', 14,2 );

add_filter( "woocommerce_get_related_product_cat_terms", 'filter_woocommerce_get_related_term_terms', 40, 2 );
add_filter( 'woocommerce_output_related_products_args', 'faberge_related_products_args' );
add_filter( 'woocommerce_product_related_posts_relate_by_tag', function() {
    return false;
});
add_filter( 'woocommerce_attribute','attribute_size_image',10,3);
add_filter( 'woocommerce_product_related_posts_query', function( $query ) {
    $query['limits'] = '';
    return $query;
});
function print_r_reverse($in) {
    $lines = explode("\n", trim($in));
    if (trim($lines[0]) != 'Array') {
        // bottomed out to something that isn't an array
        return $in;
    } else {
        // this is an array, lets parse it
        if (preg_match("/(\s{5,})\(/", $lines[1], $match)) {
            // this is a tested array/recursive call to this function
            // take a set of spaces off the beginning
            $spaces = $match[1];
            $spaces_length = strlen($spaces);
            $lines_total = count($lines);
            for ($i = 0; $i < $lines_total; $i++) {
                if (substr($lines[$i], 0, $spaces_length) == $spaces) {
                    $lines[$i] = substr($lines[$i], $spaces_length);
                }
            }
        }
        array_shift($lines); // Array
        array_shift($lines); // (
        array_pop($lines); // )
        $in = implode("\n", $lines);
        // make sure we only match stuff with 4 preceding spaces (stuff for this array and not a nested one)
        preg_match_all("/^\s{4}\[(.+?)\] \=\> /m", $in, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        $pos = array();
        $previous_key = '';
        $in_length = strlen($in);
        // store the following in $pos:
        // array with key = key of the parsed array's item
        // value = array(start position in $in, $end position in $in)
        foreach ($matches as $match) {
            $key = $match[1][0];
            $start = $match[0][1] + strlen($match[0][0]);
            $pos[$key] = array($start, $in_length);
            if ($previous_key != '') $pos[$previous_key][1] = $match[0][1] - 1;
            $previous_key = $key;
        }
        $ret = array();
        foreach ($pos as $key => $where) {
            // recursively see if the parsed out value is an array too
            $ret[$key] = print_r_reverse(substr($in, $where[0], $where[1] - $where[0]));
        }
        return $ret;
    }
}

function faberge_woocommerce_single_product_variations(){
  global $product;
  if( $product->is_type( 'variable' ) ){
      $available_variations = $product->get_available_variations();
      $variation_data = $product->get_variation_attributes();
      $results=array();
      if(is_array( $variation_data )){
        $default=strtolower($product->get_variation_default_attribute( "pa_color" ));
        $used_color=array();
        $display="";
        $count=count($available_variations);
        if($count>5) $display.='<div id="slider-variation">
    <div class="swiper-wrapper">';
        foreach( $available_variations as $key => $variation ){
          $var_id = $variation["variation_id"];
          $variation_obj=$product->get_child($var_id);
          $value=$variation_obj->get_sku();
          // !!!
          $price="";
          $gallery_image_link=false;
          if($variation_data['pa_color'] && count($variation_data['pa_color'])>1){
            // !
            $color=$variation['attributes']["attribute_pa_color"];
            if(!in_array($color, $used_color)){
              $active=$default==$color?true:false;

              $image=$variation_obj-> get_image('thumbnail');
              $image_ids = get_post_meta( $var_id, '_wc_additional_variation_images' );
              $gallery_image_link  = wp_get_attachment_url( $image_ids[0]);
              $display.='<div id="var-'.$var_id.'"class="variation';
              if($count>5){$display.=' swiper-slide ';}
              if($active){$display.= ' active default ';}
              $display.=' " data-color="'.$color.'" >'.$image.'</div>';
              $used_color[]=$color;
            }
          }
          $results[$var_id]=array("image"=>$variation_obj-> get_image('full'),"value"=>$value,"variation_image"=>$gallery_image_link,"price"=>$price);
        }
        if($count>7) $display.='</div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>


</div>';
      }
       echo '<div class="variations">'.$display.'</div><script> productVariation='.json_encode($results).';</script>';
  }
}

function filter_woocommerce_get_related_term_terms( $wp_get_post_terms ) {
  foreach ($wp_get_post_terms as $key => $value) {
   $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $value->term_id ));

   if ( count($children) == 0 ) {$arr[]=$value;}
  }
    return $arr;
};
// !! A che serve??
function woocommerce_taxonomy_archive_description2() {
    if ( is_tax( array( 'product_cat', 'product_tag' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
        $description = term_description() ;
        $title = single_term_title('',false) ;
        if ( $description ) {
            echo '<div class="term-description"><h3 class="term-description-title">'.$title.'</h3>'. $description . '</div>';
        }
    }
}

    // !! A che serve??
    function attributes_woocommerce_single_product_summary( ) {
        global $product;
        $product->list_attributes();
    };


 function woocommerce_pre_single_product_summary(){
    echo '<div class="title-and-cart"><div class="single-product-title-wrapper">';
 };
 function woocommerce_after_single_product_summary_title(){
    echo '</div><div class="single-product-cart-wrapper">';
 }

 function woocommerce_after_single_product_summary_single_add_to_cart(){
    echo '</div></div>';
 };


  function faberge_related_products_args( $args ) {
  $args['posts_per_page'] = 9999; // 4 related products
  return $args;
}

function attribute_size_image( $wpautop,$attribute,$values){
  if($attribute['name']=="pa_measure"){
    global $product;
    foreach ($values as $key => $value) {
      $display='';
      $display.='<div class="size-wrap">'.wp_get_attachment_image( 2620 , 'thumb' ).'<p>'.$value.'</p></div>';

    }
    return $display ;
  }else{
    return $wpautop;
  }
}
