<?php
class ForemanDateField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/date.php');
    $this->widget_template_path = foreman_template_path('fields/widget/date.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/date.php');
  }
}
