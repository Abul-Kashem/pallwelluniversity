<?php get_header();

page_banner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on in our world.',
    'photo' => '',
));

?>



<div class="container container--narrow page-section">

    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part('template-parts/content-event'); ?>

    <?php endwhile; ?>

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
    <hr class="section-break">
    <p>Looking for a recap of past events <a href="<?php echo site_url('/past-events') ?>">Check out the past events here!</a></p>
</div>

<?php get_footer(); ?>