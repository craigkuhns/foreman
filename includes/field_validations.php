<?php
add_filter('foreman_validate_textarea', 'foreman_validate_as_textarea');
add_filter('foreman_validate_textarea_small', 'foreman_validate_as_textarea');
add_filter('foreman_validate_textarea_code', 'foreman_validate_as_textarea_code');
add_filter('foreman_validate_text_date_timestamp', 'foreman_validate_as_timestamp');
add_filter('foreman_validate_text_datetime_timestamp', 'foreman_validate_as_timestamp');
add_filter('foreman_validate_text_money', 'foreman_validate_as_money');

function foreman_validate_as_textarea($value) {
  return htmlspecialchars($value);
}

function foreman_validate_as_textarea_code($value) {
  return htmlspecialchars_decode($value);
}

function foreman_validate_as_timestamp($value) {
  return strtotime($value);
}

function foreman_validate_as_money($value) {
  return number_format($value, 2);
}
