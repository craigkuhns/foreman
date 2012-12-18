<?php
/*
Plugin Name: Foreman
Plugin URI: http://craigkuhns.com
Description: A wordpress plugin that adds a framework to rapidly build wordpress sites that are more like applications.
Version: 1.0
Author: Craig Kuhns
Author URI: http://craigkuhns.com
*/

define('FOREMAN_PATH', plugin_dir_path(__FILE__));
define('FOREMAN_URL', plugins_url('/', __FILE__));

add_action("activated_plugin", "load_foreman_first");
function load_foreman_first() {
	// ensure path to this file is via main wp plugin path
	$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
	$this_plugin = plugin_basename(trim($wp_path_to_this_file));
	$active_plugins = get_option('active_plugins');
	$this_plugin_key = array_search($this_plugin, $active_plugins);
	if ($this_plugin_key) { // if it's 0 it's the first plugin already, no need to continue
		array_splice($active_plugins, $this_plugin_key, 1);
		array_unshift($active_plugins, $this_plugin);
		update_option('active_plugins', $active_plugins);
	}
}

register_activation_hook(__FILE__, 'foreman_db_install');
function foreman_db_install() {
  global $wpdb;
  $foreman_db_version = "1.0";
  $table_name = $wpdb->prefix."termmeta";
  $sql = "CREATE TABLE $table_name (
    meta_id bigint(20) unsigned NOT NULL auto_increment,
    term_id bigint(20) unsigned NOT NULL default '0',
    meta_key varchar(255) default NULL,
    meta_value longtext,
    PRIMARY KEY  (meta_id),
    KEY term_id (term_id),
    KEY meta_key (meta_key)
  );";
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql);
  add_option("foreman_db_version", $foreman_db_version);
}

require_once('includes/core.php');
require_once('includes/helpers.php');
require_once('includes/ajax.php');
require_once('includes/post_type.class.php');
require_once('includes/taxonomy.class.php');
require_once('includes/widget.class.php');
require_once('includes/metabox.class.php');
require_once('includes/field.class.php');
require_once('includes/fields/text.class.php');
require_once('includes/fields/text_small.class.php');
require_once('includes/fields/text_medium.class.php');
require_once('includes/fields/textarea.class.php');
require_once('includes/fields/textarea_small.class.php');
require_once('includes/fields/textarea_code.class.php');
require_once('includes/fields/select.class.php');
require_once('includes/fields/date.class.php');
require_once('includes/fields/date_timestamp.class.php');
require_once('includes/fields/datetime.class.php');
require_once('includes/fields/datetime_timestamp.class.php');
require_once('includes/fields/money.class.php');
require_once('includes/fields/radio.class.php');
require_once('includes/fields/checkbox.class.php');
require_once('includes/fields/boolean.class.php');
require_once('includes/fields/wysiwyg.class.php');
require_once('includes/fields/file.class.php');
require_once('includes/fields/colorpicker.class.php');
require_once('includes/fields/repeater.class.php');
require_once('includes/fields/table_repeater.class.php');
require_once('includes/fields/related_posts.class.php');

Foreman::init();