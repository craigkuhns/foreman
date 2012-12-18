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

function foreman_field_wrapper_attributes($field, $parent = null, $position = null) {
  $attributes = array();
  $attributes['id'] = foreman_field_wrapper_id($field, $parent, $position);
  $attributes['class'] = 'cf '.get_class($field);
  if (is_array($field->visible_on)) {
    $attributes['class'] = $attributes['class'].' foreman-visible-on';
    $attributes['data-visible-on-id'] = '#'.foreman_field_id($field->visible_on['id'], $parent, $position);
    $attributes['data-visible-on-value'] = join($field->visible_on['value'], ',');
    $attributes['style'] = 'display: none;';
  }
  return foreman_html_attrs_from_array($attributes);
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
  if ($parent != null) {
    if (is_null($position)) $position = '{position-placeholder}';
    return "{$parent->id}[$position][{$field_id}]";
  } else {
    return $field_id;
  }
}

function foreman_field_id($field, $parent=null, $position=null) {
  $field_id = (is_object($field)) ? $field->id : $field;
  if ($parent != null) {
    if (is_null($position)) $position = '{position-placeholder}';
    return "{$parent->id}-$position-{$field_id}";
  } else {
    return $field_id;
  }
}

function foreman_field_wrapper_id($field, $parent=null, $position=null) {
  $field_id = (is_object($field)) ? $field->id : $field;
  if ($parent != null) {
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

function foreman_truncate($str, $length=10, $trailing='...') {
  $length -= mb_strlen($trailing);
  if (mb_strlen($str) < $length) return $str;
  return mb_substr($str,0,$length).$trailing;
}

function foreman_current_page_url() {
  $page_url = 'http';
  if ($_SERVER["HTTPS"] == "on") $page_url .= "s";
  $page_url .= "://";
  if ($_SERVER["SERVER_PORT"] != "80") {
    $page_url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
  } else {
    $page_url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
  }
  return $page_url;
}

function foreman_html_mail($to, $subject, $message, $headers=array('Content-type: text/html'), $attachments=array()) {
  $headers = array_merge(array('Content-type: text/html'), $headers);
  return wp_mail($to, $subject, $message, $headers, $attachments);
}

if (!function_exists('add_term_meta')) {
  function add_term_meta($term_id, $meta_key, $meta_value, $unique = false) {
    return add_metadata('term', $term_id, $meta_key, $meta_value, $unique);
  }
}

if (!function_exists('delete_term_meta')) {
  function delete_term_meta($term_id, $meta_key, $meta_value = '') {
    return delete_metadata('term', $term_id, $meta_key, $meta_value);
  }
}

if (!function_exists('get_term_meta')) {
  function get_term_meta($term_id, $key = '', $single = false) {
    return get_metadata('term', $term_id, $key, $single);
  }
}

if (!function_exists('update_term_meta')) {
  function update_term_meta($term_id, $meta_key, $meta_value, $prev_value = '')  {
    return update_metadata('term', $term_id, $meta_key, $meta_value, $prev_value);
  }
}

if (!function_exists('delete_term_meta_by_key')) {
  function delete_term_meta_by_key($term_meta_key) {
    return delete_metadata('term', null, $term_meta_key, '', true);
  }
}

if (!function_exists('get_term_custom')) {
  function get_term_custom($term_id = 0) {
    $term_id = absint($term_id);
    return !$term_id ? null : get_term_meta($term_id);
  }
}

if (!function_exists('get_term_custom_keys')) {
  function get_term_custom_keys($term_id = 0) {
    $custom = get_term_custom($term_id);
    if (!is_array($custom)) {
      return;
    }
    if ($keys = array_keys($custom)) {
      return $keys;
    }
  }
}

if (!function_exists('get_term_custom_values')) {
  function get_term_custom_values($key = '', $term_id = 0) {
    if (!$key) {
      return null;
    }
    $custom = get_term_custom($term_id);
    return isset($custom[$key]) ? $custom[$key] : null;
  }
}