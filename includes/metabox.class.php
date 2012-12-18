<?php
class ForemanMetabox {
  public $id = '';
  public $title = '';
  public $context = 'advanced';
  public $priority = 'default';
  public $post_types = array();
  public $_fields = array();
  public $status_permissions = array(
    'visible' => 'all',
    'editable' => 'all'
  );

  public function __construct() {
  }

  public function add_fields($fields) {
    foreach ($fields as $field) {
      $this->add_field($field);
    }
  }

  public function add_field($field) {
    $this->_fields[$field->id] = $field;
  }
}