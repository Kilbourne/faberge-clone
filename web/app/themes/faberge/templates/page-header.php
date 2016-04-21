<?php use Roots\Sage\Titles; 
$hidden=false;
if(is_page('store-locator')){$hidden=false;}
if(is_front_page())$hidden=true;
?>

<div class="page-header" <?php echo $hidden?'hidden':''; ?>>
  <h1><?= Titles\title(); ?></h1>
</div>
