<?php
use Roots\Sage\Assets;


/**
 * Remove Hooks
 */

// Remove Woocommerce BreadCumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

// Remove Product Data Tabs
remove_action( 'woocommerce_after_single_product_summary','woocommerce_output_product_data_tabs', 10, 0);


/**
 * Archive Description
 *
 * Replace Hooks
 *
 */

remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description2', 20 );

function woocommerce_taxonomy_archive_description2() {
    if ( is_tax( array( 'product_cat', 'product_tag' ) ) && 0 === absint( get_query_var( 'paged' ) ) ) {
        $description = term_description() ;
        $title = single_term_title('',false) ;
        if ( $description ) {
            echo '<div class="term-description"><h3 class="term-description-title">'.$title.'</h3>'. $description . '</div>';
        }
    }
}


function category_has_children($cat_id){
  $children=get_term_children( $cat_id, "product_cat" );
  return count($children)>0?true:false;
}

function get_category_attachment_url($cat_id){
  $thumbnail_id = get_woocommerce_term_meta( $cat_id, 'thumbnail_id', true );
  return wp_get_attachment_url( $thumbnail_id );
}

function get_category_single_product_content($cat_id){
  global $post;
  $posts= get_posts(
    array(
      'post_type' => 'product',
      'posts_per_page' => 1,
      'tax_query'=> array(
                      array(
                        'taxonomy'      => 'product_cat',
                        'terms'         => $cat_id,
                      )
                    )
    )
  );
  $post=$posts[0];
  setup_postdata( $post );
  enqueue_category_single_product_scripts();
  wc_get_template_part( 'content', 'single-product' );
  wp_reset_postdata();
}

function enqueue_category_single_product_scripts(){
    $suffix               = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
    $lightbox_en          = 'yes' === get_option( 'woocommerce_enable_lightbox' );

    $assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
    $frontend_script_path = $assets_path . 'js/frontend/';
    if ( $lightbox_en ) {
      wp_enqueue_script( 'prettyPhoto', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.6', true );
      wp_enqueue_script( 'prettyPhoto-init', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery','prettyPhoto' ) );
      wp_enqueue_style( 'woocommerce_prettyPhoto_css', $assets_path . 'css/prettyPhoto.css' );
    }

      wp_enqueue_script( 'wc-single-product' );
}


/**
 *
 *  Single Product Summary
 *
 */

add_action( 'woocommerce_single_product_summary', 'woocommerce_pre_single_product_summary', 1,2 );

function woocommerce_pre_single_product_summary(){
    echo '<div class="title-and-cart"><div class="single-product-title-wrapper">';
};


add_action( 'woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_title', 11,2 );

function woocommerce_after_single_product_summary_title(){
    echo '</div><div class="single-product-cart-wrapper">';
}


remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_add_to_cart', 30, 0);

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 12,2 );


add_action( 'woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_single_add_to_cart', 13,2 );

function woocommerce_after_single_product_summary_single_add_to_cart(){
    echo '</div></div>';
};


add_action( 'woocommerce_single_product_summary', 'attributes_woocommerce_single_product_summary', 14,2 );

function attributes_woocommerce_single_product_summary( ) {
        global $product;
        $product->list_attributes();
};


remove_action( 'woocommerce_single_product_summary','woocommerce_template_single_meta', 40, 0);


add_filter( 'woocommerce_attribute','attribute_size_image',10,3);

function attribute_size_image( $wpautop,$attribute,$values){
  $display=$wpautop;
  if($attribute['name']=="pa_measure"   ){
    global $product;
    
    foreach ($values as $key => $value) {
      if(strpos($value, 'mm')){
        $val= ((intval($value)*46)/28);
        $display='';
      $display.='<div class="size-wrap" >'.wp_get_attachment_image( 2620 , 'thumb', false, array("style"=>"width:".$val."px;") ).'<div >
        <p>'.$value.'</p>
      </div></div>';
      }      
    }
  }
    return $display ;
  
}


/**
 *
 * Related Products
 *
 */

add_filter( "woocommerce_get_related_product_cat_terms", 'filter_woocommerce_get_related_term_terms', 40, 2 );

function filter_woocommerce_get_related_term_terms( $wp_get_post_terms ) {
  foreach ($wp_get_post_terms as $key => $value) {
    $children = get_categories( array ('taxonomy' => 'product_cat', 'parent' => $value->term_id ));
    if ( count($children) == 0 ) {$arr[]=$value;}
  }
  return $arr;
};

add_filter( 'woocommerce_product_related_posts_relate_by_tag', function() { return false; });


/**
 *
 * Variations Thumbnails
 *
 */

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
        $slider='';
        $x=0;
        if($count>6) $slider.='<div id="slider-variation">
    <div class="swiper-wrapper">';
        foreach( $available_variations as $key => $variation ){
          $var_id = $variation["variation_id"];
          if( has_post_thumbnail( $var_id ) ){
            $variation_obj=$product->get_child($var_id);
            $value=$variation_obj->get_sku();
            $price=$variation_obj->get_price();
            $gallery_image_link=false;
            if($variation_data['pa_color'] && count($variation_data['pa_color'])>1){
              // !
              $color=$variation['attributes']["attribute_pa_color"];
              if(!in_array($color, $used_color)){
                $x++;
                $active=$default==$color?true:false;              
                $image=$variation_obj-> get_image('thumbnail');
                $image_ids = get_post_meta( $var_id, '_wc_additional_variation_images' );
                $gallery_image_link  = wp_get_attachment_url( $image_ids[0]);
                $display.='<div id="var-'.$var_id.'"class="variation';
                if($count>6){$display.=' swiper-slide ';}
                if($active){$display.= ' active default ';}
                $display.=' " data-color="'.$color.'" >'.$image.'</div>';  
                $used_color[]=$color;
                $results[$var_id]=array("image"=>$variation_obj-> get_image('full'),"value"=>$value,"variation_image"=>$gallery_image_link,"price"=>$price,"attributes"=>$variation['attributes']);
              }                            
            }
            
          }
          
        }
        $slider2='';
        if($count>6) $slider2.='</div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>


</div>';
      if($x>0) $display=$slider.$display.$slider2;
      }

       echo '<div class="variations-thumbs">'.$display.'</div><script> productVariation='.json_encode($results).';</script>';
  }
}


/**
 *
 * Ajax Product Detail
 *
 */

function faberge_get_product_detail() {
  $product_id = $_POST['product_id'];
  $args = array(
    'post_type' => 'product',
    'p'  => $product_id,
  );
  $query = new WP_Query( $args );
  if(!wp_script_is( 'wc-add-to-cart-variation' )){ wp_enqueue_script( 'wc-add-to-cart-variation' ); }

  if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            wc_get_template_part( 'content', 'single-product' );
        endwhile;
     else :
        echo "There were no posts found";
    endif;
    wp_reset_query();
  //faberge_woocommerce_single_product_variations(FALSE);
  wp_die();
}

add_action('wp_ajax_get_product_detail', __NAMESPACE__ . '\\faberge_get_product_detail');
add_action('wp_ajax_nopriv_get_product_detail', __NAMESPACE__ . '\\faberge_get_product_detail');

