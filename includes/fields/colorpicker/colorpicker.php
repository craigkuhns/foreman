<?php
add_action('foreman_render_colorpicker', 'foreman_render_colorpicker', 10, 4);
function foreman_render_colorpicker($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = apply_filters('foreman_prepare_colorpicker_value', get_post_meta($obj->ID, $field['id'], true));
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = apply_filters('foreman_prepare_colorpicker_value', $obj);
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = apply_filters('foreman_prepare_colorpicker_value', get_term_meta($obj->term_id, $field['id'], true));
      include 'taxonomy.php';
      break;
    case 'widget':
      $meta = apply_filters('foreman_prepare_colorpicker_value', $obj->get_field($field['id']));
      include 'widget.php';
      break;
    default:
      echo "This field is not supported for this type of object";
      break;
  }
}

add_filter('foreman_validate_colorpicker', 'foreman_validate_colorpicker', 10, 2);
function foreman_validate_colorpicker($value, $field) {
  return str_replace('#', '', $value);
}

add_filter('foreman_prepare_colorpicker_value', 'foreman_prepare_colorpicker_value', 10, 1);
function foreman_prepare_colorpicker_value($value) {
  return (empty($value)) ? '' : $value;
}