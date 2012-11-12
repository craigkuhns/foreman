<?php
class ForemanDateTimeTimestampField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/datetime_timestamp.php');
    $this->widget_template_path = foreman_template_path('fields/widget/datetime_timestamp.php');
  }

  function validate($value) {
    if (!empty($value)) {
      return strtotime($value);
    } else {
      return '';
    }
  }
}


