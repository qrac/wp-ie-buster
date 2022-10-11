<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Wp_Ie_Buster {

  private $plugin_name;

  private static $default_main_text;
  private static $default_link_text;
  private static $default_url;

  public function __construct() {
    $this->plugin_name = 'wp-ie-buster';

    $this->load_plugin_textdomain();

    self::$default_main_text = __( 'Your Internet browser is not recommended environment. We can not guarantee the behavior of the website, so please use the latest Google Chrome.', 'wp-ie-buster' );
    self::$default_link_text = __( 'Go to download', 'wp-ie-buster' );
    self::$default_url       = 'https://www.google.com/chrome/';

    if ( is_admin() ) {
      $admin = new Wp_Ie_Buster_Admin( $this->plugin_name );
    }

    add_action( 'wp_footer', array( $this, 'wp_ie_buster_app_print' ) );
  }

  public function load_plugin_textdomain() {
    load_plugin_textdomain(
      $this->plugin_name,
      false,
      dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
    );
  }

  public function wp_ie_buster_app_print() {
    global $is_IE;
    $options     = get_option( $this->plugin_name );

    $debug_mode  = empty($options['debug_mode']) ? '' : $options['debug_mode'];
    $is_debug_mode  = $debug_mode && is_user_logged_in() ? true : false;

    if ( $is_IE || $debug_mode ) {
      $main_text = ( ! empty( $options['main_text'] ) ) ? $options['main_text'] : self::$default_main_text;
      $link_text = ( ! empty( $options['link_text'] ) ) ? $options['link_text'] : self::$default_link_text;
      $url       = ( ! empty( $options['url'] ) ) ? $options['url'] : self::$default_url;
      $protocols = array( 'http', 'https', 'microsoft-edge' );
      $target    = preg_match( '/^microsoft-edge/', $url) ? '_self' : '_blank';
      echo '
    <div id="ie-buster-app" style="position: fixed; top: 0px; left: 0; width: 100%; padding: 16px; box-sizing: border-box; z-index: 999999;">
      <div style="position: relative; width: 100%; max-width:866px; margin: 0 auto; padding: 16px 20px; background-color: #fff; box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 5px 0px; box-sizing: border-box; font-family: SegoeUI, Meiryo, sans-serif;">
        <p style="display: block; float: left; width: 100%; max-width: 664px; margin: 0; color: #000; font-size: 14px; font-weight: 400; line-height: 1.5;">' . esc_html( __( $main_text ) ) . '</p>
        <a style="display: block; float: right; height: 36px; width: 154px; padding: 0 16px; background-color: rgb(0, 120, 212); box-sizing: border-box; color: #fff; font-size: 12px; font-weight: 400; line-height: 36px; text-align: center; text-decoration: none; white-space: nowrap;" href="' . esc_url( $url, $protocols ) . '" target="'. $target .'" rel="noopener noreferrer">' . esc_html( __( $link_text ) ) . '</a>
        <div style="clear: both;"></div>
      </div>
    </div>
  ';
    }

    if ( $is_IE ) {
      echo '<style>@supports not (-ms-high-contrast: none) {#ie-buster-app { display: none; }}</style>';
    }
  }

  public static function get_default_main_text() {
    return self::$default_main_text;
  }

  public static function get_default_link_text() {
    return self::$default_link_text;
  }

  public static function get_default_url() {
    return self::$default_url;
  }
}
