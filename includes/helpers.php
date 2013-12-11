<?php

function pretty_print_r($val) {
  echo '<pre><code>';
  print_r($val);
  echo '</code></pre>';
}

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

function foreman_field_id($field) {
  if (isset($field['parent'])) {
    $position = (isset($field['position'])) ? $field['position'] : '{position-placeholder}';
    return $field['parent']['id'].'-'.$position.'-'.$field['id'];
  } else {
    return $field['id'];
  }
}

function foreman_visible_on_id($field) {
  if (isset($field['parent'])) {
    $position = (isset($field['position'])) ? $field['position'] : '{position-placeholder}';
    return $field['parent']['id'].'-'.$position.'-'.$field['visible_on']['id'];
  } else {
    return $field['visible_on']['id'];
  }
}

function foreman_field_wrapper_id($field) {
  if (isset($field['parent'])) {
    $position = (isset($field['position'])) ? $field['position'] : '{position-placeholder}';
    return $field['parent']['id'].'-'.$position.'-'.$field['id'].'-field-wrapper';
  } else {
    return $field['id'].'-field-wrapper';
  }
}

function foreman_field_name($field) {
  if (isset($field['parent'])) {
    $position = (isset($field['position'])) ? $field['position'] : '{position-placeholder}';
    return $field['parent']['id'].'['.$position.']['.$field['id'].']';
  } else {
    return $field['id'];
  }
}

function foreman_field_wrapper_attributes($field) {
  $attributes = array();
  $attributes['id'] = foreman_field_wrapper_id($field);
  $attributes['class'] = 'cf '.$field['type'].'-field';
  if (isset($field['visible_on']) && is_array($field['visible_on'])) {
    $attributes['class'] .= ' foreman-visible-on';
    $attributes['data-visible-on-id'] = '#'.foreman_visible_on_id($field);
    $attributes['data-visible-on-value'] = join($field['visible_on']['value'], ',');
    $attributes['style'] = 'display: none;';
  }
  if (isset($field['show_label']) && $field['show_label'] == false) {
    $attributes['class'] .= ' hide-label';
  }
  return foreman_html_attrs_from_array($attributes);
}

function foreman_taxonomy_field_wrapper_attributes($field) {
  $attributes = array();
  $attributes['id'] = foreman_field_wrapper_id($field);
  $attributes['class'] = $field['type'].'-field form-field foreman-taxonomy-field';
  if (isset($field['visible_on']) && is_array($field['visible_on'])) {
    $attributes['class'] .= ' foreman-visible-on';
    $attributes['data-visible-on-id'] = '#'.foreman_visible_on_id($field);
    $attributes['data-visible-on-value'] = join($field['visible_on']['value'], ',');
    $attributes['style'] = 'display: none;';
  }
  return foreman_html_attrs_from_array($attributes);
}

function foreman_widget_field_wrapper_attributes($field) {
  $attributes = array();
  $attributes['id'] = foreman_field_wrapper_id($field);
  $attributes['class'] = $field['type'].'-field foreman-widget-field';
  if (isset($field['visible_on']) && is_array($field['visible_on'])) {
    $attributes['class'] .= ' foreman-visible-on';
    $attributes['data-visible-on-id'] = '#'.foreman_visible_on_id($field);
    $attributes['data-visible-on-value'] = join($field['visible_on']['value'], ',');
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

function foreman_post_type_statuses($post) {
  return Foreman::post_type_statuses($post);
}

function foreman_post_type_current_or_default_status($post) {
  $statuses = foreman_post_type_statuses($post);
  if (in_array($post->post_status, array_keys($statuses))) {
    return $post->post_status;
  } else {
    return foreman_post_type_default_post_status($post);
  }
}

function foreman_current_post_status($post) {
  $statuses = foreman_post_type_statuses($post);
  if (!empty($statuses)) {
    if (isset($post->post_status) && in_array($post->post_status, array_keys($statuses))) {
      return $post->post_status;
    } else {
      return foreman_post_type_default_post_status($post);
    }
  } else {
  }
}

function foreman_post_type_default_post_status($post) {
  $statuses = foreman_post_type_statuses($post);
  if (!empty($statuses) && is_array($statuses)) {
    reset($statuses);
    return key($statuses);
  } else {
    return $draft;
  }
}

function foreman_meta_box_visible_for_status($meta_box, $status) {
  if (isset($meta_box['visible'])) {
    if ($meta_box['visible'] == 'all') return true;
    if ($meta_box['visible'] == 'none') return false;

    $visible_on = (is_array($meta_box['visible'])) ? $meta_box['visible'] : array($meta_box['visible']);
    return in_array($status, $visible_on);
  }
  return true;
}

function foreman_meta_box_editable_for_status($meta_box, $status) {
  if (isset($meta_box['editable'])) {
    if ($meta_box['editable'] == 'all') return true;
    if ($meta_box['editable'] == 'none') return false;

    $editable_on = (is_array($meta_box['editable'])) ? $meta_box['editable'] : array($meta_box['editable']);
    return in_array($status, $editable_on);
  }
  return true;
}

function foreman_get_admin_post() {
  $post_id = absint(isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post_ID']) ? $_POST['post_ID'] : 0));
  $temp_post = $post_id != 0 ? get_post($post_id) : false; // Post Object, like in the Theme loop
  if (!$temp_post) {
    $temp_post = new ForemanDummyPost(array(
      'post_type' => (isset($_GET['post_type'])) ? $_GET['post_type'] : 'post',
      'post_status' => 'draft'
    ));
  }
  return $temp_post;
}

function foreman_post_type_statuses_available_for_status($post) {
  $current_status = foreman_post_type_current_or_default_status($post);
  $all_statuses = foreman_post_type_statuses($post);
  $transitions = foreman_post_type_transitions($post);
  if (isset($transitions[$current_status]) && !empty($transitions[$current_status])) {
    $available_statuses = array($current_status => $all_statuses[$current_status]);
    foreach ($transitions[$current_status] as $transition) {
      $available_statuses[$transition['to']] = $all_statuses[$transition['to']];
    }
    return $available_statuses;
  } else {
    return $all_statuses;
  }
}

function foreman_post_type_transitions($post) {
  return Foreman::post_type_transitions($post);
}

function foreman_get_select_options_from_taxonomy_terms($taxonomy) {
  $options = array();
  $terms = get_terms($taxonomy);
  foreach ($terms as $term) {
    $options[] = array('name' => $term->name, 'value' => $term->term_id);
  }
  return $options;
}