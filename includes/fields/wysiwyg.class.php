<?php
class ForemanWysiwygField extends ForemanField {
  public $options = array();

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/wysiwyg.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/wysiwyg.php');
    if (isset($args['options'])) $this->options = $args['options'];
  }

  // TODO: Find out root cause of slashes being added to taxonomy pages and fix it to get rid of
  // need for double stripslashes hack.
  function save_for_taxonomy($new, $old, $term_id) {
    if (($new != '') && ($new != $old)) {
      foreman_update_tax_meta($term_id, $this->id, stripslashes(stripslashes($new)));
    }
  }
}