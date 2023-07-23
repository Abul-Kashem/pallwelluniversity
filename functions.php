<?php

function pallwell_university_files()
{
    wp_enqueue_script('pallwell-university-js', get_theme_file_uri('js/index.js'), array('jquery'), '1.0', true);

    wp_enqueue_style('custom-google-fonts', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
    wp_enqueue_style('pallwell_main_style', get_theme_file_uri('/css/style-index.css'));
    wp_enqueue_style('pallwell_extra_style', get_theme_file_uri('/css/index.css'));
}
add_action('wp_enqueue_scripts', 'pallwell_university_files');

function pallwell_university_features()
{
    add_theme_support('title');
}
add_action('after_theme_setup', 'pallwell_university_features');