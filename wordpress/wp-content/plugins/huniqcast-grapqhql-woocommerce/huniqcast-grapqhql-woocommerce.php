<?php

/**
 * Plugin Name: Huniqcast GraphQL Woocommerce
 * Plugin URI: https://huniqcast.com
 * Description: Extending wp graphql woocommerce plugin types.
 * Version: 0.1.0
 * Author: Hermann donfack Zeufack
 * Text Domain:     huniqcast-graphql
 * Domain Path:     /languages
 * Author URI: https://huniqcast.com
 * License: GPL2
 */


// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    exit;
}

defined('HQC_WPGRAPHQL_VERSION') || define('HQC_WPGRAPHQL_VERSION', '0.1.0');
defined('HQC_WPGRAPHQL_PLUGING_DIR') || define('HQC_WPGRAPHQL_PLUGING_DIR', dirname(__FILE__));
defined('HQC_WPGRAPHQL_PLUGING_URL') || define('HQC_WPGRAPHQL_PLUGING_URL', plugin_dir_url(__FILE__));
defined('HQC_WPGRAPHQL_PLUGING_FILE') || define('HQC_WPGRAPHQL_PLUGING_FILE', __FILE__);
defined('HQC_DS') || define("HQC_DS", DIRECTORY_SEPARATOR);

// Require Composer autoload
require_once HQC_WPGRAPHQL_PLUGING_DIR . HQC_DS . 'vendor' . HQC_DS . 'autoload.php';


function hqc_graphql_woocommerce_init(){
    \Huniqcast\WPGraphQL\Main::getInstance()->initialization();
}

add_filter( 'graphql_jwt_auth_secret_key', function() {
  return 'sy]_Zv(i ->V7A:fg}}#kXD(z<zP=^>cOhgj-W?_-7uGEqg/S{p2oZKIQ,Rf|xK@';
});


//Only initialize if graphql_woocommerce_init is fired as this plugin is only extending it.
add_action( 'graphql_woocommerce_init', 'hqc_graphql_woocommerce_init' );

