<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wp_query;
$en_id=get_term_by( 'slug', 'eggs', 'product_cat');
$original_cat_id =  apply_filters( 'wpml_object_id', $en_id->term_id, 'product_cat', true,ICL_LANGUAGE_CODE);
$final_term=get_term( $original_cat_id, 'product_cat');
$wp_query = new WP_Query( array(
  "product_cat" => $final_term->slug
) );


wc_get_template( 'taxonomy-product_cat.php' );
?>
