<?php

function nui_api_last_order() {
  $concurrency = nui_get('price', '₫');
  $customer = nui_get_customer_by_fbid(nui_get('uid'));
  $order = $customer->get_last_order();
  $order_items = $order->get_items();
  $product_details = array();
  foreach( $order_items as $product ) {
    $product_details[] = $product['name'].' ('
      .($product['qty'] > 1 ? $product['qty'].'×' : '')
      .nui_f($product['subtotal'] / $product['qty']).$concurrency
      .')';
  }
  //var_dump($order);
  return array(
    'set_attributes' => array(
      'don-hang' => implode("\n", $product_details),
      'don-hang-tong' => nui_f($order->get_total()).$concurrency,
    )
  );
}

add_action( 'rest_api_init', function () {
  register_rest_route( 'chatfuel', '/last-order', array(
    'methods' => 'GET',
    'callback' => 'nui_api_last_order',
  ) );
} );
