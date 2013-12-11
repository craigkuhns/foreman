<?php

add_action("wp_ajax_foreman_ajax_user_exists", "foreman_ajax_user_exists");
add_action("wp_ajax_nopriv_foreman_ajax_user_exists", "foreman_ajax_user_exists");
function foreman_ajax_user_exists() {
  if (username_exists($_GET['username']) != null) {
    $return = array('response' => true);
  } else {
    $return = array('response' => false);
  }
  echo json_encode($return);
  die();
}

add_action("wp_ajax_foreman_ajax_email_exists", "foreman_ajax_email_exists");
add_action("wp_ajax_nopriv_foreman_ajax_email_exists", "foreman_ajax_email_exists");
function foreman_ajax_email_exists() {
  if (email_exists($_GET['email']) != null) {
    $return = array('response' => true);
  } else {
    $return = array('response' => false);
  }
  echo json_encode($return);
  die();
}