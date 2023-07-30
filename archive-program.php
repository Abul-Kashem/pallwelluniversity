<?php get_header();

page_banner(array(
    'title' => 'All Programs',
    'subtitle' => 'There is something for everyone. Have a look around.'
));

?>



<div class="container container--narrow page-section">

    <ul class="link-list min-list">
        <?php while (have_posts()) : the_post() ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
        <?php endwhile; ?>
    </ul>

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