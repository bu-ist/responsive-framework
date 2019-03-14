<?php

/**
 * Upgrade routines.
 *
 * @todo Prior to 1.0.0 release, add logic to the master branch (0.1.0) to ensure DB version
 *       is set so that these routines run for existing Responsi sites.
 *
 * @since  0.9.1
 *
 * @package Responsive_Framework\Upgrade
 */

/**
 * Stores current theme version in database.
 *
 * Allows us to run code when the framework is updated.
 *
 * @param bool $verbose Whether to display notices in error log.
 */
function responsive_framework_upgrade( $verbose = true ) {
	$db_version = get_option( '_responsive_framework_version', false );

	// Old theme version detected.
	if ( $db_version ) {
		if ( version_compare( $db_version, RESPONSIVE_FRAMEWORK_VERSION, '<' ) ) {
			if ( $verbose ) {
				error_log( __FUNCTION__ . ' - Version mismatch detected. Starting upgrade...' );
			}

			// Run version-specific upgrade routine(s).
			if ( version_compare( $db_version, '0.9.1', '<' ) ) {
				responsive_upgrade_091( $verbose );
			}

			if ( version_compare( $db_version, '2.0.0', '<' ) ) {
				responsive_upgrade_2_0( $verbose );
			}

			/**
			 * Fires immediately after upgrade routines have run.
			 *
			 * @param string Database version before upgrade.
			 * @param string New theme version.
			 *
			 * @since 1.2.0
			 */
			do_action( 'responsive_framework_upgrade', $db_version, RESPONSIVE_FRAMEWORK_VERSION );

			if ( $verbose ) {
				error_log( __FUNCTION__ . ' - Updating framework version in DB: ' . $db_version . ' -> ' . RESPONSIVE_FRAMEWORK_VERSION );
			}

			update_option( '_responsive_framework_version', RESPONSIVE_FRAMEWORK_VERSION );
		}
	} else {
		// No version was previously set -- add it now.
		if ( $verbose ) {
			error_log( __FUNCTION__ . ' - Adding framework version to DB: ' . RESPONSIVE_FRAMEWORK_VERSION );
		}

		add_option( '_responsive_framework_version', RESPONSIVE_FRAMEWORK_VERSION );
	}
}

add_action( 'init', 'responsive_framework_upgrade' );

/**
 * Upgrade for 0.9.1.
 *
 * - Page template renaming
 * - Banner position renaming
 * - Sidebar renaming
 *
 * @param bool $verbose Whether to display notices in error log.
 */
function responsive_upgrade_091( $verbose = true ) {
	global $wpdb;

	// Rename page templates.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating page templates...' );
	}

	$template_map = apply_filters( __FUNCTION__ . '_template_map', array(
		'calendar.php' => 'page-templates/calendar.php',
		'news.php' => 'page-templates/news.php',
		'page-nosidebars.php' => 'page-templates/no-sidebars.php',
		'profiles.php' => 'page-templates/profiles.php',
		) );

	$template_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_wp_page_template" AND meta_value IN ("%s")',
		$wpdb->postmeta, implode( '","', array_keys( $template_map ) )
	);
	$results = $wpdb->get_results( $template_query );

	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Posts to migrate: ' . count( $results ) );
	}

	foreach ( $results as $result ) {
		update_post_meta( $result->post_id, '_wp_page_template', $template_map[ $result->meta_value ] );
	}

	// Rename banner positions.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating content banners...' );
	}

	$banner_map = apply_filters( __FUNCTION__ . '_banner_map', array(
		'content-width' => 'contentWidth',
		'page-width' => 'pageWidth',
		'window-width' => 'windowWidth',
		) );

	$banner_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_bu_banner"',
		$wpdb->postmeta
	);
	$results = $wpdb->get_results( $banner_query );

	foreach ( $results as $result ) {
		$banner = maybe_unserialize( $result->meta_value );
		if ( is_array( $banner ) ) {
			if ( array_key_exists( 'position', $banner ) && in_array( $banner[ 'position' ], array_keys( $banner_map ) ) ) {
				$banner[ 'position' ] = $banner_map[ $banner[ 'position' ] ];
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			} elseif ( ! array_key_exists( 'position', $banner ) || empty( $banner[ 'position' ] ) ) {
				if ( $verbose ) {
					error_log( __FUNCTION__ . ' - Resetting empty banner position to default (contentWidth)' );
				}

				// Reset to default.
				$banner[ 'position' ] = 'contentWidth';
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			}
		}
	}

	// Rename sidebars.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating sidebars...' );
	}

	$sidebars_map = apply_filters( __FUNCTION__ . '_sidebars_map', array(
		'right-content-area' => 'sidebar',
		'bottom-content-area' => 'footbar',
		) );
	$sidebars_widgets = wp_get_sidebars_widgets();
	foreach ( $sidebars_map as $from => $to ) {
		if ( array_key_exists( $from, $sidebars_widgets ) ) {
			$sidebars_widgets[ $to ] = $sidebars_widgets[ $from ];
			unset( $sidebars_widgets[ $from ] );
		}
	}
	wp_set_sidebars_widgets( $sidebars_widgets );
}

