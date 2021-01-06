<?php get_header(); ?>

<div class="middle">
<main>

    <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>

    <section class="post">
      <!-- アイキャッチ画像 -->
      <figure class="thumbnail">
          <a href="<?php the_permalink(); ?>">
             <?php
              if(has_post_thumbnail()) {
                  the_post_thumbnail();
              } else {
                  echo '<img src="'.get_template_directory_uri().'/images/no-image.png" width="160" height="120"/>';
              }
           ?><!-- else部は代替画像URL-->
        </a>
      </figure>

        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="add-info">
            <span class="time"><i class="far fa-clock"></i><?php the_time( get_option( 'date_format' ) ); ?></span><span class="category"><i class="fas fa-pen"></i><?php the_category(); ?></span>
        </p>
        <P class="outline"><?php the_excerpt(); ?></P>
    </section>

    <?php endwhile; endif; ?>

    <!-- ページ送りの表示 -->
    <?php if (function_exists("pagination")) {
        pagination($additional_loop->max_num_pages);
     } ?>

</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
