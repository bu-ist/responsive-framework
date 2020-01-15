<?php
/**
 * Upgrade routines.
 *
 * @todo Prior to 1.0.0 release, add logic to the master branch (0.1.0) to ensure DB version
 *       is set so that these routines run for existing Responsi sites.
 *
 * @since 0.9.1
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

			if ( version_compare( $db_version, '2.3.1', '<' ) ) {
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

		// No version has been set. This must be the first time theme has
		// activated. Initialize default customizer options.
		responsive_upgrade_ensure_theme_options();
	}
}

add_action( 'init', 'responsive_framework_upgrade' );

/**
 * Ensures that the default options are saved in the database.
 *
 * @since 2.2.1
 */
function responsive_upgrade_ensure_theme_options() {
	// Ensure customizer options have default values saved.
	$show_on_bottom = get_option( 'burf_setting_posts_sidebar_bottom' );

	if ( empty( $show_on_bottom ) ) {
		add_option( 'burf_setting_posts_sidebar_bottom', true );
	}

	$sidebar_location = get_option( 'burf_setting_sidebar_location' );

	if ( empty( $sidebar_location ) ) {
		update_option( 'burf_setting_sidebar_location', 'right' );
	}
}

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

	$template_map = apply_filters(
		__FUNCTION__ . '_template_map',
		array(
			'calendar.php'        => 'page-templates/calendar.php',
			'news.php'            => 'page-templates/news.php',
			'page-nosidebars.php' => 'page-templates/no-sidebars.php',
			'profiles.php'        => 'page-templates/profiles.php',
		)
	);

	// Extract array keys for reuse when generating the query.
	$template_map_keys = array_keys( $template_map );

	// Prepare the query by adding a %s placeholder for each key of the passed array.
	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT post_id, meta_value FROM {$wpdb->postmeta} WHERE meta_key = '_wp_page_template' AND meta_value IN (" . substr( str_repeat( ',%s', count( $template_map_keys ) ), 1 ) . ")", // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			esc_sql( $template_map_keys )
		)
	);

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

	$banner_map = apply_filters(
		__FUNCTION__ . '_banner_map',
		array(
			'content-width' => 'contentWidth',
			'page-width'    => 'pageWidth',
			'window-width'  => 'windowWidth',
		)
	);

	$results = $wpdb->get_results( 'SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = "_bu_banner"' );

	foreach ( $results as $result ) {
		$banner = maybe_unserialize( $result->meta_value );
		if ( is_array( $banner ) ) {
			if ( array_key_exists( 'position', $banner ) && in_array( $banner['position'], array_keys( $banner_map ), true ) ) {
				$banner['position'] = $banner_map[ $banner['position'] ];
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			} elseif ( ! array_key_exists( 'position', $banner ) || empty( $banner['position'] ) ) {
				if ( $verbose ) {
					error_log( __FUNCTION__ . ' - Resetting empty banner position to default (contentWidth)' );
				}

				// Reset to default.
				$banner['position'] = 'contentWidth';
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			}
		}
	}

	// Rename sidebars.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating sidebars...' );
	}

	$sidebars_map     = apply_filters(
		__FUNCTION__ . '_sidebars_map',
		array(
			'right-content-area'  => 'sidebar',
			'bottom-content-area' => 'footbar',
		)
	);
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

	$template_map = apply_filters(
		__FUNCTION__ . '_template_map',
		array(
			'page-templates/profiles.php' => 'profiles.php',
		)
	);

	$template_map_keys = array_keys( $template_map );

	$results = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_wp_page_template' AND meta_value IN (" . substr( str_repeat( ',%s', count( $template_map_keys ) ), 1 ) . ")", // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
			$template_map_keys
		)
	);

	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Posts to migrate: ' . count( $results ) );
	}

	foreach ( $results as $result ) {
		update_post_meta( $result->post_id, '_wp_page_template', $template_map[ $result->meta_value ] );
	}

	responsive_upgrade_banner( $verbose );
	responsive_upgrade_layout( $verbose );

	// Delete the sytles cache so we can rebuild it after upgrading fonts and colors.
	responsive_flush_customizer_styles_cache();
	responsive_upgrade_fonts( $verbose );
	responsive_upgrade_colors( $verbose );

	// Recreate the styles cache.
	responsive_get_customizer_styles( false );

	// Delete unnecessary options.
	delete_option( 'burf_setting_color_scheme' );
	delete_option( 'burf_setting_active_color_regions' );
	delete_option( 'burf_setting_custom_colors' );
}

/**
 * Migrate banner information
 *
 * @param boolean $verbose Flag for outputting messages to error log.
 * @since 2.2.1
 */
function responsive_upgrade_banner( $verbose ) {
	global $wpdb;

	// Rename banner positions.
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Migrating content banners...' );
	}

	$banner_map = apply_filters(
		__FUNCTION__ . '_banner_map',
		array(
			'contentWidth' => 'content-width',
			'pageWidth'    => 'page-width',
			'windowWidth'  => 'window-width',
		)
	);

	$results = $wpdb->get_results( "SELECT post_id, meta_value FROM $wpdb->postmeta WHERE meta_key = '_bu_banner'" );

	foreach ( $results as $result ) {
		$banner = maybe_unserialize( $result->meta_value );
		if ( is_array( $banner ) ) {
			if ( array_key_exists( 'position', $banner ) && in_array( $banner['position'], array_keys( $banner_map ), true ) ) {
				$banner['position'] = $banner_map[ $banner['position'] ];
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			} elseif ( ! array_key_exists( 'position', $banner ) || empty( $banner['position'] ) ) {
				if ( $verbose ) {
					error_log( __FUNCTION__ . ' - Resetting empty banner position to default (content-width)' );
				}

				// Reset to default.
				$banner['position'] = 'content-width';
				update_post_meta( $result->post_id, '_bu_banner', $banner );
			}
		}
	}
}

/**
 * Migrate layout options.
 *
 * @param boolean $verbose Flag for outputting messages to error log.
 * @since 2.2.1
 */
function responsive_upgrade_layout( $verbose ) {
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

/**
 * Migrate font options.
 *
 * @param boolean $verbose Flag for outputting messages to error log.
 * @since 2.2.1
 */
function responsive_upgrade_fonts( $verbose ) {
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

	// If the default font is not being used,
	// check to make sure the font actually exists as an option.
	if ( 'f1' !== $new_font ) {
		if ( ! array_key_exists( $new_font, responsive_font_options() ) ) {
			$new_font = 'f1';
		}
	}

	update_option( 'burf_setting_fonts', $new_font );
}

/**
 * Migrate color options.
 *
 * @param boolean $verbose Flag for outputting messages to error log.
 * @since 2.2.1
 */
function responsive_upgrade_colors( $verbose ) {
	if ( $verbose ) {
		error_log( __FUNCTION__ . ' - Updating color scheme.' );
	}

	$old_color = get_option( 'burf_setting_color_scheme' );
	$new_color = 'default';

	if ( defined( 'BU_RESPONSIVE_COLOR_PALETTE' ) ) {
		$new_color = BU_RESPONSIVE_COLOR_PALETTE;
	} elseif ( ! empty( $old_color ) ) {
		$new_color = $old_color;
	}

	// If the default color is not being used,
	// check to make sure the color actually exists as an option.
	if ( 'default' !== $new_color ) {
		if ( ! array_key_exists( $new_color, responsive_color_options() ) ) {
			$new_color = 'default';
		}
	}

	update_option( 'burf_setting_colors', $new_color );
}
