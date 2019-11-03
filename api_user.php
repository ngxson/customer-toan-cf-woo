<?php

function nui_api_user() {
  $input = array(
    'uid' => nui_post('uid'),
    'first_name' => nui_post('first_name'),
    'last_name' => nui_post('last_name'),
    'full_name' => nui_post('full_name'),
    'phone' => nui_post('phone'),
    'email' => nui_post('email'),
    'address' => nui_post('address'),
    'city' => nui_post('city'),
  );

  if (nui_get('user_id', false)) {
    $input['uid'] = nui_get('user_id', '');
  }
  
  $customer = nui_get_customer_by_fbid($input['uid']);
  if ($input['first_name']) $customer->set_first_name($input['first_name']);
  if ($input['last_name']) $customer->set_last_name($input['last_name']);
  if ($input['full_name']) $customer->set_display_name($input['full_name']);
  if ($input['phone']) $customer->set_billing_phone($input['phone']);
  if ($input['email']) $customer->set_billing_phone($input['email']);
  if ($input['address']) $customer->set_billing_address($input['address']);
  if ($input['city']) $customer->set_billing_city($input['city']);
  $customer->set_billing_postcode('100000');
  $customer->set_billing_country('VN');
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
  if (!is_user_logged_in() && isset($_GET) && isset($_GET['user_id'])) {
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
