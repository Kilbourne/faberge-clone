<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;
	
$attachment_ids = $product->get_gallery_attachment_ids();

foreach( $attachment_ids as $key => $attachment_id ) 
{
	$filename_only = basename( get_attached_file( $attachment_id ) );
//echo var_dump( strpos($filename_only, '_zoom') );
  if(strpos($filename_only, '_zoom')) unset($attachment_ids[$key]);
}

if (count($attachment_ids) ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			if ( $loop === 0 || $loop % $columns === 0 )
				$classes[] = 'first';

			if ( ( $loop + 1 ) % $columns === 0 )
				$classes[] = 'last';
			$file=get_attached_file( $attachment_id );
			$url=wp_get_attachment_url( $attachment_id );
			$path = pathinfo($file);
			$path_u = pathinfo($url);
			 $newfile = $path['dirname']."/".$path['filename']."_zoom.".$path['extension'];
			 $newurl=$path_u['dirname']."/".$path_u['filename']."_zoom.".$path_u['extension'];
			$image_link = file_exists($newfile) ? $newurl : $url;

			if ( ! $image_link )
				continue;
						 $pathinfo=pathinfo(parse_url($image_link, PHP_URL_PATH));

					//$image_link=$pathinfo['dirname'].'/'.$pathinfo['filename'].'_zoom'.'.'.$pathinfo['extension'];
			$image_title 	= esc_attr( get_the_title( $attachment_id ) );
			$image_caption 	= esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

			$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
				'title'	=> $image_title,
				'alt'	=> $image_title
				) );

			$image_class = esc_attr( implode( ' ', $classes ) );

			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_caption, $image ), $attachment_id, $post->ID, $image_class );

			$loop++;
		}

	?></div>
	<?php
}
?>
