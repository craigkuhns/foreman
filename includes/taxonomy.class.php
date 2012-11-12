<?php
class ForemanTaxonomy {
  public $name = '';
  protected $_post_types = '';
  protected $_taxonomy_config = array();

  function __construct() {
    add_action('init', array(&$this, 'register_taxonomy'), 0);
  }

  function register_taxonomy() {
    register_taxonomy($this->name, $this->_post_types, $this->_taxonomy_config);
  }

  public function set_taxonomy_config($name, $post_types, $config) {
    $this->name = $name;
    $this->_post_types = $post_types;
    $this->_taxonomy_config = $config;
  }
}