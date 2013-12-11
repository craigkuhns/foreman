<?php
class ForemanWidget extends WP_Widget {
  protected $_id = '';
  protected $_name = '';
  protected $_description = '';
  protected $_template = '';
  protected $_fields = array();
  public $_form_instance_data = null;

  public function __construct($settings) {
    $this->_id = $settings['id'];
    $this->_name = $settings['name'];
    $this->_description = $settings['description'];
    $this->_template = $settings['template'];
    $this->_fields = $settings['fields'];

    parent::__construct($this->_id, $this->_name, array('description' => $this->_description));
  }

  public function form($instance) {
    $this->_form_instance_data = $instance;
    foreach ($this->_fields as $field) {
      echo '<p '.foreman_widget_field_wrapper_attributes($field).'>';
      do_action('foreman_render_'.$field['type'], 'widget', $this, $field);
      echo '</p>';
    }
  }

  public function get_field($key) {
    $data = (isset($this->_form_instance_data[$key])) ? $this->_form_instance_data[$key] : null;
    return $data;
  }

  public function update($new_instance, $old_instance) {
    $instance = array();
    foreach ($this->_fields as $field) {
      if (isset($new_instance[$field['id']])) {
        $instance[$field['id']] = apply_filters('foreman_validate_'.$field['type'],$new_instance[$field['id']], $field);
      }
    }
    return $instance;
  }

  public function widget($args, $instance) {
    /*$widget = $instance;
    extract($args);
    echo $before_widget;
    if (isset($instance['title']) && !empty($instance['title'])) {
      echo $before_title.$this->formated_title($instance).$after_title;
    }
    include $this->_widget_template;
    echo $after_widget;*/
    echo "This is your widget baby";
  }
}