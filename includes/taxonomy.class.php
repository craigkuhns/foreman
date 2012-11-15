<?php
class ForemanTaxonomy {
  public $name = '';
  protected $_post_types = '';
  protected $_taxonomy_config = array();
  protected $_fields = array();
  protected $_meta_boxes = array();

  function __construct() {
    add_action('init', array(&$this, 'register_taxonomy'), 0);
    add_action("{$this->name}_edit_form_fields", array(&$this, 'render_fields'));
    add_action("edited_{$this->name}", array(&$this, 'save'), 10, 2);
  }

  function register_taxonomy() {
    register_taxonomy($this->name, $this->_post_types, $this->_taxonomy_config);
  }

  public function set_taxonomy_config($name, $post_types, $config) {
    $this->name = $name;
    $this->_post_types = $post_types;
    $this->_taxonomy_config = $config;
  }

  public function add_fields($fields) {
    foreach ($fields as $field) {
      $this->add_field($field);
    }
  }

  public function add_meta_boxes($meta_boxes) {
    foreach ($meta_boxes as $id => $meta_box) {
      $this->add_meta_box($id, $meta_box);
    }
  }

  public function add_meta_box($id, $meta_box) {
    if (!isset($meta_box['visible'])) $meta_box['visible'] = 'all';
    if (!isset($meta_box['editable'])) $meta_box['editable'] = 'all';
    $this->_meta_boxes[$id] = $meta_box;
  }

  public function add_field($field) {
    $this->_fields[$field->id] = $field;
  }

  public function render_fields() {
    if (!empty($this->_fields)) {
      echo '<input type="hidden" name="wp_foreman_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

      foreach ($this->_meta_boxes as $id => $meta_box) {
        echo "<tr><td colspan='2'>";
          echo "<div id='poststuff' style='width: 96%;'>";
          echo "<div id='$id' class='postbox'>";
            echo "<h3 class='hndle'><span>".$meta_box['title']."</span></h3>";
            echo "<div class='inside'><ul class='foreman-field-list'>";
              foreach ($meta_box['fields'] as $field_id) {
                $field = $this->_fields[$field_id];
                $value = foreman_get_tax_meta($_GET['tag_ID'], $field->id);
                echo '<li class="cf">';
                  $field->render($value, true);
                echo '</li>';
              }
            echo "</ul></div>";
          echo "</div>";
          echo "</div>";
        echo "</td></tr>";
      }
    }
  }

  public function save($term_id) {
    if (!isset($_POST['wp_foreman_nonce']) || !wp_verify_nonce($_POST['wp_foreman_nonce'], basename(__FILE__))) {
      return $term_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return $term_id;
    }

    if ($_POST['taxonomy'] == $this->name) {
      foreach ($this->_fields as $field) {
        if (isset($_POST[$field->id])) {
          $old = foreman_get_tax_meta($term_id, $field->id);
          $new = isset($_POST[$field->id]) ? $_POST[$field->id] : null;

          $new = $field->validate($new);
          $field->save_for_taxonomy($new, $old, $term_id);
        }
      }
    }
  }
}