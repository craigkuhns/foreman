<?php
add_action('foreman_render_radio', 'foreman_render_radio', 10, 4);
function foreman_render_radio($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = get_post_meta($obj->ID, $field['id'], true);
      $meta = (empty($meta)) ? array() : $meta;
      $field['inline'] = (isset($field['inline'])) ? $field['inline'] : false;
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = (empty($obj)) ? array() : $obj;
      $field['inline'] = (isset($field['inline'])) ? $field['inline'] : false;
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = get_term_meta($obj->term_id, $field['id'], true);
      $meta = (empty($meta)) ? array() : $meta;
      $field['inline'] = (isset($field['inline'])) ? $field['inline'] : false;
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

add_filter('foreman_validate_radio', 'foreman_validate_radio', 10, 2);
function foreman_validate_radio($value, $field) {
  return $value;
}