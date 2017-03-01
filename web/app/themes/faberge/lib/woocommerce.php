<?php

/**
 * Remove Hooks
 */

// Remove Woocommerce BreadCumbs
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

// Remove Product Data Tabs
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10, 0);

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

/**
 * Archive Description
 *
 * Replace Hooks
 *
 */

remove_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10);
add_action('woocommerce_archive_description', 'woocommerce_taxonomy_archive_description2', 20);

function woocommerce_taxonomy_archive_description2()
{
    if (is_tax(array('product_cat', 'product_tag')) && 0 === absint(get_query_var('paged'))) {
        $description = term_description();
        $title       = single_term_title('', false);
        if ($description) {
            echo '<div class="term-description"><h3 class="term-description-title">' . $title . '</h3>' . $description . '</div>';
        }
    }
}

function category_has_children($cat_id)
{
    $children = get_term_children($cat_id, "product_cat");
    return count($children) > 0 ? true : false;
}
function category_has_parent($cat)
{

    return $cat->parent ? true : false;
}

function get_category_attachment_url($cat_id)
{
    $thumbnail_id = get_woocommerce_term_meta($cat_id, 'thumbnail_id', true);
    return wp_get_attachment_url($thumbnail_id);
}
remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail', 10);
add_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail1');

function woocommerce_subcategory_thumbnail1($category)
{
    $small_thumbnail_size = apply_filters('subcategory_archive_thumbnail_size', 'shop_catalog');
    $dimensions           = wc_get_image_size($small_thumbnail_size);
    $obj_id               = icl_object_id($category->term_id, 'product_cat', false, 'en');
    $thumbnail_id         = get_field('seconda_immagine', 'product_cat_' . $obj_id);
    $image                = false;

    if (!$thumbnail_id) {
        $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
    }

    if ($thumbnail_id) {
        $image = wp_get_attachment_image_src($thumbnail_id, $small_thumbnail_size);
        $image = $image[0];
    }

    if ($image) {
        // Prevent esc_url from breaking spaces in urls for image embeds
        // Ref: https://core.trac.wordpress.org/ticket/23605
        $image = str_replace(' ', '%20', $image);

        echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($category->name) . '" width="' . esc_attr($dimensions['width']) . '" height="' . esc_attr($dimensions['height']) . '" />';
    }
}
function get_category_single_product_content($cat_id)
{
    global $post;
    $posts = get_posts(
        array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'terms'    => $cat_id,
                ),
            ),
        )
    );
    $post = $posts[0];
    setup_postdata($post);
    enqueue_category_single_product_scripts();
    wc_get_template_part('content', 'single-product');
    wp_reset_postdata();
}

function enqueue_category_single_product_scripts()
{
    $suffix      = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';
    $lightbox_en = 'yes' === get_option('woocommerce_enable_lightbox');

    $assets_path          = str_replace(array('http:', 'https:'), '', WC()->plugin_url()) . '/assets/';
    $frontend_script_path = $assets_path . 'js/frontend/';
    if ($lightbox_en) {
        wp_enqueue_script('prettyPhoto', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array('jquery'), '3.1.6', true);
        wp_enqueue_script('prettyPhoto-init', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array('jquery', 'prettyPhoto'));
        wp_enqueue_style('woocommerce_prettyPhoto_css', $assets_path . 'css/prettyPhoto.css');
    }

    wp_enqueue_script('wc-single-product');
}

/**
 *
 *  Single Product Summary
 *
 */

add_action('woocommerce_single_product_summary', 'woocommerce_pre_single_product_summary', 1, 2);

function woocommerce_pre_single_product_summary()
{
    echo '<div class="title-and-cart"><div class="single-product-title-wrapper">';
};

add_action('woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_title', 10, 2);

function woocommerce_after_single_product_summary_title()
{
    echo '</div></div>';
}

add_action('woocommerce_single_product_summary', 'woocommerce_before_single_product_summary_cart', 29, 2);

