<?php
class ForemanRadioField extends ForemanField {
  public $options = array();
  public $inline = false;

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/radio.php');
    $this->widget_template_path = foreman_template_path('fields/widget/radio.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/radio.php');
    $this->options = $args['options'];
    if (isset($args['inline'])) $this->inline = $args['inline'];
  }

  function validate($value) {
    $is_valid = false;
    foreach ($this->options as $option) {
      if ($option['value'] == $value) $is_valid = true;
    }
    if ($is_valid) return $value;
    if (!$is_valid) return '';
  }
}


