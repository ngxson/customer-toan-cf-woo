<?php

function nui_get_customer_by_fbid($fbid) {
  $username = 'fb'.$fbid;
  $user = get_user_by('login', $username);
  if ( is_wp_error($user) || !$user ) {
    $uid = wp_create_user($username, 'BcPme3erGb3vUqWs', $username.'@fb.com');
    $user = new WP_User($uid);
    $user->set_role('customer');
  }
  
  $customer = new WC_Customer($user->ID);
  return $customer;
}

function nui_get($name, $def = '') {
  return isset($_GET[$name]) && $_GET[$name] !== ''
    ? $_GET[$name] : $def;
}

function nui_f($number) {
  return number_format($number, 0, ',', '.');
}

function nui_post($name) {
  return isset($_POST[$name]) && $_POST[$name] !== ''
    ? $_POST[$name] : false;
}
