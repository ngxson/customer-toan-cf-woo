<?php
/**
 * Plugin Name: Chatfuel Woocommerce
 * Plugin URI: https://ngxson.com
 * Description: Chatfuel Woocommerce JSON API
 * Version: 1.1
 * Author: ngxson
 * Author URI: https://ngxson.com
 */

include __DIR__ . '/lib_utils.php';
include __DIR__ . '/action_self_update.php';
include __DIR__ . '/action_wh_order_create.php';
include __DIR__ . '/api_last_order.php';
include __DIR__ . '/api_user.php';
include __DIR__ . '/page_settings.php';

/**
 * Allow rendering of checkout and account pages in iframes.
 */
add_action( 'after_setup_theme', 'wc_remove_frame_options_header', 11 );
function wc_remove_frame_options_header() {
	remove_action( 'template_redirect', 'wc_send_frame_options_header' );
}

function add_cors_http_header(){
    header("Access-Control-Allow-Origin: *");
}
add_action('init','add_cors_http_header');
