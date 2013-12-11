<?php
add_action('foreman_render_file', 'foreman_render_file', 10, 4);
function foreman_render_file($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = get_post_meta($obj->ID, $field['id'], true);
      $meta = (empty($meta)) ? '' : $meta;
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = (empty($obj)) ? '' : $obj;
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = get_term_meta($obj->term_id, $field['id'], true);
      $meta = (empty($meta)) ? '' : $meta;
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

add_filter('foreman_validate_file', 'foreman_validate_file', 10, 2);
function foreman_validate_file($value, $field) {
  return $value;
}