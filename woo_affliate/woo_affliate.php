<?php

/**
 * Plugin Name: woo_affliate
 * Plugin URI: https://www.yourwebsiteurl.com/
 * Description: This is the very first plugin I ever created.
 * Version: 1.0
 * Author: WOO_AFFLIATE
 * Author URI: http://yourwebsiteurl.com/
 **/

defined('ABSPATH') or die('Hey, you can\t access this file, you silly human!');

if (is_admin()) {
  new Woo_Affliate();
}

class Woo_Affliate
{
  public $plugin_path;
  public $plugin_url;

  public function __construct()
  {
    $this->plugin_path = plugin_dir_path(dirname(__FILE__, 1)) . 'woo_affliate';
    $this->plugin_url = plugin_dir_url(dirname(__FILE__)) . 'woo_affliate';
    add_action('admin_menu', array($this, 'themeslug_enqueue_style'));
    add_action('admin_menu', array($this, 'add_menu_option'));
  }

  function themeslug_enqueue_style()
  {
    wp_enqueue_style('add_affliate_style', $this->plugin_url . '/assets/styles/affliate-styles.css');
    wp_enqueue_script('add_affliate_script', $this->plugin_url . '/assets/scripts/affliate-scripts.js');
  }

  public function add_menu_option()
  {
    $this->plugin_option();
  }

  public function plugin_option()
  {
    add_menu_page('Hoa Hồng', 'Hoa Hồng', 'manage_options', 'hoa-hong',  array($this, 'admin_template'));
  }

  function admin_template()
  {
    return require_once("$this->plugin_path/templates/admin.php");
  }
}
function plugin_setup_db()
{
  // Function change serialized
  set_time_limit(-1);
  global $wpdb;
  try {
    if (!function_exists('dbDelta')) {
      require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }
    $table_name = $wpdb->prefix . 'users'; // Assuming the table has a prefix

    // Check if the column exists
    if ($wpdb->get_var("SHOW COLUMNS FROM $table_name LIKE 'user_parent'") !== 'user_parent') {
      $charset_collate = $wpdb->get_charset_collate();
      // If the column doesn't exist, add it
      $sql = "ALTER TABLE $table_name ADD COLUMN user_parent INT";
      $wpdb->query($sql);
    }



    $ptbd_table_name = $wpdb->prefix . 'woo_history_user_commission';
    if ($wpdb->get_var("SHOW TABLES LIKE '" . $ptbd_table_name . "'") != $ptbd_table_name) {

      $sql  = 'CREATE TABLE ' . $ptbd_table_name . '(
          id BIGINT AUTO_INCREMENT,
          user_id BIGINT NOT NULL,
          total_order INT NOT NULL,
          order_id INT NULL,
          commission INT NOT NULL,
          minimum_spending INT  NULL,
          status INT DEFAULT 1, 
          create_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  ,

                  PRIMARY KEY(id))';
      //status =1 (them) =2  (tru)
      dbDelta($sql);
    }
  } catch (\Exception $ex) {
  }
}

function active_plugin()
{
  flush_rewrite_rules();
  plugin_setup_db();
}

register_activation_hook(__FILE__, 'active_plugin');