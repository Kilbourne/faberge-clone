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
  <?php do_action('body_open') ?>
    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <svg style="display:none;">
    <symbol id="INSTA_svg_icon"viewBox="0 0 220 200" >
<path id="XMLID_713_" fill="#808080" d="M32.588,0.01h148.65c14.12,0,25.67,11.551,25.67,25.671v148.657
  c0,14.121-11.55,25.661-25.67,25.661H32.588c-14.12,0-25.68-11.541-25.68-25.661V25.681C6.908,11.561,18.468,0.01,32.588,0.01z
   M152.608,22.221c-4.96,0-9.01,4.06-9.01,9.02v21.541c0,4.96,4.04,9.01,9.01,9.01h22.6c4.95,0,9.01-4.05,9.01-9.01V31.242
  c0-4.95-4.05-9.02-9.01-9.02H152.608z M184.298,84.584h-17.6c1.67,5.45,2.57,11.201,2.57,17.171c0,33.262-27.84,60.233-62.17,60.233
  c-34.33,0-62.17-26.971-62.17-60.233c0-5.98,0.91-11.721,2.57-17.171h-18.35v84.494c0,4.37,3.57,7.93,7.94,7.93h139.27
  c4.38,0,7.94-3.56,7.94-7.93L184.298,84.584L184.298,84.584z M107.098,60.653c-22.18,0-40.16,17.421-40.16,38.932
  c0,21.491,17.99,38.922,40.16,38.922c22.19,0,40.17-17.431,40.17-38.922C147.268,78.074,129.288,60.653,107.098,60.653z"/>
</symbol>
<symbol id="FB_svg_icon" viewBox="0 0 430.113 430.114" >
<g>
  <path id="Facebook" d="M158.081,83.3c0,10.839,0,59.218,0,59.218h-43.385v72.412h43.385v215.183h89.122V214.936h59.805   c0,0,5.601-34.721,8.316-72.685c-7.784,0-67.784,0-67.784,0s0-42.127,0-49.511c0-7.4,9.717-17.354,19.321-17.354   c9.586,0,29.818,0,48.557,0c0-9.859,0-43.924,0-75.385c-25.016,0-53.476,0-66.021,0C155.878-0.004,158.081,72.48,158.081,83.3z" fill="#000000"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
      </symbol>
      <symbol id="TW_svg_icon" viewBox="0 0 430.117 430.117">
        <g>
  <path id="Twitter__x28_alt_x29_" d="M381.384,198.639c24.157-1.993,40.543-12.975,46.849-27.876   c-8.714,5.353-35.764,11.189-50.703,5.631c-0.732-3.51-1.55-6.844-2.353-9.854c-11.383-41.798-50.357-75.472-91.194-71.404   c3.304-1.334,6.655-2.576,9.996-3.691c4.495-1.61,30.868-5.901,26.715-15.21c-3.5-8.188-35.722,6.188-41.789,8.067   c8.009-3.012,21.254-8.193,22.673-17.396c-12.27,1.683-24.315,7.484-33.622,15.919c3.36-3.617,5.909-8.025,6.45-12.769   C241.68,90.963,222.563,133.113,207.092,174c-12.148-11.773-22.915-21.044-32.574-26.192   c-27.097-14.531-59.496-29.692-110.355-48.572c-1.561,16.827,8.322,39.201,36.8,54.08c-6.17-0.826-17.453,1.017-26.477,3.178   c3.675,19.277,15.677,35.159,48.169,42.839c-14.849,0.98-22.523,4.359-29.478,11.642c6.763,13.407,23.266,29.186,52.953,25.947   c-33.006,14.226-13.458,40.571,13.399,36.642C113.713,320.887,41.479,317.409,0,277.828   c108.299,147.572,343.716,87.274,378.799-54.866c26.285,0.224,41.737-9.105,51.318-19.39   C414.973,206.142,393.023,203.486,381.384,198.639z" fill="#000000"/>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
      </symbol>
    </svg>
        <?php
      do_action('get_header');
      get_template_part('templates/header');
      if(is_tax('product_cat' ) || is_singular('product')){
        get_header( 'shop' );
      }
    ?>
    <div class="page-wrapper <?php if(!is_front_page()){ ?> page-wrapper--little <?php } ?>">

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
    </div>
      <?php
      do_action('body_close');
      ?>

            <?
      do_action('get_footer');
      get_template_part('templates/footer');
      echo do_shortcode('[responsive_menu_pro_menu] ' );

    ?>
    <?php wp_footer(); ?>
    <div class="credits">
     <div class="credits-wrap">
      <div class="left">
      <span>©2016</span>
      <span>MAISON TATIANA FABERGE SA</span>
      <span>GENEVE</span>
      <span>Fondée en 1974</span><span>|  Geneva, Switzerland</span><span>|  CH-660.0.115.974-8</span>    </div>
      <div class="right"><span>web agency</span>
      <span><a href="http://www.menthalia.com"><img src="<?php echo get_stylesheet_directory_uri().'/dist/images/logo-menthalia.png' ?>" alt="MENTHALIA LOGO"></a> </span> </div>
      </div>
    </div>

  </body>
</html>
