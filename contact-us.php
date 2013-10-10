<?php
/*
Template Name: Contact Us
*/
?>
<?php get_header(); ?>
<?php get_template_part('after-header'); ?>
<div class="container">
	<?php get_template_part('main-container'); ?>
	<?php get_sidebar('left'); ?>
	<div<?php bu_flexi_main_id(); ?> class="main">
		<div class="container">
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if (function_exists('bu_content_banner')) {
					bu_content_banner($post->ID, $args = array(
						'before' => '<div class="banner-container">',
						'after' => '</div>',
						'class' => 'banner',
						'maxwidth' => BU_FLEXI_CONTENT_IMAGE_WIDTH,
						'position' => 'content-width'
						));
				} ?>
			<div class="content-panel" id="post-<?php the_ID(); ?>">
				<?php edit_post_link('Edit', '<p class="edit-link">', '</p>'); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content('<p>Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
	
			<?php if (bu_has_contact_addresses()) :?>
	
			<div class="buforms buforms_left">
				<form class="contactForm" method="post" action="<?php bu_contact_form_action();?>">
				<fieldset>
				<input type="hidden" name="form_location" value="/cms/telegraph/flexi/" />
				<input type="hidden" name="form_configuration" value="config.contact-us.xml" />
				<input type="hidden" name="to" value="<?php bu_contact_addresses(); ?>" />
				<input type="hidden" name="subject" value="Contact Form Submission - <?php bloginfo("name"); ?>" />
				<input type="hidden" name="theme" value="<?php echo get_option("stylesheet"); ?>" />
				<input type="hidden" name="siteurl" value="<?php echo get_option("siteurl"); ?>" />
				
				<div>
				<label for="first_name">First Name <span class="required">*</span></label>
				<input name="first_name" type="text" id="first_name" tabindex="1" />
				</div>
				
				<div>
				<label for="last_name">Last Name <span class="required">*</span></label>
				<input type="text" name="last_name" id="last_name" tabindex="2" />
				</div>
				
				<div>
				<label for="email">Email <span class="required">*</span></label>
				<input type="text" name="email" id="email" class="medium" tabindex="3" />
				</div>
				
				<div>
				<label>You Are <span class="required">*</span></label>
					<fieldset class="radio">
					<input type="radio" name="affiliation" value="Student" id="Student" tabindex="4" />
					<label for="Student"> Student</label>
					<input type="radio" name="affiliation" value="Faculty" id="Faculty" tabindex="5" />
					<label for="Faculty"> Faculty</label>
					<input type="radio" name="affiliation" value="Staff" id="Staff" tabindex="6" />
					<label for="Staff"> Staff</label>
					<input type="radio" name="affiliation" value="Alumnus" id="Alumnus" tabindex="7" />
					<label for="Alumnus"> Alumnus/a</label>
					<input type="radio" name="affiliation" value="Other" id="Other" tabindex="8" />
					<label for="Other"> Other</label>
					</fieldset>
				</div>
				
				<div>
				<label for="comments">Message <span class="required">*</span></label>
				<textarea name="comments" id="comments" class="textarea medium" tabindex="9"  rows="10" cols="50"></textarea>
				</div>
				
				<div class="buforms_footer">
				<input type="submit" class="button" name="submit" value="Submit" tabindex="10"/>
				</div>
				
				</fieldset>
				</form>
			</div><!-- /.buforms -->
	
			<?php else :?>
			This department is not set up to be contacted from the web.
			<?php endif ;?>

	    <?php endwhile; endif; ?>
		</div><!-- /.container -->
	</div><!--  /.main -->
	<?php get_sidebar('right'); ?>
</div><!-- /.container -->
<?php get_sidebar('footbar'); ?>

<?php get_footer(); ?>