function woocommerce_before_single_product_summary_cart()
{
    echo '<div class="single-product-cart-wrapper">';
}
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10, 0);

//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25,2 );
remove_action('woocommerce_before_single_product_summary','woocommerce_show_product_sale_flash',10);
add_action('woocommerce_single_product_summary', 'woocommerce_before_single_product_price_single_add_to_cart', 24, 2);

function woocommerce_before_single_product_price_single_add_to_cart()
{
    global $product;
    if( $product->is_type( 'variable' ) ){
    echo '<div class="buy-section"><div class="accordion-title-wrap">
          <a href="#buy-wrapper" aria-expanded="false" aria-controls="buy-wrapper" ><i class="wpmenucart-icon-shopping-cart-0"></i>' . __('Buy Information', 'sage') . '</a></div><div id="buy-wrapper"  >';
      }else{
        remove_action('woocommerce_single_product_summary', 'woocommerce_before_single_product_summary_cart', 29, 2);
        remove_action('woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_single_add_to_cart', 31, 2);
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
      }

};
add_action('woocommerce_single_product_summary', 'woocommerce_after_single_product_summary_single_add_to_cart', 31, 2);

function woocommerce_after_single_product_summary_single_add_to_cart()
{
    echo '</div></div></div>';
};

add_action('woocommerce_single_product_summary', 'attributes_woocommerce_single_product_summary', 11, 2);

function attributes_woocommerce_single_product_summary()
{
    global $product;
    $product->list_attributes();
};

//remove_action( 'woocommerce_single_variation','woocommerce_single_variation', 10, 0);

remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40, 0);

add_filter('woocommerce_attribute', 'attribute_size_image', 10, 3);

function attribute_size_image($wpautop, $attribute, $values)
{
    $display = $wpautop;
    if ($attribute['name'] == "pa_measure") {
        global $product;
        $product_cats = wp_get_post_terms($product->id, 'product_cat');
        $right_cat    = false;

        foreach ($product_cats as $key1 => $cat) {
            $original_cat_id = apply_filters('wpml_object_id', $cat->term_id, 'product_cat', false, 'en');
            $original_cat    = get_term($original_cat_id, 'product_cat');
            $parent_slug     = $original_cat->parent ? get_term($original_cat->parent)->slug : '';
            if ($original_cat->slug === 'tf-9' || $original_cat->slug === 'eggs' || $parent_slug === 'eggs') {
                $right_cat = true;
            }

        }
        if ($right_cat) {
            foreach ($values as $key => $value) {

                $val     = ((intval($value) * 46) / 28);
                $display = '';
                $display .= '<div class="size-wrap" >' . wp_get_attachment_image(2620, 'thumb', false, array("style" => "width:" . $val . "px;")) . '<div >
        <p>' . $value . '</p>
      </div></div>';

            }
        }
    } elseif ($attribute['name'] == "pa_color") {

        global $product;
        $value = is_array($values) ? $values[0] : false;
        $term  = wc_get_product_terms($product->id, "pa_color", array('fields' => 'all'))[0];

        $color_value = get_field('colori', $term) ? get_field('colori', $term) : get_woocommerce_term_meta($term->term_id, 'pa_color_yith_wccl_value');

        $display = '';
        $display .= '<div class="select_box_colorpicker select_box attribute_pa_color"><div data-value="' . $value . '" class="select_option_colorpicker select_option"><span style="background-color:' . $color_value . ' ;" class="yith_wccl_value"></span></div></div>';
    }

    return $display;

}

/**
 *
 * Related Products
 *
 */

add_filter("woocommerce_get_related_product_cat_terms", 'filter_woocommerce_get_related_term_terms', 40, 2);

function filter_woocommerce_get_related_term_terms($wp_get_post_terms)
{
    foreach ($wp_get_post_terms as $key => $value) {
        $children = get_categories(array('taxonomy' => 'product_cat', 'parent' => $value->term_id));
        if (count($children) == 0) {$arr[] = $value;}
    }
    return $arr;
};

