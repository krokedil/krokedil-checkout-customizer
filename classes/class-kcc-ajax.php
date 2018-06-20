<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Krokedil_Checkout_Customizer_AJAX class.
 *
 * Registers AJAX actions for Krokedil Checkout Customizer.
 *
 * @extends WC_AJAX
 */
class Krokedil_Checkout_Customizer_AJAX extends WC_AJAX {

	/**
	 * Hook in ajax handlers.
	 */
	public static function init() {
		self::add_ajax_events();
	}

	/**
	 * Hook in methods - uses WordPress ajax handlers (admin-ajax).
	 */
	public static function add_ajax_events() {
		$ajax_events = array(
			'kcc_wc_update_cart'		=> true,
		);

		foreach ( $ajax_events as $ajax_event => $nopriv ) {
			add_action( 'wp_ajax_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			if ( $nopriv ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $ajax_event, array( __CLASS__, $ajax_event ) );
				// WC AJAX can be used for frontend ajax requests.
				add_action( 'wc_ajax_' . $ajax_event, array( __CLASS__, $ajax_event ) );
			}
		}
	}

	/**
	 * Cart quantity update function.
	 */
	public static function kcc_wc_update_cart() {
		if ( ! wp_verify_nonce( $_POST['nonce'], 'kcc_nonce' ) ) {
			wp_send_json_error( 'bad_nonce' );
			exit;
		}

		$values = array();
		parse_str( $_POST['checkout'], $values );
		$cart = $values['cart'];

		foreach ( $cart as $cart_key => $cart_value ) {
			$new_quantity = (int) $cart_value['qty'];
			WC()->cart->set_quantity( $cart_key, $new_quantity, false );
		}

		WC()->cart->calculate_shipping();
		WC()->cart->calculate_fees();
		WC()->cart->calculate_totals();
		wp_send_json_success( 'cart updated' );

		wp_die();
	}

}

Krokedil_Checkout_Customizer_AJAX::init();