<?php
class ForemanTextareaCodeField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/textarea_code.php');
    $this->widget_template_path = foreman_template_path('fields/widget/textarea_code.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/textarea_code.php');
  }

  function validate($value) {
    return htmlspecialchars_decode($value);
  }
}

