<?php get_header(); ?>

<div class="middle">
<main>
   <!-- パンくずリスト表示 -->
   <?php breadcrumb(); ?>
   <?php
    if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>

        <article class="content">
            <h2><?php the_title(); ?></h2>
            <hr>
            <?php the_content(); ?>

            <p class="add-info">
                <span class="padding"><i class="far fa-clock"></i><?php the_time( get_option( 'date_format' ) ); ?></span><i class="fas fa-pen"></i><?php the_category(); ?><span class="tag-icon"><?php the_tags( '<i class="fa fa-tags"></i>', ',' ); ?></span>
            </p>
        </article>



        <?php comments_template(); ?>

    <?php endwhile; endif; ?>

<!-- 投稿記事用ページ送り -->
   <div class="navigation clearfix">
      <p class="navileft">
         <?php previous_post_link('« %link', '%title', TRUE, ''); ?>
      </p>
      <p class="navitop">
         │<a href="<?php echo home_url(); ?>">HOME</a>│
      </p>
      <p class="naviright">
         <?php next_post_link('%link »', '%title', TRUE, ''); ?>
      </p>
   </div>

</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
