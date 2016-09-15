<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<ul class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

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
            if ( ! is_wp_error( $term ) && $term && $term->name ) {
              $value = $term->name;
            }
            $label = wc_attribute_label( $taxonomy );

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
        $product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_sku(), $cart_item, $cart_item_key );

      }else{
      	$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
      }

      // Filter item data to allow 3rd parties to add more to the array
      $item_data = apply_filters( 'woocommerce_get_item_data', $item_data, $cart_item );

      // Format item data ready to display
      foreach ( $item_data as $key => $data ) {
        // Set hidden to true to not display meta on cart.
        if ( ! empty( $data['hidden'] ) ) {
          unset( $item_data[ $key ] );
          continue;
        }
        $item_data[ $key ]['key']     = ! empty( $data['key'] ) ? $data['key'] : $data['name'];
        $item_data[ $key ]['display'] = ! empty( $data['display'] ) ? $data['display'] : $data['value'];
      }

					
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>
					<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
						<?php if ( ! $_product->is_visible() ) : ?>
	<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) ; ?>
<?php else : ?>
	<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
		<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail )  ; ?>
	</a>
<?php endif; ?>
<?php if ( ! $_product->is_visible() ) : ?>
	<?php echo  $product_name ; ?>
<?php else : ?>
	<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
		<?php echo $product_name ; ?>
	</a>
<?php endif; ?>
	
						<?php //echo WC()->cart->get_item_data( $cart_item ); ?>

						<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
					</li>
					<?php
				}
			}
		?>

	<?php else : ?>

		<li class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></li>

	<?php endif; ?>

</ul><!-- end product list -->

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<p class="total"><strong><?php _e( 'Subtotal', 'woocommerce' ); ?>:</strong> <?php echo WC()->cart->get_cart_subtotal(); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="buttons">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward"><?php _e( 'View Cart', 'woocommerce' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward"><?php _e( 'Checkout', 'woocommerce' ); ?></a>
	</p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
