<?php
/**
 * Flatsome functions and definitions
 *
 * @package flatsome
 */

require get_template_directory() . '/inc/init.php';

/**
 * Note: It's not recommended to add any custom code here. Please use a child theme so that your customizations aren't lost during updates.
 * Learn more here: http://codex.wordpress.org/Child_Themes
 */

//remove featured_item
function apw_remove_custom_post_type_slug($post_link, $post, $leavename)
{

    if (!in_array($post->post_type, array('featured_item')) || 'publish' != $post->post_status)
        return $post_link;

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}

add_filter('post_type_link', 'apw_remove_custom_post_type_slug', 10, 3);

function apw_parse_request_tricksy($query)
{

    if (!$query->is_main_query())
        return;

    if (2 != count($query->query)
        || !isset($query->query['page']))
        return;

    if (!empty($query->query['name']))
        $query->set('post_type', array('post', 'featured_item', 'page'));
}

add_action('pre_get_posts', 'apw_parse_request_tricksy');

//remove featured_item_category
add_filter('request', 'apw_change_term_request', 1, 1);

function apw_change_term_request($query)
{

    $tax_name = 'featured_item_category'; // specify you taxonomy name here, it can be also 'category' or 'post_tag'

    // Request for child terms differs, we should make an additional check
    if ($query['attachment']) :
        $include_children = true;
        $name = $query['attachment'];
    else:
        $include_children = false;
        $name = $query['name'];
    endif;


    $term = get_term_by('slug', $name, $tax_name); // get the current term to make sure it exists

    if (isset($name) && $term && !is_wp_error($term)): // check it here

        if ($include_children) {
            unset($query['attachment']);
            $parent = $term->parent;
            while ($parent) {
                $parent_term = get_term($parent, $tax_name);
                $name = $parent_term->slug . '/' . $name;
                $parent = $parent_term->parent;
            }
        } else {
            unset($query['name']);
        }

        switch ($tax_name):
            case 'category':
            {
                $query['category_name'] = $name; // for categories
                break;
            }
            case 'post_tag':
            {
                $query['tag'] = $name; // for post tags
                break;
            }
            default:
            {
                $query[$tax_name] = $name; // for another taxonomies
                break;
            }
        endswitch;

    endif;

    return $query;

}


add_filter('term_link', 'apw_term_permalink', 10, 3);

function apw_term_permalink($url, $term, $taxonomy)
{

    $taxonomy_name = 'featured_item_category'; // your taxonomy name here
    $taxonomy_slug = 'featured_item_category'; // the taxonomy slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

    // exit the function if taxonomy slug is not in URL
    if (strpos($url, $taxonomy_slug) === FALSE || $taxonomy != $taxonomy_name) return $url;

    $url = str_replace('/' . $taxonomy_slug, '', $url);

    return $url;
}

