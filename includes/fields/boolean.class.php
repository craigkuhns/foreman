<?php
class ForemanBooleanField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/boolean.php');
    $this->widget_template_path = foreman_template_path('fields/widget/boolean.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/boolean.php');
  }
}

