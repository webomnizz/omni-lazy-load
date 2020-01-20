<?php

/**
 * @link              https://webomnizz.com
 * @since             1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       Omni Lazy Load
 * Plugin URI:        https://webomnizz.com/wordpress-plugins/omni-lazy-load-image/
 * Description:       WordPress lazy loader for Images and IFrames to boost your website performance.
 * Version:           1.0.0
 * Author:            Jogesh
 * Author URI:        https://webomnizz.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       omni_lazyload
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version
 */
define( 'OMNI_LAZYLOAD_VERSION', '1.0.0' );
define( 'OMNI_LAZYLOAD_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require plugin_dir_path( __FILE__ ) . 'includes/class-omni-lazyload.php';

omni_lazyload();