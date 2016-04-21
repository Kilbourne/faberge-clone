<?php get_template_part('templates/page', 'header'); ?>
<section>
	<h3> National Distributor </h3>	
</section>
<?php  
$e = new WC_Geolocation();
$geolocate=$e->geolocate_ip();
if(is_array($geolocate) && isset($geolocate['country']) && $geolocate['country'] === 'IT'){
?>
<section>
<h3> Authorized retailers</h3>		
<?php 
echo do_shortcode('[SLPLUS]' );
?>
</section>
<?php  
}
?>


