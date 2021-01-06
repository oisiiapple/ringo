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
        </article>

    <?php endwhile; endif; ?>

</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