function flatsome_custom_shortcode_featured_box_parallelogram()
{

    add_ux_builder_shortcode('featured_box_parallelogram',
        array(
            'type' => 'container',
            'name' => __('Icon Box Parallelogram'),
            'category' => __('Content'),
            'thumbnail' => null,
            'wrap' => false,
            'presets' => array(
                array(
                    'name' => __('Default'),
                    'content' => '[featured_box_parallelogram]<h3>Lorem ipsum dolor sit amet</h3><p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat....</p>[/featured_box_parallelogram]',
                ),
            ),
            'options' => array(
                'img' => array(
                    'type' => 'image',
                    'heading' => 'Icon',
                    'value' => '',
                ),
                'inline_svg' => array(
                    'type' => 'checkbox',
                    'heading' => 'Inline SVG',
                    'default' => 'true',
                ),
                'img_width' => array(
                    'type' => 'slider',
                    'heading' => 'Icon Width',
                    'unit' => 'px',
                    'default' => 60,
                    'max' => 600,
                    'min' => 20,
                    'on_change' => array(
                        'selector' => '.icon-box-img',
                        'style' => 'width: {{ value }}px',
                    ),
                ),
                'pos' => array(
                    'type' => 'select',
                    'heading' => 'Icon Position',
                    'default' => 'top',
                    'options' => array(
                        'top' => 'Top',
                        'center' => 'Center',
                        'left' => 'Left',
                        'right' => 'Right',
                    ),
                ),
                'title' => array(
                    'type' => 'textfield',
                    'heading' => 'Title',
                    'value' => '',
                    'on_change' => array(
                        'selector' => '.icon-box-text h5',
                        'content' => '{{ value }}',
                    ),
                ),
                'title_small' => array(
                    'type' => 'textfield',
                    'heading' => 'Title Small',
                    'value' => '',
                    'on_change' => array(
                        'selector' => '.icon-box-text h6',
                        'content' => '{{ value }}',
                    ),
                ),
                'tooltip' => array(
                    'type' => 'textfield',
                    'heading' => 'Tooltip',
                    'value' => '',
                ),
                'font_size' => array(
                    'type' => 'radio-buttons',
                    'heading' => __('Text Size'),
                    'default' => 'medium',
                    'options' => require(__DIR__ . '/inc/builder/shortcodes/values/text-sizes.php'),
                    'on_change' => array(
                        'recompile' => false,
                        'class' => 'is-{{ value }}',
                    ),
                ),
                'margin' => array(
                    'type' => 'margins',
                    'heading' => __('Margin'),
                    'value' => '',
                    'default' => '',
                    'min' => -100,
                    'max' => 100,
                    'step' => 1,
                    'on_change' => array(
                        'selector' => '.icon-box',
                        'style' => 'margin: {{ value }}',
                    ),
                ),
                'icon_border' => array(
                    'type' => 'slider',
                    'heading' => 'Icon Border',
                    'unit' => 'px',
                    'default' => 0,
                    'max' => 10,
                    'min' => 0,
                    'on_change' => array(
                        'selector' => '.has-icon-bg .icon-inner',
                        'style' => 'border-width: {{ value }}px',
                    ),
                ),
                'icon_color' => array(
                    'type' => 'colorpicker',
                    'heading' => __('Icon Color'),
                    'description' => __('Only works for simple SVG icons'),
                    'format' => 'rgb',
                    'position' => 'bottom right',
                    'on_change' => array(
                        'selector' => '.icon-inner',
                        'style' => 'color: {{ value }}',
                    ),
                ),
                'link_group' => require(__DIR__ . '/inc/builder/shortcodes/commons/links.php'),
                'advanced_options' => require(__DIR__ . '/inc/builder/shortcodes/commons/advanced.php'),
            ),
        )
    );
}

add_action('ux_builder_setup', 'flatsome_custom_shortcode_featured_box_parallelogram');


