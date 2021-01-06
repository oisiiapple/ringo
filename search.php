<?php get_header(); ?>

<div class="middle">
<main>
   <!-- パンくずリスト表示 -->
    <?php breadcrumb(); ?>
    <?php
        global $wp_query;
        $total_results = $wp_query->found_posts;
        $search_query = get_search_query();
    ?>

    <!-- 検索結果の見出し -->
    <h1 class="search">「<?php echo $search_query; ?>」の検索結果<span>（<?php echo $total_results; ?>件）</span></h1>

    <?php
        if( $total_results >0 ):
        if(have_posts()):
        while(have_posts()): the_post();
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
            <span class="padding"><i class="far fa-clock"></i><?php the_time( get_option( 'date_format' ) ); ?></span><i class="fas fa-pen"></i><?php the_category(); ?>
        </p>
        <P class="outline"><?php the_excerpt(); ?></P>
    </section>

    <?php endwhile; endif; else: ?>

    <?php echo $search_query; ?> に一致する情報は見つかりませんでした。

    <?php endif; ?>

    <!-- ページ送りの表示 -->
    <?php if (function_exists("pagination")) {
        pagination($additional_loop->max_num_pages);
     } ?>

</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
