<?php
/**
 * Used by the BU Profiles page template and BU Profiles shortcodes which do not
 * specify any format.
 *
 * Lists profiles
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<?php if ( $query->have_posts() ) : ?>
	<ul class="profile-listing profile-format-default">
		<?php while ( $query->have_posts() ) : $query->the_post(); ?>
			<?php get_template_part( 'template-parts/profile' ); ?>
		<?php endwhile; ?>
	</ul>
<?php endif;