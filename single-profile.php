<?php /* Single "Profile" Custom Post Type */

get_header();
get_template_part('after-header'); ?>

<div class="container">
	<div class="bg">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div class="main">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $has_details = bu_profile_has_details(); ?>
			<div class="content-panel profile-display<?php if($has_details): ?> has-basic<?php endif; ?><?php if($profile_thumb):?> has-thumb<?php endif; ?>">
            	<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>

				<h1><?php bu_profile_detail('first_name'); ?> <?php bu_profile_detail('last_name'); ?></h1>

				<?php if(function_exists('bu_thumbnail')): $thumb_args = array('maxwidth' => 150, 'maxheight' => 150 );?>
				<?php bu_thumbnail( '<div class="profile-thumb">', '</div>', $thumb_args ); ?>
			    	<?php endif; ?>

			    <?php if($has_details): ?>
			    <div class="profile-info">
				<dl>
				<?php bu_profile_detail('title', array( 'before' => '<dt>Title</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' ) ); ?>
				<?php bu_profile_detail('office', array( 'before' => '<dt>Office</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' )); ?>
				<?php bu_profile_detail('email', array( 'before' => '<dt>Email</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'email')); ?>
				<?php bu_profile_detail('phone', array( 'before' => '<dt>Phone</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID() )); ?>
				<?php bu_profile_detail('education', array('before' => '<dt>Education</dt><dd>', 'after' => '</dd>', 'post_id' => get_the_ID(), 'format' => 'multi-line' ) ); ?>
				</dl>
			    </div><!--/.profile-info-->
			    <?php endif; ?>
                    
					<?php if( get_the_content() !== '' ): ?>
                        <div class="profile-bio">
                            <?php the_content(); ?>
                        </div><!--/.profile-bio-->
					<?php endif; ?>

					<?php the_taxonomies( array( 'before' => '<div class="profile-tax"><dl>', 'sep' => '', 'after' => '</dl></div><!--/.profiles-tax-->', 'template' => '<dt>%s</dt><dd>%l</dd>' ) ); ?>
                    
        		</div><!-- /.content-panel -->
			<?php endwhile; endif; ?>
		<?php get_template_part('after-content'); ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
	</div><!-- /.bg -->
</div><!-- /.container -->

<?php
    get_sidebar('footbar');
    get_footer();
?>

