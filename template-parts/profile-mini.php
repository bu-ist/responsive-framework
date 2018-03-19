<?php
/**
 * Default content template partial.
 *
 * Used to render individual profiles for mini profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<li <?php post_class( 'profile-item profile-item-mini' ); ?>>
	<?php if ( function_exists( 'bu_thumbnail' ) ) : $thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150, 'size' => 'responsive_profile', ); ?>
		<?php bu_thumbnail( '<figure class="profile-photo profile-photo-mini">', '</figure>', $thumb_args ); ?>
	<?php endif; ?>
	<div class="profile-details profile-details-mini">
		<?php

		bu_profile_detail( 'first_name', array(
			'before' => '<h6 class="profile-name profile-name-mini">',
			'after' => ' ',
		) );

		bu_profile_detail( 'last_name', array(
			'after' => '</h6>',
		) );

		bu_profile_detail( 'email', array(
			'format' => 'email',
			'before' => '<p class="profile-email profile-email-mini">',
			'after' => '</p>',
		) );

		?>
		<?php if ( function_exists( 'bu_page_summary' ) ) : ?>
			<?php bu_page_summary( '<p class="profile-summary profile-summary-mini">', '</p>' ); ?>
		<?php endif; ?>
	</div>
</li>
