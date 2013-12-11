<?php
class Foreman {
  private static $post_types = array();
  private static $meta_boxes = array();
  private static $taxonomies = array();
  private static $widgets = array();

  static public function init() {
    self::register_termmeta_tables();


    add_action('init', array('Foreman', 'do_wp_init'));
    add_action('init', array('Foreman', 'register_post_types'));
    add_action('init', array('Foreman', 'register_taxonomies'));
    add_action('widgets_init', array('Foreman', 'register_widgets'));
    add_action('admin_enqueue_scripts', array('Foreman', 'load_assets'));
    add_action('add_meta_boxes', array('Foreman', 'add_meta_boxes'));
    add_action('save_post', array('Foreman', 'save_post'));
    add_action('transition_post_status', array('Foreman', 'transition_post_status'),10, 3);
    add_action('admin_head', array('Foreman', 'replace_default_publish_box'), 100);

  }

  static public function register_termmeta_tables() {
    global $wpdb;
    array_push($wpdb->tables, 'termmeta');
    $wpdb->termmeta = $wpdb->prefix . 'termmeta';
  }

  static public function do_wp_init() {
    self::$post_types = apply_filters('foreman_post_types', self::$post_types);
    self::$meta_boxes = apply_filters('foreman_meta_boxes', self::$meta_boxes);
    self::$taxonomies = apply_filters('foreman_taxonomies', self::$taxonomies);
    self::register_post_types();
  }

  static public function load_assets() {
    wp_register_style('foreman-timepicker-css', FOREMAN_URL.'css/jquery.ui.timepicker.addon.css');
    wp_enqueue_style('foreman-timepicker-css');
    wp_register_style('foreman-jquery-ui-css', FOREMAN_URL.'css/jquery.ui.css');
    wp_enqueue_style('foreman-jquery-ui-css');
    wp_register_style('foreman-font-awesome', FOREMAN_URL.'css/font-awesome.css');
    wp_enqueue_style('foreman-font-awesome');
    wp_register_style('foreman-css', FOREMAN_URL.'css/foreman.css', array('thickbox', 'farbtastic'));
    wp_enqueue_style('foreman-css');

    wp_register_script('foreman-timepicker-js', FOREMAN_URL.'js/jquery.ui.timepicker.addon.js' );
    wp_enqueue_script('foreman-timepicker-js');
    wp_register_script('foreman-js', FOREMAN_URL.'js/foreman.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-slider', 'jquery-ui-widget', 'jquery-ui-mouse', 'jquery-ui-sortable', 'media-upload', 'thickbox', 'farbtastic'));
    $admin_page = (isset($_GET['page'])) ? $_GET['page'] : '';
    if (is_admin() && $admin_page != 'revslider') {
      wp_enqueue_script('foreman-js');
    }