// [featured_box_parallelogram]
function featured_box_parallelogram($atts, $content = null)
{
    extract(shortcode_atts(array(
            'title' => '',
            'title_small' => '',
            'font_size' => '',
            'class' => '',
            'visibility' => '',
            'img' => '',
            'inline_svg' => 'true',
            'img_width' => '60',
            'pos' => 'top',
            'link' => '',
            'target' => '_self',
            'rel' => '',
            'tooltip' => '',
            'margin' => '',
            'icon_border' => '',
            'icon_color' => '',
        ), $atts)
    );

    if ($visibility == 'hidden') return;

    $classes = array('featured-box');
    $classes_img = array('icon-box-img');

    if ($class) $classes[] = $class;
    if ($visibility) $classes[] = $visibility;

    $classes[] = 'icon-box-' . $pos;

    if ($tooltip) $classes[] = 'tooltip';
    if ($pos == 'center') $classes[] = 'text-center';
    if ($pos == 'left' || $pos == 'top') $classes[] = 'text-left';
    if ($pos == 'right') $classes[] = 'text-right';
    if ($font_size) $classes[] = 'is-' . $font_size;
    if ($img_width) $img_width = 'width: ' . intval($img_width) . 'px';
    if ($icon_border) $classes_img[] = 'has-icon-bg';

    $css_args_out = array(
        'margin' => array(
            'attribute' => 'margin',
            'value' => $margin,
        ),
    );

    $css_args = array(
        'icon_border' => array(
            'attribute' => 'border-width',
            'unit' => 'px',
            'value' => $icon_border,
        ),
        'icon_color' => array(
            'attribute' => 'color',
            'value' => $icon_color,
        ),
    );

    $classes = implode(' ', $classes);
    $classes_img = implode(' ', $classes_img);
    $link_atts = array(
        'target' => $target,
        'rel' => array($rel),
    );

    ob_start();
    ?>

    <?php if ($link) echo '<a class="plain" href="' . $link . '"' . flatsome_parse_target_rel($link_atts) . '>'; ?>
    <div class="icon-box-container">
        <div class="parallelogram"></div>
        <div class="icon-box <?php echo $classes; ?>" <?php if ($tooltip)
            echo 'title="' . $tooltip . '"' ?> <?php echo get_shortcode_inline_css($css_args_out); ?>>
            <?php if ($img) { ?>
                <div class="<?php echo $classes_img; ?>" style="<?php if ($img_width) {
                    echo $img_width;
                } ?>">
                    <div class="icon">
                        <div class="icon-inner" <?php echo get_shortcode_inline_css($css_args); ?>>
                            <?php echo flatsome_get_image($img, $size = 'medium', $alt = $title, $inline_svg); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="icon-box-text last-reset">
                <?php if ($title) { ?><h5 class=""><?php echo $title; ?></h5><?php } ?>
                <?php if ($title_small) { ?><h6><?php echo $title_small; ?></h6><?php } ?>
                <?php echo do_shortcode($content); ?>
            </div>
        </div>
    </div>

    <?php if ($link) echo '</a>'; ?>

    <?php
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

add_shortcode('featured_box_parallelogram', 'featured_box_parallelogram');


function get_flatsome_blog_breadcrumbs()
{
    $delimiter = '<span class="divider">&#47;</span>';
    $home = 'Trang chủ';
    $before = '';
    $after = '';
    if (!is_home() && !is_front_page() || is_paged()) {
        echo '<div class="mb-half">
                <div class="flex-row medium-flex-wrap container"><div class="flex-col flex-grow medium-text-center"><div class="is-medium">';
        echo '<nav class="breadcrumbs">';
        global $post;
        $homeLink = get_bloginfo('url');
        echo '<a class="breadcrumbs-home" href="' . $homeLink . '"><svg class ="home-icon" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                     width="15.000000pt" height="15.000000pt" viewBox="0 0 512.000000 512.000000"
                                     preserveAspectRatio="xMidYMid meet">
                                    
                                    <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                    fill="#9BA2B2" stroke="none">
                                    <path d="M2487 4590 c-27 -5 -72 -20 -100 -34 -31 -16 -520 -416 -1212 -994
                                    -1222 -1019 -1188 -988 -1172 -1054 4 -13 58 -85 122 -160 96 -114 121 -138
                                    149 -144 19 -3 44 -3 55 1 11 3 517 420 1123 925 607 506 1105 920 1108 920 3
                                    0 501 -414 1108 -920 606 -505 1112 -922 1123 -925 11 -4 36 -4 55 -1 28 6 53
                                    30 149 144 64 75 118 147 122 160 15 62 3 74 -367 382 l-355 296 -5 672 -5
                                    672 -28 27 -27 28 -323 3 c-210 2 -335 0 -358 -7 -68 -20 -68 -22 -71 -386
                                    l-3 -327 -408 340 c-437 365 -450 374 -572 385 -33 3 -82 2 -108 -3z"/>
                                    <path d="M1642 3018 l-912 -752 0 -780 c0 -537 4 -794 11 -821 15 -55 83 -119
                                    142 -133 32 -9 228 -12 656 -12 l611 0 0 610 0 610 410 0 410 0 0 -610 0 -610
                                    611 0 c407 0 625 4 653 11 56 14 114 62 137 113 18 39 19 84 19 832 l0 790
                                    -909 749 c-499 412 -912 750 -917 752 -5 2 -420 -335 -922 -749z"/>
                                    </g>
                                    </svg></a> ' . $delimiter . ' ';
        if (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
            echo $before . single_cat_title('', false) . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
                echo $before . get_the_title() . $after;
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo $before . get_the_title() . $after;
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif (is_page() && !$post->post_parent) {
            echo $before . get_the_title() . $after;
        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
            echo $before . get_the_title() . $after;
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }
        echo '</nav>';
        echo '</div></div></div></div>';
    }
}

add_action('flatsome_before_blog', 'get_flatsome_blog_breadcrumbs', 20);

add_shortcode('flatsome_related_posts', 'flatsome_related_posts');
function flatsome_related_posts()
{
    ob_start();
    $categories = get_the_category(get_the_ID());
    if ($categories) {
        echo '';
        $category_ids = array();
        foreach ($categories as $individual_category) array_push($category_ids, $individual_category->term_id);
        $my_query = new wp_query(array('category__in' => $category_ids, 'post__not_in' => array(get_the_ID()), 'posts_per_page' => 12, 'orderby' => 'rand'));
        $ids = wp_list_pluck($my_query->posts, 'ID');
        $ids = implode(',', $ids);
        if ($my_query->have_posts()) {
            echo '<hr/><h4 class="uppercase">' . esc_html__('Tin liên quan', 'flatsome') . '</h4>';
            echo do_shortcode('[blog_posts style="normal" type="row" columns="3" columns__sm="1" columns__md="2" posts="12" orderby="rand" show_date="false" excerpt="false" comments="false" image_height="56.25%" ids="' . $ids . '"]');
        }
        echo '';
    }
    return ob_get_clean();
}