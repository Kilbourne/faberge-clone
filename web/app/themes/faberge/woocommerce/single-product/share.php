<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="social-wrap">	
<h5>SHARE</h5>
<?php 

			global $post;
function sf_get_current_url( $mode = 'base' ) {
			
			$url = 'http' . ( is_ssl() ? 's' : '' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			switch ( $mode ) {
				case 'raw' :
					return $url;
					break;
				case 'base' :
					return reset( explode( '?', $url ) );
					break;
				case 'uri' :
					$exp = explode( '?', $url );
					return trim( str_replace( home_url(), '', reset( $exp ) ), '/' );
					break;
				default:
					return false;
			}
		}
				$text = wp_strip_all_tags( esc_attr( rawurlencode( $post->post_title ) ) );
				$url = $post ? get_permalink() : sf_get_current_url( 'raw' );
				$image = has_post_thumbnail( $post->ID ) ? wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ) : '';
				$total_word =  __( 'Total: ', 'sage' ) ;
				$share_the_post_sentence 	= 'Share the post';										
				$rel_nofollow 				= 'rel="nofollow"';
				$juiz_sps_target_link =  ' target="_blank"';
				$div 	= 'div' ;
				$p 		= 'p' ;
				$ul 	= 'ul' ; 
				$li 	= 'li' ;


				// get the plugin options
				$juiz_sps_options = array (
  'juiz_sps_networks' => 
  array (
 
    'facebook' => 
    array (
      0 => 1,
      1 => 'Facebook',
    ),
 
  
    'twitter' => 
    array (
      0 => 1,
      1 => 'Twitter',
    )
  )
);
				/*

				// beginning markup
				$juiz_sps_content = '';
				$juiz_sps_content .= "\n" . '<' . $div . '>';
				$juiz_sps_content .= "\n" . '<' . $p . ' class="screen-reader-text juiz_sps_maybe_hidden_text">' . $share_the_post_sentence . ' "' . wp_strip_all_tags( get_the_title() ) . '"</' . $p . '>' . "\n";
				$juiz_sps_content .= "\n\t" . '<' . $ul . ' class="juiz_sps_links_list">';
				*/

				// networks to display
				// 2 differents results by: 
				// -- using hook (options from admin panel)
				// -- using shortcode/template-function (the array $networks in parameter of this function)

				$juiz_sps_networks = array();

				
					foreach( $juiz_sps_options['juiz_sps_networks'] as $k => $v ) {
						
							$juiz_sps_networks[ $k ] = $v;							
						
					}

			
					$results=[];
				// each links (come from options or manual array)
				foreach( $juiz_sps_networks as $k => $v ) {
					
						$api_link = $api_text = '';						
						$network_name = isset( $v[1] ) ? $v[1] : $k;	

						$twitter_user = //$juiz_sps_options['juiz_sps_twitter_user'] != '' ? '&amp;related=' . $juiz_sps_options['juiz_sps_twitter_user'] . '&amp;via=' . $juiz_sps_options['juiz_sps_twitter_user'] : 
						'';

						$api_text =  sprintf( __( 'Share this article on %s', 'sage' ), $network_name );

						$more_attr = $juiz_sps_target_link;

						switch ( $k ) {
							case 'twitter' :
								$api_link = 'https://twitter.com/intent/tweet?source=webclient&amp;original_referer=' . $url . '&amp;text=' . $text . '&amp;url=' . $url . $twitter_user;
								break;

							case 'facebook' :
								$api_link = 'https://www.facebook.com/sharer/sharer.php?u=' . $url;
								break;

							case 'google' :
								$api_link = 'https://plus.google.com/share?url=' . $url;
								break;							
						}

						$results[$k] = array('<a href="' . wp_strip_all_tags( esc_attr( $api_link ) ) . '" ' . $rel_nofollow . '' . $more_attr . ' title="' . esc_attr( $api_text ) . '">','</a>');
					
				}				

	
 ?>
<div class="social">
	<?php echo $results['facebook'][0]; ?>
	<span class="facebook">
	<svg class="fb-icon" >
	  <use xlink:href="#FB_svg_icon" fill="#949494"></use>
	<svg>
	</span> 
	<?php echo $results['facebook'][1].$results['twitter'][0]; ?>
	<span class="twitter">
	<svg class="twitter-icon" >
	  <use xlink:href="#TW_svg_icon" fill="#949494"></use>
	<svg>
	</span> 
	<?php echo $results['twitter'][1]; ?>
</div>
</div>
<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>
