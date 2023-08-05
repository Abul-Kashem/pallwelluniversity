<?php

function pallwell_university_files()
{
    // wp_enqueue_script('pallwell-university-js', get_theme_file_uri('js/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_script('pallwell-university-js', get_theme_file_uri('/build/index.js'), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('pallwell_main_style', get_theme_file_uri('/css/style-index.css'));
    wp_enqueue_style('pallwell_extra_style', get_theme_file_uri('/css/index.css'));
}
add_action('wp_enqueue_scripts', 'pallwell_university_files');

function pallwell_university_features()
{
    add_theme_support('title');
    register_nav_menu('header_menu_location', 'Header Menu Location');
    register_nav_menu('footer_one_location', 'Footer One Location');
    register_nav_menu('footer_two_location', 'Footer Two Location');

    // register_nav_menus(array(
    //     'primary-menu'   => esc_html__('Primary Menu', 'pallwell'),
    //     'secondary-menu' => esc_html__('Secondary Menu', 'pallwell'),
    //     // Add more menu locations here if needed
    // ));

    add_theme_support('post-thumbnails');
    add_image_size('professor-landscape', 400, 260, true);
    add_image_size('professor-portrait', 480, 650, true);
    add_image_size('page-banner', 1500, 350, true);
}
add_action('after_setup_theme', 'pallwell_university_features');

// Custom pagination function
function custom_paginate_links($output)
{
    // Replace the default HTML classes with custom classes
    $output = str_replace('page-numbers', 'custom-pagination', $output);
    $output = str_replace('prev', 'custom-pagination-prev', $output);
    $output = str_replace('next', 'custom-pagination-next', $output);
    return $output;
}
add_filter('paginate_links', 'custom_paginate_links');


function pallwell_university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $query->set('orderby', 'title');
        $query->set('order', 'ASC');
        $query->set('posts_per_page', -1);
    }


    // Only modify the main query on the frontend for 'event' post type archive
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
        // Get the current date in the format 'Ymd' (e.g., '20230726')
        $today = date('Ymd');

        // Modify the main query parameters
        $meta_query = array(
            'key' => 'event_date',
            'value' => $today,
            'compare' => '>=',
            'type' => 'numeric'
        );

        $query->set('meta_query', array($meta_query));
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
    }
}
// Hook the function into the 'pre_get_posts' action
add_action('pre_get_posts', 'pallwell_university_adjust_queries');


function page_banner($args = NULL)
{

    if (!isset($args['title'])) {
        $args['title'] = get_the_title();
    }

    if (!isset($args['subtitle'])) {
        $args['subtitle'] = get_field('page_banner_subtitle');
    }

    if (!isset($args['photo'])) {
        if (get_field('page_banner_background_image')) {
            $args['photo'] = get_field('page_banner_background_image')['sizes']['page-banner'];
        } else {
            $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
        }
    }

?>
    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $args['title'] ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $args['subtitle']; ?></p>
            </div>
        </div>
    </div>
<?php

}
