<?php
/**
 * Advanced profile format.
 *
 * Used to render individual profiles for advanced profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<li<?php if ( bu_profile_detail( 'title', array( 'echo' => false ) ) ) : ?> class="has-title"<?php endif; ?>>
	<a href="<?php the_permalink(); ?>">
		<?php if ( function_exists( 'bu_thumbnail' ) ) : $thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150 ); ?>
			<?php bu_thumbnail( '<figure>', '</figure>', $thumb_args ); ?>
		<?php endif; ?>
		<p class="profile-name"><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></p>
		<?php bu_profile_detail( 'title', array( 'before' => '<p class="profile-title">', 'after' => '</p>', 'format' => 'multi-line' ) ); ?>
	</a>
</li>
