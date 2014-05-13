<!DOCTYPE html>
<html>
	<head>
		<title><?php
			global $page, $paged;
			wp_title( '|', true, 'right' );
			bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
				echo " | $site_description";
			if ( $paged >= 2 || $page >= 2 )
				echo ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) );
			?>
		</title>
		
		<meta name="description" content="<?php if ( is_single() ) {
			single_post_title('', true);
			} else {
				bloginfo('name'); echo " - "; bloginfo('description');
			}
		?>" />
		
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
		<!-- Stylesheets -->



		<?php //wp_deregister_script('jquery');
		wp_head(); ?>
	</head>

	<body <?php body_class(); ?> id="top">
		<header role="banner">
			<?php
				$navArgs = array(
					'theme_location'	=> 'primary',
					'container' 		=> 'false',
					'items_wrap' 		=> '<ul>%3$s</ul>',
				);
				$navPosition = get_option("burf_navPosition");
			?>
			<?php
				if($navPosition == "top"):
			?>
				<nav role="navigation">
					<?php wp_nav_menu($navArgs); ?>
				</nav>
			<?php
				endif;
			?>
			
			<a id="siteName" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" class="logo">
				Boston University <span><?php bloginfo( 'name' ); ?></span>
			</a>
			<p class="desc"><?php bloginfo( 'description' ); ?></p>
			
			<?php
				if($navPosition == "middle" || !$navPosition):
			?>
				<nav role="navigation">
					<?php wp_nav_menu($navArgs); ?>
				</nav>
			<?php
				endif;
			?>
			
			
			<?php get_search_form(); ?>
				<?php if (function_exists('bu_content_banner')) {
				bu_content_banner($post->ID, $args = array(
					'before' => '<div class="banner-container">',
					'after' => '</div>',
					'class' => 'banner',
					//'maxwidth' => 900,
					'position' => 'page-width'
					));
			} ?>
		</header>
		<?php if (function_exists('bu_content_banner')) {
			bu_content_banner($post->ID, $args = array(
				'before' => '<div class="banner-container">',
				'after' => '</div>',
				'class' => 'banner',
				//'maxwidth' => 900,
				'position' => 'window-width'
				));
		} ?>
		<?php
				if($navPosition == "bottom"):
			?>
				<nav role="navigation">
					<?php wp_nav_menu($navArgs); ?>
				</nav>
			<?php
				endif;
			?>
		<div class="container">