/**
 * Upgrade routines for Responsive Framework 2.0.0.
 *
 * - Content banner names have been updated to match coding standards.
 * - Layout names have been updated to match coding standards.
 * - Ensure a layout option is saved to the database.
 *
 * @param bool $verbose Whether to display notices in error log.
 */
function responsive_upgrade_2_0( $verbose = true ) {
	global $wpdb;

	// Rename page templates.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating page templates...' );
	}

	$template_map = apply_filters( __FUNCTION__ . '_template_map', array(
		'page-templates/profiles.php' => 'profiles.php',
		) );

	$template_query = sprintf( 'SELECT post_id, meta_value FROM %s WHERE meta_key = "_wp_page_template" AND meta_value IN ("%s")',
		$wpdb->postmeta, implode( '","', array_keys( $template_map ) )
	);
	$results = $wpdb->get_results( $template_query );

	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Posts to migrate: ' . count( $results ) );
	}

	foreach ( $results as $result ) {
		update_post_meta( $result->post_id, '_wp_page_template', $template_map[ $result->meta_value ] );
	}

	upgrade_banner( $verbose );
	upgrade_layout( $verbose );
	upgrade_fonts( $verbose );
}

function upgrade_banner( $verbose ) {
	// Rename banner positions.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating content banners...' );
	}

	$banner_map = apply_filters( __FUNCTION__ . '_banner_map', array(
		'contentWidth' => 'content-width',
		'pageWidth' => 'page-width',
		'windowWidth' => 'window-width',
		) );

	$results = $wpdb->get_results( $wpdb->prepare( "SELECT post_id, meta_value FROM $wpdb -> postmeta WHERE meta_key = '_bu_banner'",
			$wpdb->postmeta
		) );

	foreach ( $results as $result ) {
		$banner = maybe_unserialize( $result->meta_value );
		if ( is_array( $banner ) ) {
			if ( array_key_exists( 'position', $banner ) && in_array( $banner[ 'position' ], array_keys( $banner_map ) ) ) {
				$banner[ 'position' ] = $banner_map[ $banner[ 'position' ] ];
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			} elseif ( ! array_key_exists( 'position', $banner ) || empty( $banner[ 'position' ] ) ) {
				if ( $verbose ) {
					error_log( __FUNCTION__ . ' - Resetting empty banner position to default (content-width)' );
				}

				// Reset to default.
				$banner[ 'position' ] = 'content-width';
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			}
		}
	}
}

function upgrade_layout( $verbose ) {
	// Upgrade layout names and ensure a value is saved to the option in the database.
	$names = array(
		'sideNav' => 'side-nav',
		'topNav'  => 'top-nav',
		'noNav'   => 'no-nav',
	);

	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Updating layout name.' );
	}

	$old_layout = get_option( 'burf_setting_layout' );
	$new_layout = 'default';

	if ( defined( 'BU_RESPONSIVE_LAYOUT' ) ) {
		$new_layout = BU_RESPONSIVE_LAYOUT;
	} elseif ( ! empty( $old_layout ) ) {
		$new_layout = $old_layout;
	}

	if ( 'default' !== $new_layout ) {
		if ( isset( $names[ $old_layout ] ) ) {
			$new_layout = $names[ $old_layout ];
		} elseif ( ! array_key_exists( $new_layout, responsive_layout_options() ) ) {
			$new_layout = 'default';
		}
	}

	if ( $new_layout !== $old_layout ) {
		update_option( 'burf_setting_layout', $new_layout );
	}
}

function upgrade_fonts( $verbose ) {
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Updating font.' );
	}

	$old_font = get_option( 'burf_setting_fonts' );
	$new_font = 'f1';

	if ( defined( 'BU_RESPONSIVE_FONT_PALETTE' ) ) {
		$new_font = BU_RESPONSIVE_FONT_PALETTE;
	} elseif ( ! empty( $old_font ) ) {
		$new_font = $old_font;
	}

	if ( 'f1' !== $new_font ) {
		if ( ! array_key_exists( $new_font, responsive_font_options() ) ) {
			$new_font = 'f1';
		}
	}

	if ( $new_font !== $old_font ) {
		update_option( 'burf_setting_fonts', $new_font );
	}
}

function upgrade_colors( $verbose ) {
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Updating font.' );
	}

	$old_color = get_option( 'burf_setting_color_scheme' );
	$new_color = 'default';

	if ( defined( 'BU_RESPONSIVE_COLOR_PALETTE' ) ) {
		$new_color = BU_RESPONSIVE_COLOR_PALETTE;
	} elseif ( ! empty( $old_color ) ) {
		$new_color = $old_color;
	}

	if ( 'default' !== $new_color ) {
		if ( ! array_key_exists( $new_color, responsive_color_options() ) ) {
			$new_color = 'default';
		}
	}

	if ( $new_color !== $old_color ) {
		update_option( 'burf_setting_colors', $new_color );
	}
}

/**
 * TODO: Flush all the shit.
 * Rebuild burf_customizer_styles
 * Kill:
 *		burf_setting_color_scheme
 *		burf_setting_active_color_region
 *		burf_setting_custom_colors
 */
