<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table shop_table_responsive cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-remove">&nbsp;</th>			
			<th class="product-image"></th>	
			<th class="product-name"></th>			
			<th class="product-quantity not-empty"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-price not-empty"><?php _e( 'Price', 'woocommerce' ); ?></th>
			<th class="product-subtotal not-empty"><?php _e( 'Total', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
<<<<<<< HEAD
<<<<<<< HEAD
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
=======
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
>>>>>>> 49fa118... original

=======
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			
>>>>>>> 31be2e1... template
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
						?>
					</td>
<?php 	
		   $item_data = array();

      // Variation data
      if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

        foreach ( $cart_item['variation'] as $name => $value ) {

          if ( '' === $value )
            continue;

          $taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

          // If this is a term slug, get the term's nice name
          if ( taxonomy_exists( $taxonomy ) ) {
          	$term = get_term_by( 'slug', $value, $taxonomy );

          	if($taxonomy==="pa_color"){

        $label = wc_attribute_label( $taxonomy );
    $value = get_field( 'colori', $term )?get_field( 'colori', $term ):get_woocommerce_term_meta( $term->term_id,  'pa_color_yith_wccl_value'); 

}else{
            
 if ( ! is_wp_error( $term ) && $term && $term->name ) {
              $value = $term->name;
            }
            $label = wc_attribute_label( $taxonomy );
}
          // If this is a custom option slug, get the options name
          } else {
            $value              = apply_filters( 'woocommerce_variation_option_name', $value );
            $product_attributes = $cart_item['data']->get_attributes();
            if ( isset( $product_attributes[ str_replace( 'attribute_', '', $name ) ] ) ) {
              $label = wc_attribute_label( $product_attributes[ str_replace( 'attribute_', '', $name ) ]['name'] );
            } else {
              $label = $name;
            }
          }

          $item_data[] = array(
            'key'   => $label,
            'value' => $value
          );
        }
      }

      // Filter item data to allow 3rd parties to add more to the array
      $item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );      
      
      if ( sizeof( $item_data ) > 0 ) {
        $variation_id=$cart_item["variation_id"];
        $variation = wc_get_product($variation_id);
        	 
$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $variation->get_image(), $cart_item, $cart_item_key );
$title=$variation->get_sku();
        
      }else{
$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
$title=$_product->get_title();
      }
 ?>
 <td class="product-thumb" >
					<div class="cart-thumbnail-wrapper">
							<?php
							

							if ( ! $_product->is_visible() ) {
								echo $thumbnail;
							} else {
								printf( '<a href="%s">%s</a>', esc_url( $_product->get_permalink( $cart_item ) ), $thumbnail );
							}
						?>
<<<<<<< HEAD
<<<<<<< HEAD
					</div>

					</td><td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
<div class="cart-details-wrapper">
					<?php if ( ! $_product->is_visible() ) : ?>
	
		 <?php $product_cats = wp_get_post_terms( $_product->id, 'product_cat' ); 
		 		  if ( $product_cats && ! is_wp_error ( $product_cats ) ){

        $single_cat = array_shift( $product_cats ); ?>

        <span class="minicart-category"><?php echo $single_cat->name; ?></span>

<?php }
		 ?> 
	<span class="minicart-name">
		<?php echo  $product_name ; ?>	
	</span> 
	
<?php else : ?>
			 <?php $product_cats = wp_get_post_terms( $_product->id, 'product_cat' ); 
		 		  if ( $product_cats && ! is_wp_error ( $product_cats ) ){

        $single_cat = array_shift( $product_cats ); ?>

        

<?php }     if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_sku(), $cart_item, $cart_item_key );

      }else{
      	$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
      }
		 ?> 
	
	<a class="minicart-name-link"href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
		<span  class="minicart-category"><?php echo $single_cat->name; ?></span><span class="minicart-name"><?php echo $product_name ; ?></span> 
	</a>

	
=======
					</td>
>>>>>>> 49fa118... original
=======
					</div>
>>>>>>> 31be2e1... template

					</td><td class="product-name" data-title="<?php _e( 'Product', 'woocommerce' ); ?>">
<div class="cart-details-wrapper">
					<?php if ( ! $_product->is_visible() ) : ?>
	
		 <?php $product_cats = wp_get_post_terms( $_product->id, 'product_cat' ); 
		 		  if ( $product_cats && ! is_wp_error ( $product_cats ) ){

        $single_cat = array_shift( $product_cats ); ?>

        <span class="minicart-category"><?php echo $single_cat->name; ?></span>

<?php }
		 ?> 
	<span class="minicart-name">
		<?php echo  $product_name ; ?>	
	</span> 
	
