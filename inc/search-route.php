<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', array(
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ));
}

function universitySearchResults($data)
{
    $main_query = new WP_Query(array(
        'post_type' => array('post', 'page', 'professor', 'program', 'event'),
        's' => sanitize_text_field($data['term'])

    ));


    $results = array(
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array()
    );

    while ($main_query->have_posts()) {
        $main_query->the_post();

        if (get_post_type() == 'post' or get_post_type() == 'page') {
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'post_type' => get_post_type(),
                'author_name' => get_the_author()
            ));
        }


        if (get_post_type() == 'professor') {
            array_push($results['professors'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'image' => get_the_post_thumbnail_url(0, 'professor-landscape')
            ));
        }

        if (get_post_type() == 'program') {
            array_push($results['programs'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }

        if (get_post_type() == 'event') {

            $event_date = new DateTime(get_field('event_date'));
            $description = null;
            if (has_excerpt()) {
                $description = get_the_excerpt();
            } else {
                $description = wp_trim_words(get_the_content(), 18);
            }

            array_push($results['events'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink(),
                'month' => $event_date->format('M'),
                'day' => $event_date->format('d'),
                'description' => $description
            ));
        }

        if ($results['programs']) {
            $programs_meta_query = array('relation' => 'OR');

            foreach ($results['programs'] as $program) {
                array_push($programs_meta_query, array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $program['id'] . '"'
                ));
            }

            $program_relationship_query = new WP_Query(array(
                'post_type' => array('professor', 'event'),
                'meta_query' => $programs_meta_query
            ));

            while ($program_relationship_query->have_posts()) {
                $program_relationship_query->the_post();

                if (get_post_type() == 'event') {

                    $event_date = new DateTime(get_field('event_date'));
                    $description = null;
                    if (has_excerpt()) {
                        $description = get_the_excerpt();
                    } else {
                        $description = wp_trim_words(get_the_content(), 18);
                    }

                    array_push($results['events'], array(
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'month' => $event_date->format('M'),
                        'day' => $event_date->format('d'),
                        'description' => $description
                    ));
                }


                if (get_post_type() == 'professor') {
                    array_push($results['professors'], array(
                        'title' => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'image' => get_the_post_thumbnail_url(0, 'professor-landscape')
                    ));
                }
            }
        }
    }
    return $results;
}
