<?php
add_action('foreman_render_wysiwyg', 'foreman_render_wysiwyg', 10, 4);
function foreman_render_wysiwyg($render_type, $obj, $field, $editable=true) {
  switch ($render_type) {
    case 'meta_box':
      $meta = get_post_meta($obj->ID, $field['id'], true);
      $meta = (empty($meta)) ? '' : $meta;
      $field['options'] = (isset($field['options'])) ? $field['options'] : array();
      include 'meta_box.php';
      break;
    case 'repeater':
      $meta = (empty($obj)) ? '' : $obj;
      $field['options'] = (isset($field['options'])) ? $field['options'] : array();
      include 'meta_box.php';
      break;
    case 'taxonomy':
      $meta = get_term_meta($obj->term_id, $field['id'], true);
      $meta = (empty($meta)) ? '' : $meta;
      $field['options'] = (isset($field['options'])) ? $field['options'] : array();
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

add_filter('foreman_validate_wysiwyg', 'foreman_validate_wysiwyg');
function foreman_validate_wysiwyg($value) {
  return $value;
}