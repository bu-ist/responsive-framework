<!--[if IE ]><![endif]-->
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js ie lt-ie9 lt-ie8 lt-ie7"  lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js ie lt-ie9 lt-ie8"  lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js ie lt-ie9"  lang="en"> <![endif]-->
<!--[if IE 9]>         <html class="no-js ie ie9"  lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js"  lang="en"> <!--<![endif]-->
	<head>
		<title><?php responsive_get_title(); ?></title>
		
		<meta name="description" content="<?php responsive_get_description(); ?>" />
		
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="initial-scale=1" />
		<meta http-equiv="ClearType" content="true" />


		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico">
		<link rel="apple-touch-icon" href="<?php echo bloginfo('template_directory'); ?>/apple-touch-icon-precomposed.png"/>


		<!-- Stylesheets -->
		<link rel="stylesheet" type="text/css" href="//cloud.typography.com/6127692/660644/css/fonts.css" />
		<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

		<!--[if (lt IE 9)&(!IEMobile 7) ]>
			<link rel='stylesheet' type='text/css' href="<?php echo get_template_directory_uri(); ?>/ie.css?&ver=0.1" />
		<![endif]-->
		<!-- Stylesheets -->
		
		
		<?php wp_head(); ?>
		
	</head>

	<body <?php body_class(); ?> id="top">
		<header role="banner">
			<?php
				$navArgs = array(
					'theme_location'	=> 'primary',
					'container' 		=> 'false',
					'items_wrap' 		=> '<ul>%3$s</ul>',
				);
				$utilArgas = array(
					'theme_location'	=> 'utility',
					'container' 		=> 'false',
					'items_wrap' 		=> '<ul>%3$s</ul>',
				);
				
				
				$headerLayout = get_option("burf_setting_layout");
			?>
			
			<?php
				if($headerLayout == "l-navbar"):
				?>
					<nav class="mainNav" role="navigation">
						<div class="navToggle"><?php include("images/menu.svg"); ?></div>
						<div class="searchToggle"><?php include("images/search.svg"); ?></div>
						<?php wp_nav_menu($navArgs); ?>
					</nav>
					<?php get_search_form(); ?>
				<?php
				endif;
			?>
			
			<div id="brand">
				<a id="siteName" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo">
					Boston University <span><?php bloginfo( 'name' ); ?></span>
				</a>
				
				<p class="desc"><?php bloginfo( 'description' ); ?></p>
				<?php if($headerLayout == "l-navbar" || $headerLayout == "l-branding"): ?>
					<nav id="utility" role="utility"><?php wp_nav_menu($utilArgs); ?></nav>
				<?php endif; ?>
				<div class="searchToggle"><?php include("images/search.svg"); ?></div>
				<?php if($headerLayout == "l-nonav"): ?>
					<?php get_search_form(); ?>
				<?php endif; ?>
				
			</div>
			
			<?php
				if($headerLayout == "l-branding"):
			?>
				<nav class="mainNav" role="navigation">
					<div class="navToggle"><?php include("images/menu.svg"); ?></div>
					<div class="searchToggle"><?php include("images/search.svg"); ?></div>
					<?php wp_nav_menu($navArgs); ?>
				</nav>
				<?php get_search_form(); ?>
			<?php
				endif;
			?>
			
			
			<?php
				if($headerLayout == "l-sidenav"):
			?>
				<nav class="mainNav" role="navigation">
					<div class="navToggle"><?php include("images/menu.svg"); ?></div>
					<div class="searchToggle"><?php include("images/search.svg"); ?></div>
					<?php
                    if (function_exists('bu_navigation_display_primary')) {
                    	//see https://github.com/bu-ist/bu-navigation/wiki/Adding-Theme-Support-for-Primary-Navigation-Menus
                        $defaults = array(
                            'container_id' => 'pnm', // HTML ID attribute of menu container
                            'container_class' => 'nav nav-primary-list' // HTML class attributes for menu container
                            
                        );
                        bu_navigation_display_primary($defaults);
                    }
                    ?>
					
					<nav id="utility" role="utility"><?php wp_nav_menu($utilArgs); ?></nav>
					
				</nav>
				 
				<?php get_search_form(); ?>
			<?php
				endif;
			?>
			
			
		</header>
		<?php if (function_exists('bu_content_banner')) {
			echo(do_shortcode(bu_content_banner($post->ID, $args = array(
				'before' => '<div class="banner-container window-width">',
				'after' => '</div>',
				'class' => 'banner',
				//'maxwidth' => 900,
				'position' => 'window-width',
				'echo' => false
				))));
		} ?>

		<div class="container">