add_filter('woocommerce_product_related_posts_relate_by_tag', function () {return false;});

/**
 *
 * Variations Thumbnails
 *
 */

function faberge_woocommerce_single_product_variations()
{
    global $product;
    if ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        $variation_data       = $product->get_variation_attributes();
        $results              = array();
        if (is_array($variation_data)) {
            $default    = strtolower($product->get_variation_default_attribute("pa_color"));
            $used_color = array();
            $display    = "";
            $count      = count($available_variations);
            $slider     = '';
            $x          = 0;
            if ($count > 6) {
                $slider .= '<div id="slider-variation">
    <div class="swiper-wrapper">';
            }

            foreach ($available_variations as $key => $variation) {
                $var_id = $variation["variation_id"];
                if (has_post_thumbnail($var_id)) {
                    $variation_obj      = $product->get_child($var_id);
                    $value              = $variation_obj->get_sku();
                    $price              = $variation_obj->get_price();
                    $gallery_image_link = false;
                    if ($variation_data['pa_color'] && count($variation_data['pa_color']) > 1) {
                        // !
                        $color = $variation['attributes']["attribute_pa_color"];
                        if (!in_array($color, $used_color)) {
                            $x++;
                            $active = $default == $color ? true : false;
                            $image  = $variation_obj->get_image('thumbnail');

                            $original_id = apply_filters('wpml_object_id', $var_id, 'product', false, 'en');

                            $image_ids = get_post_meta($original_id, '_wc_additional_variation_images');

                            $gallery_image_link = wp_get_attachment_url($image_ids[0]);
                            $display .= '<div id="var-' . $var_id . '"class="variation';
                            if ($count > 6) {$display .= ' swiper-slide ';}
                            if ($active) {$display .= ' default ';}
                            $display .= ' " data-color="' . $color . '" >' . $image . '</div>';
                            $used_color[]     = $color;
                            $results[$var_id] = array("image" => $variation_obj->get_image('full'), "value" => $value, "variation_image" => $gallery_image_link, "price" => $price, "attributes" => $variation['attributes']);
                        }
                    }

                }

            }
            $slider2 = '';
            if ($count > 6) {
                $slider2 .= '</div>
    <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

    <!-- If we need navigation buttons -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>


</div>';
            }

            if ($x > 0) {
                $display = $slider . $display . $slider2;
            }

            echo '<div class="variations-thumbs">' . $display . '</div>';
            if (count($results) > 0) {
                echo '<script> productVariation=' . json_encode($results) . ';</script>';
            }

        }
    }
}

/**
 *
 * Ajax Product Detail
 *
 */

function faberge_get_product_detail()
{
    $product_id = $_POST['product_id'];
    $args       = array(
        'post_type' => 'product',
        'p'         => $product_id,
    );
    global $wp_query;
    $wp_query = new WP_Query($args);
    $product  = new WC_Product($product_id);

    if (!wp_script_is('wc-add-to-cart-variation') && $product->is_type('variable')) {wp_enqueue_script('wc-add-to-cart-variation');}

    if ($wp_query->have_posts()):
        while ($wp_query->have_posts()): $wp_query->the_post();
            wc_get_template_part('content', 'single-product');
            $attr = YITH_WCCL_Frontend()->create_attributes_json(false, true);
            echo '<script class="yith_wccl ">var yith_wccl =' . json_encode(array(
                'attributes' => json_encode($attr),
            )) . '</script>';

        endwhile;
    else:
        wp_send_json_error("There were no posts found");
    endif;
    wp_reset_query();
    //faberge_woocommerce_single_product_variations(FALSE);
    wp_die();
}

add_action('wp_ajax_get_product_detail', __NAMESPACE__ . '\\faberge_get_product_detail');
add_action('wp_ajax_nopriv_get_product_detail', __NAMESPACE__ . '\\faberge_get_product_detail');

