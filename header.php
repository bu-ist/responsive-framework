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
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
	<meta http-equiv="ClearType" content="true" />

	<?php if ( responsive_is_bu_domain() ): ?><meta name="copyright" content="&copy; <?php echo date( 'Y' ); ?> Boston University" /><?php endif; ?>
	<?php if ( ! responsive_is_bu_domain() ): ?><link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/favicon-g.ico" /><?php endif; ?>
	<?php if ( function_exists( 'bu_meta' ) ) : bu_meta(); else : ?><meta name="description" content="<?php responsive_get_description(); ?>" /><?php endif; ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo( 'template_directory' ); ?>/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo bloginfo( 'template_directory' ); ?>/apple-touch-icon-precomposed.png"/>

	<?php responsive_styles(); ?>

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">

	<header class="masthead" role="banner">
		<?php get_template_part( 'template-parts/header', responsive_layout() ); ?>
	</header>

	<div class="wrapper">
		<div class="content">

			<?php responsive_content_banner( 'windowWidth' ); ?>

			<div class="content-container">
