<?php
class ForemanTextField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/text.php');
    $this->widget_template_path = foreman_template_path('fields/widget/text.php');
  }
}
