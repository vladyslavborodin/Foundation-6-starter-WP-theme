<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie ie6 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--><html class="" <?php language_attributes(); ?>><!--<![endif]-->
<!-- the "no-js" class is for Modernizr. -->

<head>

	<meta charset="<?php bloginfo('charset'); ?>">
	
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<?php if (is_search()) { ?>
		<meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title><?php wp_title(); ?></title>
	
	
	<meta name="google-site-verification" content="">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/i/favicon.ico">
	

	<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

	<?php wp_head(); ?>
	
</head>

<body <?php body_class(); ?>>

<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>


        <div class="off-canvas position-right" id="offCanvas" data-off-canvas>

            <div class="logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php bloginfo('template_directory'); ?>/i/logo.png" alt="<?php wp_title(); ?>">
                </a>
            </div>
            <!-- whatever you want goes here  -->
            <?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id' => 'mob-nav', 'menu_class' => 'mob_nav', 'theme_location' => 'top-menu' ) ); ?>

        </div>
	
		<div id="page-wrap" class="off-canvas-content" data-off-canvas-content>

			<header id="header" class="header">

                <div class="logo">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <img src="<?php bloginfo('template_directory'); ?>/i/logo.png" alt="<?php wp_title(); ?>">
                    </a>
                </div>

                <button type="button" class="menu-icon hide-for-large" data-toggle="offCanvas"></button>
				
				<?php wp_nav_menu( array( 'depth' => 6, 'sort_column' => 'menu_order', 'container' => 'ul', 'menu_id'
                => 'main-nav', 'menu_class' => 'nav show-for-large', 'theme_location' => 'top-menu' ) ); ?>
			</header>

