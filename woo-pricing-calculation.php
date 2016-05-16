<?php 
/**
 * Plugin Name: WooCommerce Pricing Calculation (BETA)
 * Plugin URI: http://arnaim.me/plugins/woo-pricing-calculation
 * Description: This plugin will add extra pricing meta fields on WooCommerce product. So on invoice or anywhere it can be used.
 * Version: 1.0.0
 * Author: A R Naim
 * Author URI: http://arnaim.me
 * License: GPL2
 */



function woo_cp_price_calculation_field() {

    woocommerce_wp_text_input( 
    	array( 
			'id'    => '_unit_price', 
			'class' => 'wc_input_price short', 
			'label' => esc_html__( 'Unit Price', 'text-domain' ) . ' (' . get_woocommerce_currency_symbol() . ')' 
		)
    );

    woocommerce_wp_text_input( 
    	array( 
			'id'    => '_custom_duty', 
			'class' => 'wc_input_price short', 
			'label' => esc_html__( 'Custom Duty', 'text-domain' ) . ' (' . get_woocommerce_currency_symbol() . ')' 
		)
    );

    woocommerce_wp_text_input( 
    	array( 
			'id'    => '_company_fee', 
			'class' => 'wc_input_price short', 
			'label' => esc_html__( 'Ocimi Fee', 'text-domain' ) . ' (' . get_woocommerce_currency_symbol() . ')' 
		)
    );

}
add_action( 'woocommerce_product_options_pricing', 'woo_cp_price_calculation_field' );


function woo_cp_save_price_calculation( $product_id ) {
 	
 	// stop the quick edit interferring as this will stop it saving properly, when a user uses quick edit feature
    if (wp_verify_nonce($_POST['_inline_edit'], 'inlineeditnonce'))
        return;

 	//If this is a auto save do nothing, we only save when update button is clicked
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;

	$unit_price  = $_POST['_unit_price'];
	$custom_duty = $_POST['_custom_duty'];
	$company_fee = $_POST['_company_fee'];

	if ( isset( $unit_price ) && isset( $custom_duty ) && isset( $company_fee ) ) {

		if ( is_numeric( $unit_price) && is_numeric( $custom_duty ) && is_numeric( $company_fee ) )
			update_post_meta( $product_id, '_unit_price', $unit_price );
			update_post_meta( $product_id, '_custom_duty', $custom_duty );
			update_post_meta( $product_id, '_company_fee', $company_fee );

	} #end if [isset check]
}
add_action( 'woocommerce_process_product_meta', 'woo_cp_save_price_calculation' );