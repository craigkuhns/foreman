<?php
class Foreman {
  static protected $_post_types;
  static protected $_meta_boxes;
  static protected $_taxonomies;
  static protected $_widgets;


  static public function init() {
    add_action('admin_enqueue_scripts', array('Foreman', 'load_assets'));
    add_action('widgets_init', array('Foreman', 'load_widgets'));
    if (isset($_GET['foreman_force_send']) && $_GET['foreman_force_send'] == true) {
      add_filter('attribute_escape', array('Foreman', 'set_insert_button_label'), 10, 2);
    }
  }

  static public function register_meta_box($meta_box) {
    self::$_meta_boxes[$meta_box->id] = $meta_box;
  }

  static public function register_post_type($post_type) {
    self::$_post_types[$post_type->name] = $post_type;
  }

  static public function register_taxonomy($taxonomy) {
    self::$_taxonomies[$taxonomy->name] = $taxonomy;
  }

  static public function register_widget($widget_class) {
    self::$_widgets[] = $widget_class;
  }

  static public function load_widgets() {
    if (isset(self::$_widgets) && is_array(self::$_widgets) && (!empty(self::$_widgets))) {
      foreach (self::$_widgets as $widget_class) {
        register_widget($widget_class);
      }
    }
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
	  wp_enqueue_script('foreman-js');
  }

  static public function set_insert_button_label($safe_text, $text) {
    return str_replace(__('Insert into Post'), $_GET['foreman_send_label'], $text);
  }
}
