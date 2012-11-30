<?php
class ForemanWidget extends WP_Widget {
  protected $_widget_id = '';
  protected $_widget_name = '';
  protected $_widget_args = array();
  protected $_widget_template = '';
  protected $_fields = array();

  public function __construct() {
    parent::__construct($this->_widget_id, $this->_widget_name, $this->_widget_args);
  }

  public function set_widget_params($id, $name, $args) {
    $this->_widget_id = $id;
    $this->_widget_name = $name;
    $this->_widget_args = $args;
  }

  public function add_fields($fields) {
    foreach ($fields as $field) {
      $this->add_field($field);
    }
  }

  public function add_field($field) {
    $this->_fields[$field->id] = $field;
  }

  public function set_template($path) {
    $this->_widget_template = $path;
  }

  public function form($instance) {
    foreach ($this->_fields as $field) {
      //$value = get_post_meta($post->ID, $field->id, true);
      echo '<p>';
      $field->render_for_widget($this, $instance);
      echo '</p>';
    }
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    foreach ($this->_fields as $field) {
      if (isset($new_instance[$field->id])) {
        $instance[$field->id] = $field->validate($new_instance[$field->id]);
      }
    }
    return $instance;
  }

  public function widget($args, $instance) {
    $widget = $instance;
    extract($args);
    echo $before_widget;
    if (isset($instance['title']) && !empty($instance['title'])) {
      echo $before_title.$this->formated_title($instance).$after_title;
    }
    include $this->_widget_template;
    echo $after_widget;
  }

  public function formated_title($instance) {
    return apply_filters('widget_title', $instance['title']);
  }
}