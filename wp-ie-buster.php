<?php
/*
Plugin Name: WP IE Buster
Plugin URI: https://wordpress.org/plugins/wp-ie-buster/
Description: Display a popup to prompt IE users Chrome
Version: 1.4.1
Author: Qrac
Author URI: https://qrac.jp
Text Domain: wp-ie-buster
Domain Path: /languages
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

require_once( 'includes/class-wp-ie-buster.php' );
require_once( 'includes/admin/class-wp-ie-buster-admin.php' );

function wp_ie_buster() {
  new Wp_Ie_Buster();
}

wp_ie_buster();
