<?php
/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$current_user=wp_get_current_user();
?>

<div class="account-topbar"><span><?php 
echo sprintf( esc_attr__( 'Hello %s%s%s', 'woocommerce' ),'<strong>', esc_html( $current_user->display_name ), '</strong>' );
 ?></span><span class="right"><?php 
echo sprintf( esc_attr__( '%sSign out%s', 'woocommerce' ),'<a href="' . esc_url( wc_get_endpoint_url( 'customer-logout', '', wc_get_page_permalink( 'myaccount' ) ) ) . '">', '</a>' )
  ?></span></div> 
<nav class="woocommerce-MyAccount-navigation">
	<ul>
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) :
      if(strpos($endpoint, 'edit-address') !== false){

        switch ($endpoint) {
          case 'edit-address':
            $url=false;
            break;
          case 'edit-address-shipping':
             $url=wc_get_account_endpoint_url( 'edit-address/shipping');
            break;
            case 'edit-address-billing':
             $url=wc_get_account_endpoint_url( 'edit-address/billing');
            break;
        }
      }
      else{
        $url=wc_get_account_endpoint_url( $endpoint);
      }
      $anchor= $url !==false?array("<a href=".esc_url( $url ).">","</a>"):array('<a>','</a>');
    ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
      <?php if(is_array($anchor)){
          echo $anchor[0].esc_html( $label ).$anchor[1];
        }else{echo esc_html( $label );} ?>

			</li>
		<?php endforeach; ?>
	</ul>
</nav>
