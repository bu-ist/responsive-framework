<?php
/**
 * Used by the BU Profile [bu_list_profiles] shortcode.
 *
 * Lists profiles in a 4 column thumbnail grid, displaying name and title.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<?php if ( $query->have_posts() ) : ?>
	<div class="profile-shortcode profile-listing">
		<ul class="mini">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php get_template_part( 'template-parts/profile', 'mini' ); ?>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif;
