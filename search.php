<?php get_header(); ?>
<?php get_template_part('after-header'); ?>

<div class="container">
    <?php get_template_part('main-container'); ?>
    <?php get_sidebar('left'); ?>
    <div<?php bu_flexi_main_id(); ?> class="main">
        <div class="container">
            <h2>Search Results:</h2>
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="content-panel post" id="post-<?php the_ID(); ?>">
                <h3><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                <?php the_excerpt(); ?>
                <p><a href="<?php the_permalink();?>">Read the Rest...</a></p>
            </div><!--/.post-->
            <?php endwhile; else: ?>
            <p>No results were found for <strong><?php the_search_query(); ?></strong> in this site.</p>
            <?php endif; ?>
            <p class="navigation" role="navigation">
                <span class="next"><?php next_posts_link('Next') ?></span> 
                <span class="previous"><?php previous_posts_link('Last') ?></span>
            </p><!--/.navigation-->
        </div><!--/.container-->
    </div><!--/.main-->
    <?php get_sidebar('right'); ?>
</div><!--/.container-->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>