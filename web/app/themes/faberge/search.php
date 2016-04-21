<?php get_template_part('templates/page', 'header'); ?>

<?php
global $query_string;

$query_args = explode("&", $query_string);
$search_query = array();
$search_query['post_type']='wpsl_stores';
if( strlen($query_string) > 0 ) {
	foreach($query_args as $key => $string) {
		$query_split = explode("=", $string);
		$search_query[$query_split[0]] = urldecode($query_split[1]);
	} // foreach
} //if

$search = new WP_Query($search_query);
?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post();echo 'aaaa'; ?>
  <?php get_template_part('templates/content', 'search'); ?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>
