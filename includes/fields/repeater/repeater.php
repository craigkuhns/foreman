<?php
add_action('foreman_render_repeater', 'foreman_render_repeater', 10, 4);
function foreman_render_repeater($render_type, $obj, $field, $editable=true) {
  $field['sortable'] = (isset($field['sortable'])) ? $field['sortable'] : false;
  $field['fields'] = (isset($field['fields'])) ? $field['fields'] : array();
  switch ($render_type) {
    case 'meta_box':
      $meta = get_post_meta($obj->ID, $field['id'], true);
      $meta = (empty($meta)) ? '' : $meta;
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

add_filter('foreman_validate_repeater', 'foreman_validate_repeater', 10, 2);
function foreman_validate_repeater($value, $field) {
  $db_version = array();
  foreach ($value as $val) {
    foreach ($field['fields'] as $current_field) {
      if (isset($val[$current_field['id']])) {
        $val[$current_field['id']] = apply_filters('foreman_validate_'.$current_field['type'], $val[$current_field['id']], $current_field);
      }
    }
    $db_version[] = $val;
  }
  return $db_version;
}