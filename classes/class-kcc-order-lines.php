<?php
/**
 * Krokedil_Checkout_Customizer_Order_Lines class.
 *
 * Class that handles editing of order lines (quantity & delete) in checkout.
 */
class Krokedil_Checkout_Customizer_Order_Lines {
	/**
	 * The reference the *Singleton* instance of this class.
	 *
	 * @var $instance
	 */
	protected static $instance;
	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return self::$instance The *Singleton* instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Krokedil_Checkout_Customizer_Order_Lines constructor.
	 */
	protected function __construct() {
		add_filter( 'woocommerce_checkout_cart_item_quantity', array( $this, 'add_quantity_field' ), 10, 3 );
	}
	

	public function add_quantity_field( $output, $cart_item, $cart_item_key ) {
		if ( 'kco' === WC()->session->get( 'chosen_payment_method' ) ) {
			foreach ( WC()->cart->get_cart() as $cart_key => $cart_value ) {
				if ( $cart_key === $cart_item_key ) {

					$product_id = $cart_item['product_id'];
					$_product   = $cart_item['data'] ;
					$return_value = sprintf(
					  '<a href="%s" class="remove" title="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
					  esc_url( wc_get_cart_remove_url( $cart_key ) ),
					  __( 'Remove this item', 'woocommerce' ),
					  esc_attr( $product_id ),
					  esc_attr( $_product->get_sku() )
					);

					$_product = $cart_item['data'];
					if ( $_product->is_sold_individually() ) {
						$return_value .= sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_key );
					} else {
						$return_value .= woocommerce_quantity_input( array(
							'input_name'  => 'cart[' . $cart_key . '][qty]',
							'input_value' => $cart_item['quantity'],
							'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
							'min_value'   => '1',
						), $_product, false );
					}
					$output = $return_value;
				}
			}
		}
		return $output;
	}
}
Krokedil_Checkout_Customizer_Order_Lines::get_instance();