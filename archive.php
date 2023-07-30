<?php get_header();

page_banner(array(
  'title' => get_the_archive_title(),
  'subtitle' => get_the_archive_description()
));
?>


<div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
    <div class="page-banner__content container container--narrow">
        <h1 class="page-banner__title"><?php the_archive_title(); ?></h1>
        <div class="page-banner__intro">
            <?php the_archive_description(); ?>
        </div>
    </div>
</div>

<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post() ?>

        <div class="post-item">
            <h2 class="headline headline--medium headline--post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

            <div class="metabox">
                <p>Posted by <?php the_author_posts_link(); ?> on <?php the_time('l, F j, Y'); ?> in <?php echo get_the_category_list(', '); ?></p>
            </div>

            <div class="generic-content">
                <?php the_excerpt(); ?>
                <p><a href="<?php the_permalink(); ?>">Continue Reading &raquo;</a></p>
            </div>
        </div>

    <?php endwhile; ?>


    <!-- <?php echo paginate_links(); ?> -->

    <div class="container">
        <!-- Your Loop Content Here -->

        <!-- Pagination -->
        <div class="custom-pagination-wrapper">
            <?php
            $pagination_args = array(
                'prev_text' => '&laquo; Previous',
                'next_text' => 'Next &raquo;',
            );
            echo paginate_links($pagination_args);
            ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>