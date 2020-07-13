<?php

/**
 * Plugin Name: Huniqcast Stripe PaymentIntent
 * Plugin URI: https://huniqcast.com
 * Description: Handle stripe payment intent server side part.
 * Version: 0.1.0
 * Author: Hermann donfack Zeufack
 * Author URI: https://huniqcast.com
 * License: GPL2
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'HQC_STRIPE_PAYMENT_INTENT_PLUGIN_FILE' ) ) {
	define( 'HQC_STRIPE_PAYMENT_INTENT_PLUGIN_FILE', __FILE__ );
}

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Returns the main instance of WC.
 *
 * @since  2.1
 * @return WooCommerce
 */
function init() {
    return Huniqcast\Stripe\HuniqcastStripe::instance();
}

init();