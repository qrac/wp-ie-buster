<?php
/*
Plugin Name: WP IE Buster - Dev
Plugin URI: https://wordpress.org/plugins/wp-ie-buster/
Description: IE ユーザーに Chrome を促すポップアップを表示します（開発バージョン）
Version: 1.1.0
Author: Qrac
Author URI: https://qrac.jp
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
