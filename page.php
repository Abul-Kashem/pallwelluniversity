<?php
get_header();

if (have_posts()) : ?>
  <?php while (have_posts()) :
    the_post();
    page_banner();
  ?>



    <div class="container container--narrow page-section">


      <?php
      $parent_id = wp_get_post_parent_id(get_the_ID());
      if ($parent_id) :
      ?>

        <div class="metabox metabox--position-up metabox--with-home-link">
          <p>
            <a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parent_id); ?></a> <span class="metabox__main"><?php the_title(); ?></span>
          </p>
        </div>

      <?php endif; ?>

      <?php
      $child_pages = get_pages(array(
        'child_of' => get_the_ID()
      ));

      if ($parent_id or $child_pages) :
      ?>
        <div class="page-links">
          <h2 class="page-links__title"><a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a></h2>
          <ul class="min-list">
            <?php
            if ($parent_id) {
              $findChildrenOf = $parent_id;
            } else {
              $findChildrenOf = get_the_ID();
            }

            wp_list_pages(array(
              'title_li' => NULL,
              'child_of' => $findChildrenOf,
              'sort_column' => 'menu_order'
            ));
            ?>
          </ul>
        </div>
      <?php endif; ?>


      <div class="generic-content">
        <?php the_content(); ?>
      </div>
    </div>


  <?php endwhile; ?>


<?php
endif;
get_footer();

?>