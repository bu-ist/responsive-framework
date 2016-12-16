<!--[if IE ]><![endif]-->
<!DOCTYPE html>
<!--[if lt IE 7]>     <html class="no-js ie lt-ie9 lt-ie8 lt-ie7"  lang="en"> <![endif]-->
<!--[if IE 7]>        <html class="no-js ie lt-ie9 lt-ie8"  lang="en"> <![endif]-->
<!--[if IE 8]>        <html class="no-js ie lt-ie9"  lang="en"> <![endif]-->
<!--[if IE 9]>        <html class="no-js ie ie9"  lang="en"> <![endif]-->
<!--[if gt IE 9]><!--><html class="no-js"  lang="en"><!--<![endif]-->
<head>
	<title><?php responsive_get_title(); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta http-equiv="ClearType" content="true" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />

	<?php if ( function_exists( 'bu_meta' ) ) : bu_meta(); else : ?><meta name="description" content="Boston University is a leading private research institution with two primary campuses in the heart of Boston and programs around the world." /><?php endif; ?>

	<?php if ( responsive_is_bu_domain() ) : ?>
		<meta name="copyright" content="&copy; <?php echo esc_attr( date( 'Y' ) ); ?> Boston University" />
	<?php else : ?>
		<link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/icons/favicon-g.ico" />
	<?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="apple-touch-icon" href="<?php bloginfo( 'template_directory' ); ?>/icons/apple-touch-icon-precomposed.png"/>

	<?php responsive_styles(); ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

	<header class="masthead" role="banner">
		<div class="masthead-container">
			<?php get_template_part( 'template-parts/header', responsive_layout() ); ?>
		</div>
	</header>

	<div class="wrapper">
		<div class="content">

			<?php responsive_content_banner( 'windowWidth' ); ?>

			<div class="content-container">
