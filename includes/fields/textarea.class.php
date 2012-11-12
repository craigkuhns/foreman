<?php
class ForemanTextareaField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/textarea.php');
    $this->widget_template_path = foreman_template_path('fields/widget/textarea.php');
  }

  function validate($value) {
    return htmlspecialchars($value);
  }
}

