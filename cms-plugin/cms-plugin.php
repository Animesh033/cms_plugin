<?php
/*
Plugin Name: CMS for minimum wages
Plugin URI: 
Description: Showing the notifications based on input date
Version: 1.0.0
Author: Animesh
Author URI: 
*/

// Exit if accessed directly
if(!defined('ABSPATH')){
  exit;
}
// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/cms-scripts.php');
// Load Class
require_once(plugin_dir_path(__FILE__).'/includes/cms-class.php');
require_once(plugin_dir_path(__FILE__).'/includes/cms-class-getnoti.php');
require_once(plugin_dir_path(__FILE__).'/includes/cms-class-insert.php');