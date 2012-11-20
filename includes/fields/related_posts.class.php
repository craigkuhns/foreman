<?php
class ForemanRelatedPostsField extends ForemanField {
  public $options = array();

  function __construct($args = array()) {
    parent::__construct($args);
    $this->template_path = foreman_template_path('fields/related_posts.php');
    $this->widget_template_path = foreman_template_path('fields/widget/related_posts.php');
    $this->taxonomy_template_path = foreman_template_path('fields/taxonomy/related_posts.php');
    $this->options = $args['options'];
  }

  function validate($value) {
    //$is_valid = false;
    //foreach ($this->options as $option) {
    //  if ($option['value'] == $value) $is_valid = true;
    //}
    //if ($is_valid) return $value;
    //if (!$is_valid) return '';
    return $value;
  }
}

