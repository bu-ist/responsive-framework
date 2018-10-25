<?php
/**
 * Basic profile format.
 *
 * Renders individual profiles.
 *
 * @package Responsive_Framework\BU_Profiles
 */

$format = bu_profile_get_format_for_post( get_queried_object_id() );

$extra_classes = array(
	'profile-item',
	'profile-item-' . $format,
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
	<a href="<?php the_permalink(); ?>" class="profile-link profile-link-<?php echo esc_attr( $format ); ?>">
		<?php if ( function_exists( 'bu_thumbnail' ) ) : ?>
			<?php bu_thumbnail( '<figure class="profile-photo profile-photo-' . esc_attr( $format ) . '">', '</figure>', $thumb_args ); ?>
		<?php endif; ?>
		<h6 class="profile-name profile-name-<?php echo esc_attr( $format ); ?>"><?php bu_profile_detail( 'first_name' ); ?> <?php bu_profile_detail( 'last_name' ); ?></h6>
		<?php

		bu_profile_detail( 'title', array(
			'before' => '<p class="profile-title profile-title-' . esc_attr( $format ) . '">',
			'after' => '</p>',
			'format' => 'multi-line',
		) );

		?>
	</a>
</li>
