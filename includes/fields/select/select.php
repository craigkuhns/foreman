<?php
add_action('foreman_render_select', 'foreman_render_select', 10, 4);
function foreman_render_select($render_type, $obj, $field, $editable=true) {

  if (!isset($field['options'])) {
    if (isset($field['options_from'])) {
      if ($field['options_from'] == 'taxonomy') {
        $field['options'] = foreman_get_select_options_from_taxonomy_terms($field['options_from_args']);
      }
    } else {
      $field['options'] = array();
    }
  }

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

add_filter('foreman_validate_select', 'foreman_validate_select', 10, 2);
function foreman_validate_select($value, $field) {
  return $value;
}