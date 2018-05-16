<?php
/**
 * Krokedil Checkout Customizer for WooCommerce
 *
 * @package WC_Krokedil
 *
 * @wordpress-plugin
 * Plugin Name:     Krokedil Checkout Customizer for WooCommerce
 * Plugin URI:      https://krokedil.se/
 * Description:     Adds functionality to the WooCommerce checkout page
 * Version:         0.1.0
 * Author:          Krokedil
 * Author URI:      https://kokedil.com
 * Text Domain:     krokedil-checkout-customizer
 * Domain Path:     /languages
 * WC requires at least: 3.3.0.
 * WC tested up to: 3.3.5
 * Copyright:       © 2010-2018 Krokedil.
 * License:         GNU General Public License v3.0
 * License URI:     http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Krokedil_Checkout_Customizer
 */
class Krokedil_Checkout_Customizer {
	/**
	 * Krokedil_Checkout_Optimizer constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
	}

	/**
	 * Initiates the plugin.
	 */
	public function init_plugin() {
		include_once 'classes/class-kcc-order-lines.php';
	}
}
new Krokedil_Checkout_Customizer();