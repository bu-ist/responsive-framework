<?php
/**
 * Advanced profile format.
 *
 * Renders individual profiles for advanced profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

$extra_classes = array(
	'profile-item',
	'profile-item-advanced',
);

if ( bu_profile_has_detail( 'title' ) ) {
	$extra_classes[] = 'has-title';
}

$thumb_args = array(
	'maxwidth' => 150,
	'maxheight' => 150,
	'size' => 'responsive_profile',
);
?>

<li <?php post_class( $extra_classes ); ?>>
	<a href="<?php the_permalink(); ?>" class="profile-link profile-link-advanced">
		<?php if ( function_exists( 'bu_thumbnail' ) ) : ?>
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

	<?php edit_post_link( __( 'Edit Profile', 'responsive-framework' ), '', '<span class="post-edit-hint"></span>' ); ?>

</li>
