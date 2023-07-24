<?php get_header(); ?>


<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('/images/ocean.jpg') ?>);"></div>
  <div class="page-banner__content container container--narrow">
    <h1 class="page-banner__title">Welcome to our blog!</h1>
    <div class="page-banner__intro">
      <p>Keep watch our latest article</p>
    </div>
  </div>
</div>

<?php while (have_posts()) : the_post() ?>

  <div class="container container--narrow page-section">
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
  </div>

<?php endwhile; ?>









<!-- 
<div class="container container--narrow page-section">
    <div class="post-item">
        <h2 class="headline headline--medium headline--post-title"><a href="">Blog Title</a></h2>

        <div class="metabox">
            <p>Posted by Abul Kashem on 12 Jul 2023 in Blog Category</p>
        </div>

        <div class="generic-content">
            <p><a href="">Continue Reading &raquo;</a></p>
        </div>
    </div>
</div> -->

<?php get_footer(); ?>