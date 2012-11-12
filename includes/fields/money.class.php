<?php
class ForemanMoneyField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/money.php');
    $this->widget_template_path = foreman_template_path('fields/widget/money.php');
  }

  function validate($value) {
    return number_format($value, 2);
  }
}

