<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
/**
 * Add <body> classes
 */
function body_class($classes)
{
    // Add page slug if it doesn't exist
    //$classes[]='page-wrapper';
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }
    if (is_product_category()) {
        global $wp_query;
        $cat = $wp_query->get_queried_object();

        $parent   = $cat->parent;
        $children = get_term_children($cat->ID, "product_cat");

        if ($parent !== 0 || count($children) === 0) {$classes[] = 'single-product';}
    }
    // Add class if sidebar is active
    if (Setup\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }

    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more()
{
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

add_filter('wp_nav_menu_items', __NAMESPACE__ . '\\add_biogena_logo_menu', 10, 2);
function add_biogena_logo_menu($items, $args)
{

    if ($args->menu == 'menu-1') // only for primary menu
    {
        $new_item = array('<li class="divisor menu-item menu-item-type-post_type menu-item-object-page"><hr/></li>');
        $items    = preg_replace('/<\/li>\s<li/', '</li>-BIOGENADELIMITER-<li', $items);

        $array_items = explode('-BIOGENADELIMITER-', $items);
        array_splice($array_items, 1, 0, $new_item); // splice in at position 3
        $items = implode('', $array_items);
    }
    return $items;
}

function faberge_panels_layout_classes($classes, $grid)
{
    $classes[] = 'parallax';
    return $classes;
}
add_filter('siteorigin_panels_layout_classes', __NAMESPACE__ . '\\faberge_panels_layout_classes', 10, 2);

function remove_admin_css()
{
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('admin_bar_init', __NAMESPACE__ . '\\remove_admin_css');

function remove_medialibrary_tab($strings)
{

    unset($strings["mediaLibraryTitle"]);
    return $strings;

}
add_filter('media_view_strings', __NAMESPACE__ . '\\remove_medialibrary_tab');

add_filter('woocommerce_account_menu_items', function () {
    return array(
        'dashboard'             => __('Profile details', 'woocommerce'),
        'orders'                => __('Orders', 'woocommerce'),
        'edit-address'          => __('Addresses', 'woocommerce'),
        'edit-address-billing'  => __('Billing address', 'woocommerce'),
        'edit-address-shipping' => __('Shipping address', 'woocommerce'),
        'payment-methods'       => __('Payment Methods', 'woocommerce'),
    );});

function language_selector()
{
    $languages = icl_get_languages('skip_missing=0');
    if (!empty($languages)) {
        echo '<ul id="lansel">';
        foreach ($languages as $l) {
            echo '<li ' . ($l['active'] ? 'class="active"' : '') . ' data-lang="' . $l['language_code'] . '" >';
            if (!$l['active']) {
                echo '<a href="' . $l['url'] . '">';
            }

            echo '' . $l['language_code'] . '';
            if (!$l['active']) {
                echo '</a>';
            }

            echo '</li>';
        }
    }
    echo '</ul>';
}

add_filter('wpseo_xml_sitemap_post_priority', __NAMESPACE__ . '\\my_custom_post_xml_priority', 10, 3);

function my_custom_post_xml_priority($return, $type, $post)
{
    if ($type == 'page') {
        if (get_the_title($post->ID) == 'Homepage') {
            $return = 1;
        } else {
            $return = 0.6;
        }
    } else if ($type == 'post') {
        $return = 0.3;
    } else if ($type == 'product') {
        $return = 1;
    }

    return $return;
}

add_filter('wpseo_posts_join', __NAMESPACE__ . '\\sitemap_per_language', 11, 2);
add_filter('wpseo_sitemap_entry', __NAMESPACE__ . '\\sitemap_per_language2', 11, 3);

function sitemap_per_language($join, $type)
{
    global $wpdb, $sitepress;
    $lang = $sitepress->get_current_language();
    return " JOIN " . $wpdb->prefix . "icl_translations ON element_id = ID AND element_type = 'post_$type' AND language_code = '$lang'";
}
function sitemap_per_language2($url, $type, $obj)
{

    global $sitepress;
    $lang   = $sitepress->get_current_language();
    $string = parse_url($url['loc'], PHP_URL_PATH);
    $query  = '/' . $lang . '/';
    $start  = 0;
    if ($lang === 'en') {
        $query = '/';
        $start = 3;
        if (substr($string, $start, strlen($query)) === $query) {
            return false;
        }
    } elseif (substr($string, $start, strlen($query)) !== $query) {return false;}

    return $url;
}
if (!is_admin()) {
    add_filter('woocommerce_variable_price_html', __NAMESPACE__ . '\\custom_variation_price', 10, 2);

    function custom_variation_price($price, $product)
    {
        if (!is_product()) {
            return $price;
        }

        foreach ($product->get_available_variations() as $pav) {
            $def = true;
            foreach ($product->get_variation_default_attributes() as $defkey => $defval) {

                if (isset($pav['attributes']['attribute_' . $defkey]) && $pav['attributes']['attribute_' . $defkey] != $defval) {
                    $def = false;
                }
            }
            if ($def) {
                $price = $pav['display_price'];
            }
        }

        return '<span class="woocommerce-Price-amount amount">' . woocommerce_price($price) . '</span>';

    }
}

add_filter('wc_google_analytics_pro_tracking_function_name', function ($tracker) {return 'ga';});
function ga_tracking_code($class)
{

    // bail if tracking is disabled

    // no indentation on purpose
    ?>
<!-- Start WooCommerce Google Analytics Pro -->
  <?php do_action('wc_google_analytics_pro_before_tracking_code');?>
<script>

  <?php echo $class->ga_function_name; ?>( 'create', '<?php echo esc_js($class->get_tracking_id()); ?>', 'auto' );
  <?php echo $class->ga_function_name; ?>( 'set', 'forceSSL', true );
<?php if ('yes' === $class->settings['track_user_id'] && is_user_logged_in()): ?>
  <?php echo $class->ga_function_name; ?>( 'set', 'userId', '<?php echo esc_js(get_current_user_id()) ?>' );
<?php endif;?>
<?php if ('yes' === $class->settings['anonymize_ip']): ?>
  <?php echo $class->ga_function_name; ?>( 'set', 'anonymizeIp', true );
<?php endif;?>
<?php if ('yes' === $class->settings['enable_displayfeatures']): ?>
  <?php echo $class->ga_function_name; ?>( 'require', 'displayfeatures' );
<?php endif;?>
  <?php echo $class->ga_function_name; ?>( 'require', 'ec' );
</script>
  <?php do_action('wc_google_analytics_pro_after_tracking_code');?>
<!-- end WooCommerce Google Analytics Pro -->
    <?php
}

$instance = \WPSEO_Frontend::get_instance();

remove_action('wpseo_head', array($instance, 'debug_marker'), 2);

remove_action('wp_head', array($instance, 'head'), 1);
add_action('wp_head', __NAMESPACE__ . '\\custom_yoast_head', 1);

function custom_yoast_head()
{

    global $wp_query;

    $old_wp_query = null;

    if (!$wp_query->is_main_query()) {
        $old_wp_query = $wp_query;
        wp_reset_query();
    }

    do_action('wpseo_head');

    if (!empty($old_wp_query)) {
        $GLOBALS['wp_query'] = $old_wp_query;
        unset($old_wp_query);
    }

    return;

}
remove_action('wp_head', 'rest_output_link_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links');
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
if (!empty($GLOBALS['sitepress'])) {
    add_action('wp_head', function () {
        remove_action(
            current_filter(),
            array($GLOBALS['sitepress'], 'meta_generator_tag')
        );
    },
        0
    );
}