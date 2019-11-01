<?php

function nui_api_user() {
  $input = array(
    'uid' => nui_post('uid'),
    'first_name' => nui_post('first_name'),
    'last_name' => nui_post('last_name'),
    'phone' => nui_post('phone number'),
    'address' => nui_post('address'),
    'avatar' => nui_post('avatar'),
  );

  if (nui_get('messid', false)) {
    $input['uid'] = nui_get('messid', '');
  }
  
  $customer = nui_get_customer_by_fbid($input['uid']);
  if ($input['first_name']) $customer->set_first_name($input['first_name']);
  if ($input['last_name']) $customer->set_last_name($input['last_name']);
  if ($input['address']) $customer->set_billing_address($input['address']);
  if ($input['phone']) $customer->set_billing_phone($input['phone']);
  $customer->save();

  return array(
    'success' => true,
    'id' => $customer->get_id(),
  );
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'chatfuel', '/user', array(
    'methods' => 'POST',
    'callback' => 'nui_api_user',
  ) );
} );

function nui_auto_login() {
  if (!is_user_logged_in() && isset($_GET) && isset($_GET['messid'])) {
    $res = nui_api_user();
    $user = get_user_by('id', $res['id']);
    if ( !is_wp_error( $user ) && $user ) {
        wp_clear_auth_cookie();
        wp_set_current_user ( $user->ID );
        wp_set_auth_cookie  ( $user->ID, true );
    }
  }
}

add_action('init', 'nui_auto_login');
