<?php get_template_part('templates/page', 'header'); ?>
<section id="national">
	<h3> National Distributor </h3>	
<ul class="national-list">
	

	<?php 
$myrows = get_posts(['post_type'=>'distributori_nat'] );

foreach ($myrows as $key => $national) {
	echo'
<li class="national-element">
	<h4 class="national-title area-comp">'.get_field('area_di_competenza', $national->ID) .'</h4>
	<h5 class="national-title nome-azienda">'. $national->post_title .'</h5> 
	<p class="national-p national-address"><span class="national-name">'.get_field('sede', $national->ID) .'</span>
	<span class="national-span national-addr">'.get_field('indirizzo', $national->ID) .'</span>
	<span class="national-span national-city">'.get_field('città', $national->ID) .'</span>
	<span class="national-span national-provincia">'.get_field('provincia', $national->ID) .'</span>
	<span class="national-span national-nazione">'.get_field('nazione', $national->ID) .'</span> </p> 
	
	 <p class="national-p national-email"><a class="national-email-link" href="mailto:'.get_field('email', $national->ID) .'" >'.get_field('email', $national->ID) .'</a></p> 

</li>
	';

}
?>
</ul>
</section>
<?php  
$e = new WC_Geolocation();
$geolocate=$e->geolocate_ip();
if(is_array($geolocate) && isset($geolocate['country']) && $geolocate['country'] === 'IT'){
?>
<section id="normal">
<h3> Authorized retailers</h3>		
<?php 
echo do_shortcode('[SLPLUS]' );
?>
</section>
<?php  
}
?>


