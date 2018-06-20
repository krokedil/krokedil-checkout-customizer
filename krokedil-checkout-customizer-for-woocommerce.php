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

define( 'KCC_VERSION', '0.1.0' );


/**
 * Class Krokedil_Checkout_Customizer
 */
class Krokedil_Checkout_Customizer {
	/**
	 * Krokedil_Checkout_Optimizer constructor.
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Initiates the plugin.
	 */
	public function init_plugin() {
		include_once 'classes/class-kcc-order-lines.php';
		include_once 'classes/class-kcc-ajax.php';
	}

	/**
	 * Enqueue scripts.
	 */
	public function load_scripts() {
		if ( is_checkout() ) {
			wp_register_script( 
				'krokedil_checkout_customizer', 
				plugins_url( '/assets/js/krokedil-checkout-customizer.js', 
				__FILE__ ), 
				array( 'jquery' ), 
				KCC_VERSION 
			);

			wp_register_style( 
				'krokedil_checkout_customizer', 
				plugins_url( '/assets/css/krokedil-checkout-customizer.css', 
				__FILE__ ), 
				array(), 
				KCC_VERSION 
			);
			
			wp_localize_script( 'krokedil_checkout_customizer', 'kcc_params', array(
				'checkout_nonce'			=> wp_create_nonce( 'kcc_nonce' ),
				'update_cart_url'			=> WC_AJAX::get_endpoint( 'kcc_wc_update_cart' ),
			) );

			wp_enqueue_script( 'krokedil_checkout_customizer' );
			wp_enqueue_style( 'krokedil_checkout_customizer' );
		}
	}
}
new Krokedil_Checkout_Customizer();