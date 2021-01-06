<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title><?php wp_title('｜', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">

    <!--fontawesomeのCDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

    <header class="page-header">
        <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images\logo.png" alt="シナノスイートジャンキー" ></a></h1>

        <!-- グローバルメニューバー -->
        <nav>
            <?php wp_nav_menu( array(
            'theme_location'=>'mainmenu',
            'container'     =>'',
            'menu_class'    =>'',
            'items_wrap'    =>'<ul id="main-nav">%3$s</ul>'));
            ?>
        </nav>
    </header>
