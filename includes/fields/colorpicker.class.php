<?php
class ForemanColorPickerField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/colorpicker.php');
    $this->widget_template_path = foreman_template_path('fields/widget/colorpicker.php');
  }

  function validate($value) {
    return str_replace('#', '', $value);
  }
}

