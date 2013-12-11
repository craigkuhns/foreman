<?php
add_action('foreman_render_datetime_timestamp', 'foreman_render_datetime_timestamp', 10, 4);
function foreman_render_datetime_timestamp($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = get_post_meta($obj->ID, $field['id'], true);
      $meta = (empty($meta)) ? '' : strftime('%m/%e/%Y %I:%M %p', $meta);
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = (empty($obj)) ? '' : strftime('%m/%e/%Y %I:%M %p', $obj);
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = get_term_meta($obj->term_id, $field['id'], true);
      $meta = (empty($meta)) ? '' : strftime('%m/%e/%Y %I:%M %p', $meta);
      include 'taxonomy.php';
      break;
    case 'widget':
      include 'widget.php';
      break;
    default:
      echo "This field is not supported for this type of object";
      break;
  }
}

add_filter('foreman_validate_datetime_timestamp', 'foreman_validate_datetime_timestamp', 10, 2);
function foreman_validate_datetime_timestamp($value, $field) {
  $value = (empty($value)) ? '' : strtotime($value);
  return $value;
}