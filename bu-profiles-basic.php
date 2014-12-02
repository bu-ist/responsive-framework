<?php
/* Used by the BU Profile [bu_list_profiles] shortcode
 * Lists profiles as an all-text list, displaying name and title
 */
?>

<?php if ( $query->have_posts() ): ?>
	<div class="profile-listing">
		<ul class="basic">
			<?php while ( $query->have_posts() ): ?>
				<?php $query->the_post(); ?>
				<li<?php if ( bu_profile_detail( 'title', array( 'echo' => false ) ) ): ?> class="has-title"<?php endif; ?>>
					<a href="<?php the_permalink(); ?>">
						<?php if ( function_exists( 'bu_thumbnail' ) ): $thumb_args = array( 'maxwidth' => 60, 'maxheight' => 60 ); ?>
							<?php bu_thumbnail( '<figure>', '</figure>', $thumb_args ); ?>
						<?php endif; ?>
						<p class="profile-name"><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></p>
						<?php bu_profile_detail( 'title', array( 'before' => '<p class="profile-title">', 'after' => '</p>', 'format' => 'multi-line' ) ); ?>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif; ?>
