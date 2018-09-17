<?php
/*
Plugin Name: IE Buster
Plugin URI: https://ie-buster.qranoko.jp
Description: IE ユーザーに Chrome を促す 1.5KB のポップアップ JS
Version: 0.0.1
Author: Qrac
Author URI: https://qrac.jp
License: GPLv2 or later
*/

function add_ie_buster_files() {
  if ( !is_admin() ) {
    wp_enqueue_script( 'ie-buster', plugin_dir_url(__FILE__) . 'ie-buster.min.js', '', '', true );
  }
}
add_action('wp_enqueue_scripts', 'add_ie_buster_files', 1);