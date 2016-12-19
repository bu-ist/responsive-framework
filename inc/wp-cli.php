<?php
/**
 * Implements custom commands for Responsive Framework.
 *
 * @package Responsive_Framework\WPCLI
 */

/**
 * Class Responsive_Framework_Command
 */
class Responsive_Framework_Command extends WP_CLI_Command {

    /**
     * Run theme migration procedures.
     *
     * ## OPTIONS
     *
     * <stylesheet>
     * : The name of stylesheet to migrate from.
     *
     * ## EXAMPLES
     *
     *     wp responsi migrate flexi
     *
     * @synopsis <stylesheet>
     */
    function migrate( $args, $assoc_args ) {
        list( $stylesheet ) = $args;

        if ( strpos( $stylesheet, 'flexi' ) !== false ) {
            require __DIR__ . '/migration-helpers.php';
            responsive_flexi_migration();
            WP_CLI::success( 'Flexi theme migration complete.' );
        } else {
            WP_CLI::error( 'Theme migration not defined from stylesheet: ' . $stylesheet );
        }
    }
}

WP_CLI::add_command( 'responsi', 'Responsive_Framework_Command' );
