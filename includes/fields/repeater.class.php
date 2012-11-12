<?php
class ForemanRepeaterField extends ForemanField {
  public $fields = array();
  public $sortable = false;
  public $singular = false;

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/repeater.php');
    $this->fields = $args['fields'];
    if (isset($args['sortable'])) $this->sortable = $args['sortable'];
    if (isset($args['singular'])) {
      $this->singular = $args['singular'];
    } else {
      $this->singular = $this->name;
    }
  }

  function validate($value) {
    $db_version = array();
    foreach ($value as $val) {
      foreach ($this->fields as $field) {
        if (isset($val[$field->id])) {
          $val[$field->id] = $field->validate($val[$field->id]);
        }
      }
      $db_version[] = $val;
    }
    return $db_version;
  }
}
