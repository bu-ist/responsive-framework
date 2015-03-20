<?php
/* Used by the BU Profile [bu_list_profiles] shortcode
 * Lists profiles as an all-text list, displaying name and title
 */
?>

<?php if ( $query->have_posts() ): ?>
	<div class="profile-listing">
		<ul class="basic">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php get_template_part( 'template-parts/content', 'profiles' ); ?>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif; ?>
