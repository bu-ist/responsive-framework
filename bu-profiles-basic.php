<?php
/**
 * Used by the BU Profile [bu_list_profiles] shortcode.
 *
 * Lists profiles as an all-text list, displaying name and title.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<?php if ( $query->have_posts() ) : ?>
	<div class="profile-listing">
		<ul class="profile-shortcode basic">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php get_template_part( 'template-parts/profile', 'basic' ); ?>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif;
