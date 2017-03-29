<?php
/**
 * Basic profile format.
 *
 * Used to render individual profiles for basic profile listings.
 *
 * @package Responsive_Framework\BU_Profiles
 */

?>

<?php

$extra_classes = [ 'profile-item', 'profile-item-default' ];

if ( bu_profile_detail( 'title', array( 'echo' => false ) ) ) {
	$extra_classes[] = 'has-title';
}

?>

<li <?php post_class( $extra_classes ); ?>>
	<a href="<?php the_permalink(); ?>" class="profile-link profile-link-default">
		<?php if ( function_exists( 'bu_thumbnail' ) ) : $thumb_args = array( 'maxwidth' => 60, 'maxheight' => 60 ); ?>
			<?php bu_thumbnail( '<figure class="profile-photo profile-photo-default">', '</figure>', $thumb_args ); ?>
		<?php endif; ?>
		<p class="profile-name profile-name-default"><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></p>
		<?php

		bu_profile_detail( 'title', array(
			'before' => '<p class="profile-title profile-title-default">',
			'after' => '</p>',
			'format' => 'multi-line',
		) );

		?>
	</a>
</li>
