<!DOCTYPE html>
<html lang="en">
<head>
    
    <title><?php wp_title('&raquo;', true, 'right'); ?> <?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> | Blog Archive <?php } if ( bu_flexi_is_bu_domain() ) { ?> | Boston University<?php } ?></title>
    
    <!--meta cluster-->
    <meta charset="utf-8">
    <?php if(bu_flexi_is_bu_domain()): ?><meta name="copyright" content="&copy; <?php echo date('Y'); ?> Boston University"><?php endif; ?>
    <?php if(!bu_flexi_is_bu_domain()): ?><link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon-g.ico"><?php endif; ?>
    <?php if(function_exists('bu_meta')) : bu_meta(); else : ?><meta name="description" content="Boston University is a leading private research institution with two primary campuses in the heart of Boston and programs around the world."><?php endif; ?>
    
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">
    
    <!--css-->
    <link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/css/reset.css">
    <link rel="stylesheet" media="screen" href="<?php bloginfo('stylesheet_url'); ?>">
    <link rel="stylesheet" media="print" href="<?php bloginfo('template_directory'); ?>/css/print.css">
    
    <script>
    	document.documentElement.className += 'has-js';
    </script>
    
    <?php wp_head(); ?>
    <?php do_action('bu_flexi_print_scripts'); ?>
    
    <!--[if lt IE 7]>
        <style>body {behavior: url(<?php bloginfo('template_directory'); ?>/css/csshover3.htc);}</style>
        <script src="<?php bloginfo('template_directory'); ?>/scripts/ie6pngfix.js"></script>
        <script>DD_belatedPNG.fix('img, #quicksearch, *');</script>
    <![endif]-->

</head>
<body<?php bu_flexi_body_class(); ?>>
    <div id="wrapper">
        <div id="header"<?php bu_flexi_branding_class(); ?> role="banner">
            <div class="container">
                <?php get_template_part('header-content'); ?>
            </div><!--/.container-->
        </div><!--/#header-->

        <div id="content" role="main">