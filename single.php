<?php get_header(); ?>


<?php while (have_posts()) : the_post();
    page_banner();
?>


    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo site_url('/blog'); ?>"><i class="fa fa-home"></i>
                    Blog Home
                </a>

                <span class="metabox__main">

                    Posted by
                    <?php the_author_posts_link(); ?> on
                    <?php the_time('l, F j, Y'); ?> in
                    <?php echo get_the_category_list(', '); ?>

                </span>
            </p>

        </div>

        <div class="generic-content">
            <?php the_content(); ?>
        </div>
    </div>

<?php endwhile; ?>


<?php get_footer(); ?>