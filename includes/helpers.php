<?php
function foreman_cpt_labels($singular, $plural) {
  return array(
    'name' => $plural,
    'singular_name' => $singular,
    'add_new' => "Add New",
    'add_new_item' => "Add New $singular",
    'edit_item' => "Edit $singular",
    'new_item' => "New $singular",
    'all_items' => "All $plural",
    'view_item' => "View $singular",
    'search_items' => "Search $plural",
    'not_found' =>  "No ".strtolower($plural)." found",
    'not_found_in_trash' => "No ".strtolower($plural)." found in Trash", 
    'parent_item_colon' => "",
    'menu_name' => $plural
  );
}

function foreman_taxonomy_labels($singular, $plural) {
  return array(
    'name' => $plural,
    'singular_name' => $singular,
    'search_items' =>  "Search $plural",
    'popular_items' => "Popular $plural",
    'all_items' => "All $plural",
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => "Edit $singular", 
    'update_item' => "Update $singular",
    'add_new_item' => "Add New $singular",
    'new_item_name' => "New $singular Name",
    'separate_items_with_commas' => "Separate $singular with commas",
    'add_or_remove_items' => "Add or remove $plural",
    'choose_from_most_used' => "Choose from the most used $plural",
    'menu_name' => $plural,
  ); 
}

function foreman_html_attrs_from_array($attrs) {
  $ret = array();
  foreach ($attrs as $key => $val) {
    $ret[] = "$key='$val'";
  }
  return implode(' ', $ret);
}

function foreman_template_path($template) {
  return FOREMAN_PATH.'templates/'.$template;
}

function foreman_field_name($field, $parent=null, $position=null) {
  $field_id = (is_object($field)) ? $field->id : $field; 
  if ($parent) {
    if (is_null($position)) $position = '{position-placeholder}';
    return "{$parent->id}[$position][{$field_id}]";
  } else {
    return $field_id;
  }
}

function foreman_field_id($field, $parent=null, $position=null) {
  $field_id = (is_object($field)) ? $field->id : $field;
  if ($parent) {
    if (is_null($position)) $position = '{position-placeholder}';
    return "{$parent->id}-$position-{$field_id}";
  } else {
    return $field_id;
  }
}

function foreman_field_wrapper_id($field, $parent=null, $position=null) {
  $field_id = (is_object($field)) ? $field->id : $field; 
  if ($parent) {
    if (is_null($position)) $position = '{position-placeholder}';
    return "{$parent->id}-$position-{$field_id}-field-wrapper";
  } else {
    return $field_id.'-field-wrapper';
  }
}

function pretty_print_r($val) {
  echo '<pre><code>';
  print_r($val);
  echo '</code></pre>';
}

function foreman_meta_box_visible_for_status($meta_box, $status) {
  if ($meta_box['visible'] == 'all') return true;
  if ($meta_box['visible'] == 'none') return false;
  if (is_array($meta_box['visible'])) return in_array($status, $meta_box['visible']);
}

function foreman_meta_box_editable_for_status($meta_box, $status) {
  if ($meta_box['editable'] == 'all') return true;
  if ($meta_box['editable'] == 'none') return false;
  if (is_array($meta_box['editable'])) return in_array($status, $meta_box['editable']);
}

function foreman_get_admin_post() {
  $post_id = absint(isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0));
  $temp_post = $post_id != 0 ? get_post($post_id) : false; // Post Object, like in the Theme loop
  return $temp_post;
}

function foreman_current_post_status($post, $post_type) {
  if ($post_type->has_custom_statuses()) {
    if (isset($post->post_status) && in_array($post->post_status, array_keys($post_type->statuses()))) {
      return $post->post_status;
    } else {
      return $post_type->default_post_status();
    }
  } else {
    return $post->post_status;
  }
}

function foreman_get_all_tax_meta($term_id) {
  $id = (is_object($term_id)) ? $term_id->term_id : $term_id;
  return get_option('tax_meta_'.$id);
}

function foreman_get_tax_meta($term_id, $key, $multi = false) {
  $id = (is_object($term_id)) ? $term_id->term_id : $term_id;
  $meta = get_option('tax_meta_'.$id);
  if (isset($meta[$key])) {
    return $meta[$key];
  } else {
    return '';
  }
}

function foreman_delete_tax_meta($term_id, $key) {
  $meta = get_option('tax_meta_'.$term_id);
  if (isset($meta[$key])) {
    unset($meta[$key]);
  }
  update_option('tax_meta_'.$term_id, $meta);
}

function foreman_update_tax_meta($term_id, $key, $value) {
  $meta = get_option('tax_meta_'.$term_id);
  $meta[$key] = $value;
  update_option('tax_meta_'.$term_id, $meta);
}