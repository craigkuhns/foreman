<?php
class ForemanDateTimestampField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/date_timestamp.php');
    $this->widget_template_path = foreman_template_path('fields/widget/date_timestamp.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/date_timestamp.php');
  }

  function validate($value) {
    if (!empty($value)) {
      return strtotime($value);
    } else {
      return '';
    }
  }
}

