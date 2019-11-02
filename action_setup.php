<?php

// DONNOT USE THIS FILE

/*function nui_action_setup() {
  $WEBHOOK_NAME = 'cf-api-create-order';
  $ds = new WC_Webhook_Data_Store();
  $search_res = $ds->search_webhooks(
    array( 'search' => $WEBHOOK_NAME )
  );
  $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $wh_link = str_replace('action_setup.php', 'action_wh_order_create.php', $actual_link);
  if (sizeof($search_res) == 0) {
    $wh = new WC_Webhook();
    $wh->set_name($WEBHOOK_NAME);
    $wh->set_status('active');
    $wh->set_topic('order.created');
    $wh->set_delivery_url($wh_link);
    $wh->set_secret($WEBHOOK_NAME.'-secret');
    $wh->set_api_version(3);
    $ds->create($wh);
    echo 'WEBHOOK: Setup done<br/>';
  }
}*/
