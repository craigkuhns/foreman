<?php
class ForemanTextMediumField extends ForemanField {
  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/text_medium.php');
    $this->widget_template_path = foreman_template_path('fields/widget/text_medium.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/text_medium.php');
  }
}
