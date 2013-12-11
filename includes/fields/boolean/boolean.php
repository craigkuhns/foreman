<?php
add_action('foreman_render_boolean', 'foreman_render_boolean', 10, 4);
function foreman_render_boolean($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = apply_filters('foreman_prepare_boolean_value', get_post_meta($obj->ID, $field['id'], true));
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = apply_filters('foreman_prepare_boolean_value', $obj);
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = apply_filters('foreman_prepare_boolean_value', get_term_meta($obj->term_id, $field['id'], true));
      include 'taxonomy.php';
      break;
    case 'widget':
      $meta = apply_filters('foreman_prepare_boolean_value', $obj->get_field($field['id']));
      include 'widget.php';
      break;
    default:
      echo "The field type '{$field['type']}' is not supported for use with the object type of '$render_type'";
      break;
  }
}

add_filter('foreman_validate_boolean', 'foreman_validate_boolean', 10, 2);
function foreman_validate_boolean($value, $field) {
  return $value;
}

add_filter('foreman_prepare_boolean_value', 'foreman_prepare_boolean_value', 10, 1);
function foreman_prepare_boolean_value($value) {
  return (empty($value)) ? '' : $value;
}