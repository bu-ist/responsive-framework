<?php
/**
 * Advanced profile format.
 *
 * Used to render individual profiles for advanced profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<?php

$extra_classes = [ 'profile-item', 'profile-item-advanced' ];

if ( bu_profile_detail( 'title', array( 'echo' => false ) ) ) {
	$extra_classes[] = 'has-title';
}

?>

<li <?php post_class( $extra_classes ); ?>>
	<a href="<?php the_permalink(); ?>" class="profile-link profile-link-advanced">
		<?php if ( function_exists( 'bu_thumbnail' ) ) : $thumb_args = array( 'maxwidth' => 150, 'maxheight' => 150 ); ?>
			<?php bu_thumbnail( '<figure class="profile-photo profile-photo-advanced">', '</figure>', $thumb_args ); ?>
		<?php endif; ?>
		<h6 class="profile-name profile-name-advanced"><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></h6>
		<?php

		bu_profile_detail( 'title', array(
			'before' => '<p class="profile-title profile-title-advanced">',
			'after' => '</p>',
			'format' => 'multi-line',
		) );

		?>
	</a>
</li>
