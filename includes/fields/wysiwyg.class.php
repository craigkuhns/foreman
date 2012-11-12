<?php
class ForemanWysiwygField extends ForemanField {
  public $options = array();

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/wysiwyg.php');
    if (isset($args['options'])) $this->options = $args['options'];
  }
}


