<?php
class ForemanCheckboxField extends ForemanField {
  public $options = array();
  public $inline = false;

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/checkbox.php');
    $this->widget_template_path = foreman_template_path('fields/widget/checkbox.php');

    $this->options = $args['options'];
    if (isset($args['inline'])) $this->inline = $args['inline'];
  }
}