<?php else : ?>
			 <?php $product_cats = wp_get_post_terms( $_product->id, 'product_cat' ); 
		 		  if ( $product_cats && ! is_wp_error ( $product_cats ) ){

        $single_cat = array_shift( $product_cats ); ?>

        

<?php }     if ( ! empty( $cart_item['data']->variation_id ) && is_array( $cart_item['variation'] ) ) {

        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_sku(), $cart_item, $cart_item_key );

      }else{
      	$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
      }
		 ?> 
	
	<a class="minicart-name-link"href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
		<span  class="minicart-category"><?php echo $single_cat->name; ?></span><span class="minicart-name"><?php echo $title ; ?></span> 
	</a>

	

<?php endif; 
							

							// Meta data
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 31be2e1... template
							//echo WC()->cart->get_item_data( $cart_item );
							if ( sizeof( $item_data ) > 0 ) {
							      foreach ( $item_data as $key => $data ) {
        // Set hidden to true to not display meta on cart.
							      	
							      	
        if ( ! empty( $data['hidden'] )  ) {
          unset( $item_data[ $key ] );
          continue;
        }
        $item_data[ $key ]['key']     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
        $item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
 
        if($data["key"]==="Color"){
<<<<<<< HEAD
 
    
      $item_data[ $key ]['display']='<div class="select_box_colorpicker select_box attribute_pa_color"><div  class="select_option_colorpicker select_option"><span style="background-color:'.$item_data[ $key ]["value"].' ;" class="yith_wccl_value"></span></div></div>';
=======
    if(is_array($item_data[ $key ]["value"])){
                             $item_data[ $key ]['display']='<div class="select_box_colorpicker select_box attribute_pa_color"><div  class="select_option_colorpicker select_option"><span style="background-color:'.$item_data[ $key ]["value"][0]['colore'].' ;" class="yith_wccl_value double"></span><span style="background-color:'.$item_data[ $key ]["value"][1]['colore'].' ;" class="yith_wccl_value double"></span></div></div>';
                          
                        }else{
                          $item_data[ $key ]['display']='<div class="select_box_colorpicker select_box attribute_pa_color"><div  class="select_option_colorpicker select_option"><span style="background-color:'.$item_data[ $key ]["value"].' ;" class="yith_wccl_value"></span></div></div>';
                        }

>>>>>>> 31be2e1... template
        }
      }

      // Output flat or in list format
      
        


          wc_get_template( 'cart/cart-item-data.php', array( 'item_data' => $item_data ) );


        
      }
<<<<<<< HEAD
=======
							echo WC()->cart->get_item_data( $cart_item );
>>>>>>> 49fa118... original
=======
>>>>>>> 31be2e1... template

							// Backorder notification
							if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
								echo '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>';
							}
						?>
						</div>
					</td>



					<td class="product-quantity not-empty" data-title="<?php _e( 'Quantity', 'woocommerce' ); ?>">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
									'min_value'   => '0'
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item );
						?>
					</td>
<<<<<<< HEAD
<<<<<<< HEAD
					<td class="product-price not-empty" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-subtotal not-empty" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
=======

					<td class="product-subtotal" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
>>>>>>> 49fa118... original
=======
					<td class="product-price not-empty" data-title="<?php _e( 'Price', 'woocommerce' ); ?>">
						<?php
						//if(isset($cart_item["variation_id"])){
						// $variation_id=$cart_item["variation_id"];
						// $variation = wc_get_product($variation_id);				 
						// $price=WC()->cart->get_product_price( $variation );
						//}else{
							$price=WC()->cart->get_product_price( $_product );
						//}
        
							echo apply_filters( 'woocommerce_cart_item_price', $price, $cart_item, $cart_item_key );
						?>
					</td>
					<td class="product-subtotal not-empty" data-title="<?php _e( 'Total', 'woocommerce' ); ?>">
>>>>>>> 31be2e1... template
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( wc_coupons_enabled() ) { ?>
					<div class="coupon">

						<label for="coupon_code"><?php _e( 'Coupon', 'woocommerce' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'woocommerce' ); ?>" />

						<?php do_action( 'woocommerce_cart_coupon' ); ?>
					</div>
				<?php } ?>

				<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'woocommerce' ); ?>" />

				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
