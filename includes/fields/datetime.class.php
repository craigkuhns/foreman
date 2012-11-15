<?php
class ForemanDateTimeField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/datetime.php');
    $this->widget_template_path = foreman_template_path('fields/widget/datetime.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/datetime.php');
  }
}

