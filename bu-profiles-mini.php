<?php
/* Used by the BU Profile [bu_list_profiles] shortcode
 * Lists profiles in a 4 column thumbnail grid, displaying name and title
 */
?>
<?php if ( $query->have_posts() ): ?>
	<div class="profile-listing">
		<ul class="mini">
			<?php while ( $query->have_posts() ): ?>
				<?php $query->the_post(); ?>
				<li>
					<div class="thumb_container">
						<?php if ( function_exists( 'bu_thumbnail' ) ): $thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150 ); ?>
							<?php bu_thumbnail( '', '', $thumb_args ); ?>
						<?php endif; ?>
					</div>
					<div class="content_container">
						<?php bu_profile_detail( 'first_name', array( 'before' => '<span class="profile-name">' ) ); ?>
						<?php bu_profile_detail( 'last_name', array( 'after' => '</span>' ) ); ?>
						<?php bu_profile_detail( 'email', array( 'format' => 'email', 'before' => '<span class="email_container">', 'after' => '</span>' ) ); ?>
						<div class="content_summary">
							<?php bu_profile_detail( '_bu_page_description', array( 'before' => '<p>', 'after' => '</p>', 'format' => 'multi-line' ) ); ?>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif; ?>
