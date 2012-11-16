<?php

class ForemanPostType {
  public $name = '';
  protected $_post_type_config = array();
  protected $_statuses = array();
  protected $_fields = array();
  protected $_meta_boxes = array();
  protected $_transitions = array();
  protected $_current_transition_info = array();
  protected $_index_table_columns = array();

  function __construct() {
    add_action('init', array(&$this, 'register_post_type'));
    add_action('init', array(&$this, 'register_statuses'));
    add_action('admin_init', array(&$this, 'register_meta_boxes'));
    add_filter("manage_{$this->name}_posts_columns", array(&$this, 'manage_index_table_column_labels'));
    add_action("manage_{$this->name}_posts_custom_column", array(&$this, 'manage_index_table_column_values'), 10, 2);
    add_action('save_post', array(&$this, 'save'));
    add_action('admin_head', array(&$this, 'replace_default_publish_box'), 100);    
    add_action('transition_post_status', array(&$this, 'do_transition'),10, 3);
  }

  function set_index_table_columns($columns) {
    $this->_index_table_columns = $columns;
  }

  function manage_index_table_column_values($column, $post_id) {
    if (!empty($this->_index_table_columns)) {
      $column_info = $this->_index_table_columns[$column];
      if (isset($column_info['field'])) {
        $field = $this->_fields[$column_info['field']];
        echo $field->get_value($post_id);
      }

      if (isset($column_info['callback'])) {
        call_user_func($column_info['callback'], $post_id);
      }
    }
  }

