<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
    <script>
window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
ga('create', 'UA-78528632-1', 'auto');
ga('set', 'anonymizeIp', true);
ga('send', 'pageview');
</script>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php include "svg.php"; ?>
    <div class="page-wrapper ">
        <?php
        do_action('body_open');
      do_action('get_header');
      get_template_part('templates/header'); ?>
      <?php if(!is_front_page()){ ?> <div class="page-wrapper page-wrapper--little "> <?php } ?>
    <?php  if(is_tax('product_cat' ) || is_singular('product')){
        get_header( 'shop' );
      }
    ?>


    <div class="wrap container" role="document">
      <div class="content">
        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
      </div><!-- /.content -->
    </div><!-- /.wrap -->
<?php if(!is_front_page()){ ?>  </div> <?php } ?>
      <?php

      do_action('get_footer');
      get_template_part('templates/footer');
      echo do_shortcode('[responsive_menu_pro_menu] ' );
      wp_footer();

    ?>
    </div>
    <?php do_action('body_close'); ?>


  </body>
</html>
