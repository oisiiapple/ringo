<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'id' => 'sidebar-1',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '<h2 class="widget_title">',
        'after_title' => '</h2>',
    ));

// カスタムメニュー対応
register_nav_menu('mainmenu', 'メインメニュー');

//検索フォーム
add_filter('wp_nav_menu_items','add_search_box', 10, 2);
function add_search_box($items, $args) {
 ob_start();
 get_search_form();
 $searchform = ob_get_contents();
 ob_end_clean();
  $items .= '<li>' . $searchform . '</li>';
 return $items;
}

// コメント欄で悪質なリンクを貼れなくなる
function my_comment_tag_disable($data) {
	global $allowedtags;
	$allowedtags = array();
	return $data;
}
add_filter('preprocess_comment', 'my_comment_tag_disable');
remove_filter('comment_text', 'make_clickable', 9);

// パンくずリスト
function breadcrumb() {
    $home = '<li class="breadcrumb"><a href="'.get_bloginfo('url').'" >HOME</a></li>';

    echo '<ul class="breadcrumb">';
    if ( is_front_page() ) {
        // トップページの場合
    }
    else if ( is_category() ) {
        // カテゴリページの場合
        $cat = get_queried_object();
        $cat_id = $cat->parent;
        $cat_list = array();
        while ($cat_id != 0){
            $cat = get_category( $cat_id );
            $cat_link = get_category_link( $cat_id );
            array_unshift( $cat_list, '<li class="breadcrumb"><a href="'.$cat_link.'">'.$cat->name.'</a></li>' );
            $cat_id = $cat->parent;
        }
        echo $home;
        foreach($cat_list as $value){
            echo $value;
        }
        the_archive_title('<li class="breadcrumb">', '</li>');
    }
    else if ( is_archive() ) {
    // 月別アーカイブ・タグページの場合
    echo $home;
    the_archive_title('<li class="breadcrumb">', '</li>');
    }
    else if ( is_single() ) {
    // 投稿ページの場合
    $cat = get_the_category();
        if( isset($cat[0]->cat_ID) ) $cat_id = $cat[0]->cat_ID;
        $cat_list = array();
        while ($cat_id != 0){
            $cat = get_category( $cat_id );
            $cat_link = get_category_link( $cat_id );
            array_unshift( $cat_list, '<li class="breadcrumb"><a href="'.$cat_link.'">'.$cat->name.'</a></li>' );
            $cat_id = $cat->parent;
        }
        foreach($cat_list as $value){
            echo $value;
        }
        the_title('<li class="breadcrumb">', '</li>');
    }
    else if( is_page() ) {
    // 固定ページの場合
    echo $home;
    the_title('<li class="breadcrumb">', '</li>');
    }
    else if( is_search() ) {
    // 検索ページの場合
    echo $home;
    echo '<li class="breadcrumb">「'.get_search_query().'」の検索結果</li>';
    }
    else if( is_404() ) {
    // 404ページの場合
    echo $home;
    echo '<li class="breadcrumb">ページが見つかりません</li>';
    }
    echo "</ul>";
}

// アーカイブの余計なタイトルを削除
add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_month() ) {
        $title = single_month_title( '', false );
    }
    return $title;
});

// 記事一覧のページ送り
function pagination($pages = '', $range = 1)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><div class=\"pagination-box\"><span class=\"page-of\">Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div></div>\n";
     }
}

// 記事一覧の文末の[…]を別の文字に変更し、記事へのリンクを追加
function my_get_the_excerpt( $post_excerpt, $post ) {
    $more = sprintf( '<a class="more-link" href="%1$s">%2$s</a>',
        get_permalink( $post->ID ),
        __( '続きを読む', 'textdomain' )
    );
    return $post_excerpt . $more;
}
add_filter( 'get_the_excerpt', 'my_get_the_excerpt', 10, 2 );

// アイキャッチ画像の機能を有効化、その画像サイズを指定
add_theme_support('post-thumbnails');
set_post_thumbnail_size(160, 120, true);

// TOPへ戻るボタンのためjquery読み込み
function load_jquery(){
    wp_enqueue_script('jquery');
}
add_action('init', 'load_jquery');

// TOPへ戻るボタンのJavaScript読み込み
function scroll_top() {
    wp_enqueue_script('scrollscript', get_template_directory_uri().'/scroll-top.js', array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'scroll_top');
