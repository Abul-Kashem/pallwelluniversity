<?php get_header(); ?>


<?php while (have_posts()) : the_post() ?>


    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title">
                <?php the_title(); ?>
            </h1>
            <div class="page-banner__intro">
                <p>Keep watch our latest event notice!</p>
            </div>
        </div>
    </div>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('program'); ?>"><i class="fa fa-home"></i>
                    All Programs
                </a>

                <span class="metabox__main">
                    <?php the_title(); ?>
                </span>
            </p>

        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>

        <!-- Professor Loop -->

        <?php

        $today = date('Ymd');
        $professor_id = get_the_ID();

        $related_professor = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' =>
            array(
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $professor_id . '"',
                )
            )
        ));

        if ($related_professor->have_posts()) :

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">' . get_the_title() . ' Professors </h2>';

            echo '<ul class="professor-cards">';
            while ($related_professor->have_posts()) :
                $related_professor->the_post();

        ?>

               
                <li class="professor-card__list-item">
                    <a class="professor-card" href="<?php the_permalink(); ?>">
                        <img class="professor-card__image" src="<?php the_post_thumbnail_url('professor-landscape') ?>">
                        <span class="professor-card__name"><?php the_title(); ?></span>
                    </a>
                </li>


        <?php
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        else :
            echo '<hr class="section-break">';
        endif;
        ?>


        <!-- Upcoming Event Post Loop -->

        <?php

        $today = date('Ymd');
        $program_id = get_the_ID();

        $home_page_events = new WP_Query(array(
            'posts_per_page' => -1,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' =>
            array(
                'relation' => 'AND',
                array(
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric',
                ),
                array(
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . $program_id . '"',
                )
            )
        ));

        if ($home_page_events->have_posts()) :

            echo '<hr class="section-break">';
            echo '<h2 class="headline headline--medium">Upcomming ' . get_the_title() . ' Event </h2>';


            while ($home_page_events->have_posts()) :
                $home_page_events->the_post();

        ?>

                <div class="event-summary">
                    <a class="event-summary__date t-center" href="#">
                        <span class="event-summary__month">
                            <?php
                            $event_date = new DateTime(get_field('event_date'));
                            echo $event_date->format('M');
                            ?>
                        </span>
                        <span class="event-summary__day"><?php echo $event_date->format('d'); ?></span>
                    </a>
                    <div class="event-summary__content">
                        <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                        <p>
                            <?php
                            if (has_excerpt()) {
                                echo get_the_excerpt();
                            } else {
                                echo wp_trim_words(get_the_content(), 18);
                            }
                            ?>
                            <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a>
                        </p>
                    </div>
                </div>

        <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<hr class="section-break">';
            $site_url = site_url('/past-events');
            echo '<p>Looking for a recap of past events <a href="' . $site_url . '">Check out the past events here!</a></p>';
        endif;
        ?>



    </div>

<?php endwhile; ?>


<?php get_footer(); ?>