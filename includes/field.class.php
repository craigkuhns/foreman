<?php
class ForemanField {
  public $template_path = '';
  public $widget_template_path = '';
  public $name = '';
  public $id = '';
  public $description = '';

  function __construct($args = array()) {
    $default_arg_names = array('name', 'id', 'description');
    foreach ($args as $arg => $value) {
      if (in_array($arg, $default_arg_names)) $this->$arg = $value;
    }
  }

  function validate($value) {
    // Default validation is no validation
    return $value;
  }

  function render($value, $editable = true, $parent = null, $position = null) {
    // Default render is to load php file
    $field = $this;
    include $this->template_path;
  }

  function render_for_widget($widget, $instance) {
    $field = $this;
    include $this->widget_template_path;
  }

  function get_value($post_id) {
    return get_post_meta($post_id, $this->id, true);
  } 

  function save_for_metabox($new, $old, $post_id) {
    if (($new != '') && ($new != $old)) {
      update_post_meta($post_id, $this->id, $new);
    } /*elseif ($new == '') {
      delete_post_meta($post_id, $this-> id);
    }*/
  }
}
