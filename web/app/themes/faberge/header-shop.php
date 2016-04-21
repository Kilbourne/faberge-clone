<?php
if (is_product_category() || is_product()) {
    $is_parent   = false;
    $has_chidren = false;
    $exclude     = false;
    if (is_product_category()) {
        global $wp_query;
        $cat    = $wp_query->get_queried_object();
        $cat_id = $cat->term_id;
        $parent = $cat->parent;
        if ($parent === 0) {
            $link         = get_term_link($cat);
            $value        = $cat_id;
            $title        = $cat->name;
            $is_parent    = true;
            $active  = $cat_id;
            $children     = get_term_children($cat_id, "product_cat");
            $has_children = count($children) > 0 ? true : false;
        } else {
            $link    = get_term_link($parent);
            $value   = $parent;
            $title   = get_the_category_by_ID($parent);
            $active = $parent;
            $active2  = $cat_id;
            $exclude = $parent;
        }
    } elseif (is_product()) {
        global $post;
        $terms = get_the_terms($post->ID, 'product_cat');

        foreach ($terms as $term) {
            $cat_id = $term->term_id;
            $active = $term->term_id;
            $parent = $term->parent;
            if ($parent === 0) {
                $link         = get_term_link($term);
                $value        = $term->term_id;
                $title        = $term->name;
                $is_parent    = true;
                $children     = get_term_children($cat_id, "product_cat");
                $has_children = count($children) > 0 ? true : false;
            } else {
                $link   = get_term_link($term);
                $value  = $parent;
                $title  = get_the_category_by_ID($parent);
                $active2 = $term->term_id;
                $active = $parent;
            }
        }
    }
    $subcats_child = false;
    if (!$is_parent) {
        $subcats_child = get_categories(array(

            'hierarchical'     => 1,

            'show_option_none' => '',

            'hide_empty'       => 1,

            'parent'           => $value,

            'taxonomy'         => 'product_cat',

        ));
    } else {
        if ($has_children) {
            $subcats_child = get_categories(array(

                'hierarchical'     => 1,

                'show_option_none' => '',

                'hide_empty'       => 1,

                'include'          => $children,
                'taxonomy'         => 'product_cat',

            ));
        }
    }
    $exclude = $exclude === false ? $cat_id : $exclude;
    $subcats = get_categories(array(

        'hierarchical'     => 1,

        'show_option_none' => '',

        'hide_empty'       => 1,

        'parent'           => 0,
        //'exclude'          => $exclude,
        'taxonomy'         => 'product_cat',

    ));

    echo '<div class="linea-description">';
    if ($subcats_child) {
        echo '<nav class="linea-subnav">

              <ul class="linea-subnav-list">
              <span>Collections </span>';
        foreach ($subcats_child as $key => $value2) {
            $link2 = get_term_link($value2);
            echo '<li class="linea-subnav-listelement';
            if ((is_product_category() && $parent !== 0) || is_product()) {
                //echo var_dump($value).var_dump($value2->term_id);
                if ($active2 === $value2->term_id) {echo ' active';}
            }
            echo '" ><a href="' . $link2 . '" title="">' . $value2->name . '</a></li>';
        }
        echo '</ul>
      </nav>';}
    echo '

          <nav class="linea-nav">
              <ul class="linea-nav-list">
            ';
        
    foreach ($subcats as $key => $value2) {
        $link2 = get_term_link($value2);
        echo '<li class="linea-nav-listelement';
        
            //echo var_dump($value).var_dump($value2->term_id);
            if ($active === $value2->term_id) {echo ' active linea-nav-title ';}
        
        echo '" ><a href="' . $link2 . '" title="">' . $value2->name . '</a></li>';
    }

    echo '</ul>
      </nav>';

    echo '</div>';

}
