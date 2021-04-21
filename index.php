<?php
/*
Plugin Name: Crypto Converter
Plugin URI: https://github.com/sergejweb
Description: A simple WordPress plugin that allows user to convert cryptocurrencies
Version: 1.0
Author: Serhii Melnyk
Author URI: https://webmasterlab.net
Text Domain: crypto-converter
*/

// Setup
define( 'CRYPTO_PLUGIN_URL', __FILE__ );
define( 'API_URL', 'https://pro-api.coinmarketcap.com/v1' );

// Includes
include( 'includes/activate.php' );
include( 'includes/front/enqueue.php' );
include( 'includes/widgets.php' );
include( 'includes/widgets/crypto-currency.php' );
include( 'includes/services/convert-service.php' );
include( 'includes/services/currency-info-service.php' );
include( 'includes/services/save-history-service.php' );
include( 'includes/services/show-history-service.php' );

// Hooks
register_activation_hook( __FILE__, 'pc_activate_plugin' );
add_action( 'wp_enqueue_scripts', 'pc_enqueue_scripts' );
add_action( 'widgets_init', 'pc_widgets_init' );
add_action( 'wp_ajax_pc_get_price', 'pc_get_price' );
add_action( 'wp_ajax_nopriv_pc_get_price', 'pc_get_price' );
add_action( 'wp_ajax_pc_get_currency_list', 'pc_get_currency_list' );
add_action( 'wp_ajax_nopriv_pc_get_currency_list', 'pc_get_currency_list' );
add_action( 'wp_ajax_pc_set_conversion_history', 'pc_set_conversion_history' );
add_action( 'wp_ajax_nopriv_pc_set_conversion_history', 'pc_set_conversion_history' );
add_action( 'wp_ajax_pc_get_conversion_history', 'pc_get_conversion_history' );
add_action( 'wp_ajax_nopriv_pc_get_conversion_history', 'pc_get_conversion_history' );