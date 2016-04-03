<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $product;
$cat=filter_woocommerce_get_related_term_terms(wp_get_post_terms( $product->id, 'product_cat' ))[0];
?>

<h1 itemprop="name" class="category_title entry-title"><?php echo $cat->name; ?></h1>
<h2 itemprop="name" class="product_title entry-title"><span ><?php _e('Cod. ','faberge'); ?>	</span><span class="codice"><?php the_title(); ?></span></h2>
