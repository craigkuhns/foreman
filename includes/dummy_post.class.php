<?php
class ForemanDummyPost {
  public $post_type;
  public $post_status;
  public function __construct($attrs) {
    $this->post_type = $attrs['post_type'];
    $this->post_status = $attrs['post_status'];
  }
}