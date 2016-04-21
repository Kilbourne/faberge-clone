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
<h3> Retailers </h3>		
<?php 
$search_query = array();
$search_query['post_type']='wpsl_stores';
$stores = get_posts($search_query);
?>
</section>
<?php  
}
?>


<?php

$query_args = explode("&", $query_string);
$search_query = array();
$search_query['post_type']='wpsl_stores';
$search_query['s']='Luca';
if( strlen($query_string) > 0 ) {
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		if($query_split[0]==="s")$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach
} //if

$stores = get_posts($search_query);

echo var_dump($e->geolocate_ip()['country']);
echo var_dump($e);
if($stores){
	foreach ($stores as $key => $store) {
		echo  $store->post_title;
	}
}
?>


