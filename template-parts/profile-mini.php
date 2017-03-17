<?php
/**
 * Default content template partial.
 *
 * Used to render individual profiles for mini profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<li <?php post_class( 'profile-item' ); ?>>
	<?php if ( function_exists( 'bu_thumbnail' ) ) : $thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150 ); ?>
		<?php bu_thumbnail( '<figure class="profile-photo profile-photo-mini">', '</figure>', $thumb_args ); ?>
	<?php endif; ?>
	<div class="details">
		<?php bu_profile_detail( 'first_name', array( 'before' => '<p class="name">' ) ); ?>
		<?php bu_profile_detail( 'last_name', array( 'after' => '</p>' ) ); ?>
		<?php bu_profile_detail( 'email', array( 'format' => 'email', 'before' => '<p class="email">', 'after' => '</p>' ) ); ?>
		<?php if ( function_exists( 'bu_page_summary' ) ) : ?>
			<?php bu_page_summary( '<p class="summary">', '</p>' ); ?>
		<?php endif; ?>
	</div>
</li>