  function manage_index_table_column_labels($columns) {
    if (!empty($this->_index_table_columns)) {
      $defaults = array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title'),
        'author' => __('Author'),
        'categories' => __('Categories'),
        'tags' => __('Tags'),
        'comments' => __('Comments'),
        'date' => __('Date')
      );
      $new_columns = array();
      foreach ($this->_index_table_columns as $key => $info) {
        if (in_array($key, array_keys($defaults))) {
          $new_columns[$key] = $defaults[$key];
        } else {
          $new_columns[$key] = $info['label'];
        }
      }
      return $new_columns;
    } else {
      return $columns;
    }
  }

  function do_transition($new_status_id, $old_status_id, $post) {
    if ($post->post_type == $this->name && $new_status_id != $old_status_id) {
      if (isset($this->_transitions[$old_status_id])) {
        foreach ($this->_transitions[$old_status_id] as $possible_target) {
          if ($possible_target['to'] == $new_status_id && isset($possible_target['callback'])) {
            // This is a workaround because wordpress call the transition hook before
            // the save_post hook fires meaning transitions happen before post meta
            // has a chance to be saved. Here I cache the transition info in the 
            // object and then add a another hook to run long after all the other save_post
            // hooks have run to actuall call the user defined transition function so
            // the post meta should all be saved.
            $this->_current_transition_info = array(
              'callback' => $possible_target['callback'],
              'new_status_id' => $new_status_id,
              'old_status_id' => $old_status_id,
              'post' => $post
            );
            add_action('save_post', array(&$this, 'run_transition_after_meta_saved'), 100);
          }
        }
      }
    }
  }

  function run_transition_after_meta_saved() {
    $callback = $this->_current_transition_info['callback'];
    $new_status_id = $this->_current_transition_info['new_status_id'];
    $old_status_id = $this->_current_transition_info['old_status_id'];
    $post = $this->_current_transition_info['post'];
    call_user_func($callback, $new_status_id, $old_status_id, $post);
  }

  public function statuses() {
    return $this->_statuses;
  }

  public function has_custom_statuses() {
    return (count($this->_statuses) > 0);
  }

  public function has_transitions() {
    return (count($this->_transitions) > 0);
  }

  public function default_post_status() {
    if ($this->has_custom_statuses()) {
      $statuses = $this->_statuses;
      reset($statuses);
      return key($statuses);
    } else {
      return 'draft';
    }
  }

  public function statuses_available_for_state($state) {
    if (isset($this->_transitions[$state])) {
      $available_statuses = array($state=>$this->_statuses[$state]);
      foreach ($this->_transitions[$state] as $transition_details) {
        $available_statuses[$transition_details['to']] = $this->_statuses[$transition_details['to']];
      }
      return $available_statuses;
    } else {
      return $this->_statuses;
    }
  }

  public function get_current_or_default_status($status) {
    if (in_array($status, array_keys($this->_statuses))) {
      return $status;
    } else {
      reset($this->_statuses);
      return key($this->_statuses);
    }
  }

  public function replace_default_publish_box() {
    if (!empty($this->_statuses)) {
      global $pagenow, $wp_meta_boxes;
      if (in_array($pagenow, array('post.php', 'post-new.php'))) {
        $wp_meta_boxes[$this->name]['side']['core']['submitdiv']['callback'] = array(&$this, 'render_post_submit_meta_box');
      }
    }
  }

  public function render_post_submit_meta_box() {
    global $post;
  	$post_type = $post->post_type;
	  $post_type_object = get_post_type_object($post_type);
	  $can_publish = current_user_can($post_type_object->cap->publish_posts);
    $foreman_post_type = $this;

    include foreman_template_path('post_submit_meta_box.php');
  }

  public function save($post_id) {
    if (!isset($_POST['wp_foreman_nonce']) || !wp_verify_nonce($_POST['wp_foreman_nonce'], basename(__FILE__))) {
      return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return $post_id;
    }
    if ($_POST['post_type'] == 'page') {
      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      }
    } else {
      if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
      }
    }
    foreach ($this->_fields as $field) {
      if (isset($_POST[$field->id])) {
        $old = get_post_meta($post_id, $field->id, true);
        $new = isset($_POST[$field->id]) ? $_POST[$field->id] : null;

        $new = $field->validate($new);
        $field->save_for_metabox($new, $old, $post_id);
      }
    }
  }

  public function register_meta_boxes() {
    global $pagenow;
    if (in_array($pagenow, array('post.php', 'post-new.php'))) {
      $temp_post = foreman_get_admin_post();
      foreach ($this->_meta_boxes as $id => $meta_box) {
        if (foreman_meta_box_visible_for_status($meta_box, foreman_current_post_status($temp_post, $this))) {
          if (!isset($meta_box['context'])) $meta_box['context'] = 'advanced';
          if (!isset($meta_box['priority'])) $meta_box['priority'] = 'default';
          add_meta_box($id, $meta_box['title'], array(&$this, 'render_meta_box'), $this->name, $meta_box['context'], $meta_box['priority']);
        }
      }
    }
  }

  public function render_meta_box($post, $meta_box_info) {
    global $post;
    $meta_box_id = $meta_box_info['id'];
    echo '<input type="hidden" name="wp_foreman_nonce" value="', wp_create_nonce( basename(__FILE__) ), '" />';
    echo '<ul class="foreman-field-list">';
    foreach ($this->_meta_boxes[$meta_box_id]['fields'] as $field_id) {
      $field = $this->_fields[$field_id];
      $value = get_post_meta($post->ID, $field->id, true);

      $attributes = array();
      $attributes['id'] = foreman_field_wrapper_id($field->id);
      $attributes['class'] = 'cf';
      if (is_array($field->visible_on)) {
        $attributes['class'] = $attributes['class'].' foreman-visible-on';
        $attributes['data-visible-on-id'] = '#'.foreman_field_id($field->id);
        $attributes['data-visible-on-value'] = join($field->visible_on['value'], ',');
        $attributes['style'] = 'display: none;';
      }

      echo '<li '.foreman_field_wrapper_attributes($field).'>';
      $field->render($value, foreman_meta_box_editable_for_status($this->_meta_boxes[$meta_box_id], foreman_current_post_status($post, $this)));
      echo '</li>';
    }
    echo '</ul>';
  }

  public function register_post_type() {
    register_post_type($this->name, $this->_post_type_config);
  }

  public function register_statuses() {
    foreach ($this->_statuses as $id => $label) {
      register_post_status($id, array(
        'public' => true,
        'label' => $label,
        'label_count' => _n_noop($label.' <span class="count">(%s)</span>', $label.' <span class="count">(%s)</span>')
      ));
    }
  }

  public function set_post_type_config($name, $config) {
    $this->name = $name;
    $this->_post_type_config = $config;
  }

  public function add_statuses($statuses) {
    foreach ($statuses as $id => $label) {
      $this->add_status($id, $label);
    }
  }

  public function add_status($id, $label) {
    $this->_statuses[$id] = $label;
  }

  public function add_fields($fields) {
    foreach ($fields as $field) {
      $this->add_field($field);
    }
  }

  public function add_field($field) {
    $this->_fields[$field->id] = $field;
  }

  public function add_meta_boxes($meta_boxes) {
    foreach ($meta_boxes as $id => $meta_box) {
      $this->add_meta_box($id, $meta_box);
    }
  }

  public function add_meta_box($id, $meta_box) {
    if (!isset($meta_box['visible'])) $meta_box['visible'] = 'all';
    if (!isset($meta_box['editable'])) $meta_box['editable'] = 'all';
    $this->_meta_boxes[$id] = $meta_box;
  }

  public function add_transitions($transitions) {
    foreach ($transitions as $status => $transition_details) {
      $this->add_transition($status, $transition_details);
    }
  }

  public function add_transition($status, $transition_details) {
    if (isset($this->_transitions[$status])) {
      foreach ($transition_details as $transition_detail) {
        $this->_transitions[$status][] = $transition_detail;
      }
    } else {
      $this->_transitions[$status] = $transition_details;
    }
  }
}
