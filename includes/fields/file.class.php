<?php
class ForemanFileField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/file.php');
    $this->widget_template_path = foreman_template_path('fields/widget/file.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/file.php');
  }
}

