<?php
/* Used by the BU Profile [bu_list_profiles] shortcode
 * Lists profiles in a 4 column thumbnail grid, displaying name and title
 */
?>

<?php if ($query->have_posts()): ?>
	<div class="profile-listing">
		<ul class="advanced">
			<?php while ($query->have_posts()): ?>
				<?php $query->the_post(); ?>
				<li<?php if (bu_profile_detail('title', array('echo' => false))): ?> class="has-title"<?php endif; ?>>
					<a href="<?php the_permalink(); ?>">
						<?php if (function_exists('bu_thumbnail')): $thumb_args = array('maxwidth' => 150, 'maxheight' => 150); ?>
							<?php bu_thumbnail('', '', $thumb_args); ?>
						<?php endif; ?>
						<span class="profile-name"><?php bu_profile_detail('first_name'); ?> <?php bu_profile_detail('last_name'); ?></span>
						<?php bu_profile_detail('title', array('before' => '<span class="profile-title">', 'after' => '</span>', 'format' => 'multi-line')); ?>
					</a>
				</li>
			<?php endwhile; ?>
		</ul>
	</div><!--/.profile-listing-->
<?php endif; ?>