<?php
class ForemanMetabox {
  public $id = '';
  public $title = '';
  public $context = 'advanced';
  public $priority = 'default';
  public $status_permissions = array(
    'visible' => 'all',
    'editable' => 'all'
  );

  public function __construct() {
    add_action('save_post', array(&$this, 'save'));
  }

  public function fields() {
    return array();
  }

  function render() {
    global $post;
    echo '<input type="hidden" name="wp_foreman_nonce" value="', wp_create_nonce( basename(__FILE__) ), '" />';
    echo '<ul class="foreman-field-list">';
    foreach ($this->fields() as $field) {
      $value = get_post_meta($post->ID, $field->id, true);
      echo '<li class="cf">';
      $field->render($value, $this->is_editable_for_status($status));
      echo '</li>';
    }
    echo '</ul>';
  }

  function is_visible_for_status($status) {
    if ($this->status_permissions['visible'] == 'all') return true;
    if ($this->status_permissions['visible'] == 'none') return false;
    if (is_array($this->status_permissions['visible'])) return in_array($status, $this->status_permissions['visible']);
  }

  function is_editable_for_status($status) {
    if ($this->status_permissions['editable'] == 'all') return true;
    if ($this->status_permissions['editable'] == 'none') return false;
    if (is_array($this->status_permissions['editable'])) return in_array($status, $this->status_permissions['visible']);
  }  

  function save($post_id) {
    if (!isset($_POST['wp_foreman_nonce']) || !wp_verify_nonce($_POST['wp_foreman_nonce'], basename(__FILE__))) {
      return $post_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return $post_id;
    }
    if ($_POST['post_type'] == 'page') {
      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      }
    } else {
      if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
      }
    }
    foreach ($this->fields() as $field) {
      $old = get_post_meta($post_id, $field->id, true);
      $new = isset($_POST[$field->id]) ? $_POST[$field->id] : null;

      $new = $field->validate($new);
      $field->save_for_metabox($new, $old, $post_id);
    }
  }
}
