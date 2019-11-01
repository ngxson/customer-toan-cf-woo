<?php

function nui_action_wh_order_create($order_id, $data) {
  $customer = new WC_Customer(get_current_user_id());
  //file_put_contents(__DIR__.'/debug.txt', var_export($customer, true));
  $messid = str_replace('fb', '', $customer->get_username());
  $cf_bot_id = get_option('cfapi_bot_id');
  $cf_bot_token = get_option('cfapi_bot_token');
  $url = 'https://api.chatfuel.com/bots/'.$cf_bot_id.'/users'.'/'.$messid.'/send?chatfuel_token='.$cf_bot_token.'&chatfuel_message_tag=ACCOUNT_UPDATE&chatfuel_block_name=hanh-dong-dat-hang';
  wp_remote_post($url, array(
    'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'body' => array(),
    'cookies' => array(),
  ));
  //echo $url;
}

add_filter('woocommerce_checkout_update_order_meta', 'nui_action_wh_order_create', 10, 2);