//add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );
function woocommerce_header_add_to_cart_fragment($fragments)
{
    ob_start();
    ?>
  <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart');?>"><?php echo sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count()), WC()->cart->get_cart_contents_count()); ?> - <?php echo WC()->cart->get_cart_total(); ?></a>
  <?php

    $fragments['a.cart-contents'] = ob_get_clean();

    return $fragments;
}
add_filter('woocommerce_stock_html', function () {return '';});

add_action('woocommerce_before_add_to_cart_button', 'woocommerce_before_add_to_cart_button_faberge');
function woocommerce_before_add_to_cart_button_faberge()
{
    global $product;
    $notes = get_the_terms($product->id, 'pa_note');

    if (is_array($notes)) {
        echo '<p class="product-notes">' . $notes[0]->name . '</p>';
    }

}

add_action('init', 'register_attributes_url_meta');
function register_attributes_url_meta()
{
    $attributes = wc_get_attribute_taxonomies();

    foreach ($attributes as $tax) {
        $name = wc_attribute_taxonomy_name($tax->attribute_name);

        add_action($name . '_add_form_fields', 'add_attribute_url_meta_field');
        add_action($name . '_edit_form_fields', 'edit_attribute_url_meta_field', 10);
        add_action('edit_' . $name, 'save_attribute_url');
        add_action('create_' . $name, 'save_attribute_url');
    }
}

/**
 * Add term fields form
 */
function add_attribute_url_meta_field()
{

    wp_nonce_field(basename(__FILE__), 'attrbute_url_meta_nonce');
    ?>

    <div class="form-field">
        <label for="attribute_url"><?php _e('URL', 'domain');?></label>
        <input type="url" name="attribute_url" id="attribute_url" value="" />
    </div>
    <?php
}
/**
 * Edit term fields form
 */
function edit_attribute_url_meta_field($term)
{
    $url = get_term_meta($term->term_id, 'attribute_url', true);
    wp_nonce_field(basename(__FILE__), 'attrbute_url_meta_nonce');
    ?>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="attribute_url"><?php _e('URL', 'domain');?></label></th>
        <td>
            <input type="url" name="attribute_url" id="attribute_url" value="<?php echo esc_url($url); ?>" />
        </td>
    </tr>
    <?php
}
/**
 * Save term fields
 */
function save_attribute_url($term_id)
{
    if (!isset($_POST['attribute_url']) || !wp_verify_nonce($_POST['attrbute_url_meta_nonce'], basename(__FILE__))) {
        return;
    }
    $old_url = get_term_meta($term_id, 'attribute_url', true);
    $new_url = esc_url($_POST['attribute_url']);
    if (!empty($old_url) && $new_url === '') {
        delete_term_meta($term_id, 'attribute_url');
    } else if ($old_url !== $new_url) {
        update_term_meta($term_id, 'attribute_url', $new_url, $old_url);
    }
}

add_action('pre_get_posts', 'mp_design_cat_posts_per_page');
function mp_design_cat_posts_per_page($query)
{
    if (is_category()) {
        $query->set('posts_per_page', '-1');
    }
}

add_filter('woocommerce_product_subcategories_hide_empty', 'so_28060317', 10, 1);
function so_28060317($show_empty)
{
    $show_empty = true;

    return $show_empty;
}
remove_filter('post_class', 'wc_product_post_class', '20');
add_filter('post_class', __NAMESPACE__ . 'fab_product_post_class', '20', 3);
function fab_product_post_class($classes, $class = '', $post_id = '')
{
    if (!$post_id || 'product' !== get_post_type($post_id)) {
        return $classes;
    }

    $product = wc_get_product($post_id);

    if ($product) {
        $classes[] = wc_get_loop_class();

        if ($product->get_type()) {
            $classes[] = "product-type-" . $product->get_type();
        }
        if ($product->is_type('variable')) {
            if ($product->has_default_attributes()) {
                $classes[] = 'has-default-attributes';
            }
            if ($product->has_child()) {
                $classes[] = 'has-children';
            }
        }
    }

    if (false !== ($key = array_search('hentry', $classes))) {
        unset($classes[$key]);
    }

    return $classes;
}