    wp_enqueue_media();
  }

  static public function register_post_types() {
    foreach (self::$post_types as $name => $configuration) {
      register_post_type($name, $configuration);

      if (isset($configuration['statuses']) && is_array($configuration['statuses'])) {
        foreach ($configuration['statuses'] as $id => $label) {
          register_post_status($id, array(
            'public' => true,
            'label' => $label,
            'label_count' => _n_noop($label.' <span class="count">(%s)</span>', $label.' <span class="count">(%s)</span>')
          ));
        }
      }
    }
  }

  static public function register_taxonomies() {
    foreach (self::$taxonomies as $name => $configuration) {
      $config_for_registration = $configuration;
      unset($config_for_registration['post_type']);
      register_taxonomy($name, $configuration['post_type'], $config_for_registration);
      add_action($name."_edit_form_fields", array('Foreman', 'render_taxonomy_fields'), 10, 2);
      add_action("edited_".$name, array('Foreman', 'save_taxonomy'), 10, 2);
    }
  }

  static public function register_widgets() {
    global $wp_widget_factory;
    self::$widgets = apply_filters('foreman_widgets', self::$widgets);
    foreach (self::$widgets as $widget) {
      $widget_class_name = 'foreman_widget_'.$widget['id'];
      $class_definition = 'class '.$widget_class_name.' extends ForemanWidget {';
      $class_definition .= 'function __construct($settings) {';
      $class_definition .= 'parent::__construct($settings);';
      $class_definition .= '}';
      $class_definition .= '}';
      eval($class_definition);
      $wp_widget_factory->widgets[$widget_class_name] = new $widget_class_name($widget);
    }
  }

  static public function add_meta_boxes() {
    global $pagenow;
    if (in_array($pagenow, array('post.php', 'post-new.php'))) {
      $tmp_post = foreman_get_admin_post();
      foreach (self::$meta_boxes as $meta_box) {
        $post_types = (is_array($meta_box['post_type'])) ? $meta_box['post_type'] : array($meta_box['post_type']);
        foreach ($post_types as $post_type) {
          if (foreman_meta_box_visible_for_status($meta_box, foreman_current_post_status($tmp_post))) {
            if (
              (isset($meta_box['page_template']) && (get_post_meta($tmp_post->ID, '_wp_page_template', true) == $meta_box['page_template'])) ||
              (!isset($meta_box['page_template']))
            ) {
              add_meta_box($meta_box['id'], $meta_box['title'], array('Foreman', 'render_meta_box'), $post_type, $meta_box['context'], $meta_box['priority'], $meta_box);
            }
          }
        }
      }
    }
  }

  static public function render_taxonomy_fields($term, $name) {
    echo '<input type="hidden" name="wp_foreman_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';
    $taxonomy = self::$taxonomies[$name];
    foreach ($taxonomy['fields'] as $field) {
      echo '<tr '.foreman_taxonomy_field_wrapper_attributes($field).'>';
      do_action('foreman_render_'.$field['type'], 'taxonomy', $term, $field);
      echo '</tr>';
    }
  }

  static public function render_meta_box($post, $args) {
    $meta_box = $args['args'];
    $meta_box_fields_editable = foreman_meta_box_editable_for_status($meta_box, $post->post_status);

    echo '<input type="hidden" name="wp_foreman_nonce" value="', wp_create_nonce( basename(__FILE__) ), '" />';
    echo '<ul class="foreman-field-list">';
    foreach ($meta_box['fields'] as $field) {
      echo '<li '.foreman_field_wrapper_attributes($field).'>';
      do_action('foreman_render_'.$field['type'], 'meta_box', $post, $field, $meta_box_fields_editable);
      echo '</li>';
    }
    echo '</ul>';
  }

  static public function save_taxonomy($term_id) {
    if (!isset($_POST['wp_foreman_nonce']) || !wp_verify_nonce($_POST['wp_foreman_nonce'], basename(__FILE__))) {
      return $term_id;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
      return $term_id;
    }

    $taxonomy = self::$taxonomies[$_POST['taxonomy']];
    foreach ($taxonomy['fields'] as $field) {
      if (isset($_POST[$field['id']])) {
        $old = get_term_meta($term_id, $field['id'], true);
        $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : null;
        $new = apply_filters('foreman_validate_'.$field['type'], $new, $field);
        pretty_print_r($new);
        if (($new != '') && ($new != $old)) {
          update_term_meta($term_id, $field['id'], $new);
        }
      }
    }
  }

  public static function save_post($post_id) {
    global $post;
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
    foreach (self::$meta_boxes as $meta_box) {
      $post_types = (is_array($meta_box['post_type'])) ? $meta_box['post_type'] : array($meta_box['post_type']);
      if (in_array($post->post_type, $post_types)) {
        foreach ($meta_box['fields'] as $field) {
          if (isset($_POST[$field['id']])) {
            $old = get_post_meta($post->ID, $field['id'], true);
            $new = isset($_POST[$field['id']]) ? $_POST[$field['id']] : null;
            $new = apply_filters('foreman_validate_'.$field['type'], $new, $field);

            if (($new != '') && ($new != $old)) {
              update_post_meta($post_id, $field['id'], $new);
            }
          }
        }
      }
    }
  }

  public function render_post_submit_meta_box() {
    global $post;
    $post_type = $post->post_type;
    $post_type_object = get_post_type_object($post_type);
    $can_publish = current_user_can($post_type_object->cap->publish_posts);
    include FOREMAN_PATH.'/templates/post_submit_meta_box.php';
  }

  public function replace_default_publish_box() {
    global $post, $pagenow, $wp_meta_boxes;
    if (in_array($pagenow, array('post.php', 'post-new.php'))) {
      if (isset(self::$post_types[$post->post_type])) {
        $post_type = self::$post_types[$post->post_type];
        if (isset($post_type['statuses']) && is_array($post_type['statuses'])) {
          $wp_meta_boxes[$post->post_type]['side']['core']['submitdiv']['callback'] = array('Foreman', 'render_post_submit_meta_box');
        }
      }
    }
  }

  public function post_type_statuses($post) {
    if (isset(self::$post_types[$post->post_type]['statuses'])) {
      return self::$post_types[$post->post_type]['statuses'];
    } else {
      return array();
    }
  }

  public function post_type_transitions($post) {
    if (isset(self::$post_types[$post->post_type]['transitions'])) {
      return self::$post_types[$post->post_type]['transitions'];
    } else {
      return array();
    }
  }

  public function transition_post_status($new_status_id, $old_status_id, $post) {
    if ($new_status_id != $old_status_id) {
      $transitions = foreman_post_type_transitions($post);
      if (!empty($transitions) && isset($transitions[$old_status_id])) {
        foreach ($transitions[$old_status_id] as $possible_target) {
          if ($possible_target['to'] == $new_status_id && isset($possible_target['callback'])) {
            // This is a workaround because wordpress calls the transition hook before
            // the save_post hook fires meaning transitions happen before post meta
            // has a chance to be saved. Here I cache the transition info as post_meta
            // and then add a save_post action to run long after all the other save_post
            // actions have been called in order to actually call the user defined transition
            // function. This way all of the post_meta should be saved at the time the transition
            // function is called and it will have access to all of the newest post data.
            $impending_transition_data = array(
              'callback' => $possible_target['callback'],
              'new_status_id' => $new_status_id,
              'old_status_id' => $old_status_id,
            );
            update_post_meta($post->ID, '_foreman_impending_transition_data', $impending_transition_data);
            add_action('save_post', array('Foreman', 'post_type_run_transition_after_saved'), 100);
          }
        }
      }
    }
  }

  public function post_type_run_transition_after_saved($post_id) {

    global $post;
    $impending_transition_data = get_post_meta($post->ID, '_foreman_impending_transition_data', true);
    $callback = $impending_transition_data['callback'];
    $new_status_id = $impending_transition_data['new_status_id'];
    $old_status_id = $impending_transition_data['old_status_id'];
    call_user_func($callback, $new_status_id, $old_status_id, $post);
    delete_post_meta($post->ID, '_foreman_impending_transition_data');
  }
}