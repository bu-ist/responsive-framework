<!DOCTYPE html>
<html lang="en">
<head>
    <!--meta cluster-->
    <meta charset="utf-8">
    <?php if(bu_flexi_is_bu_domain()): ?><meta name="copyright" content="&copy; <?php echo date('Y'); ?> Boston University"><?php endif; ?>
    <?php if(!bu_flexi_is_bu_domain()): ?><link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon-g.ico"><?php endif; ?>
    <?php if(function_exists('bu_meta')) : bu_meta(); else : ?><meta name="description" content="Boston University is a leading private research institution with two primary campuses in the heart of Boston and programs around the world."><?php endif; ?>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">
 	<link rel="shortcut icon" href="common/ico/favicon.png">
    <title><?php wp_title('&raquo;', true, 'right'); ?> <?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> | Blog Archive <?php } if ( bu_flexi_is_bu_domain() ) { ?> | Boston University<?php } ?></title>
    <!--css-->
    <link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/css/reset.css">
    <link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.css">
    
    <script>
    	document.documentElement.className += 'has-js';
    </script>
    
    <?php wp_head(); ?>
    <?php do_action('bu_flexi_print_scripts'); ?>
    
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="js/html5shiv.js"></script>
	  <script src="js/respond.min.js"></script>
	<![endif]--> 

</head>
<body<?php bu_flexi_body_class(); ?>>
        <header<?php bu_flexi_branding_class(); ?> role="banner">
                <?php get_template_part('header-content'); ?>
        </header>

        <section id="content" role="main">