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

    self::$default_main_text = __( 'ご利用のインターネットブラウザは推奨環境ではありません。Webサイトの動作が保証できませんので、最新の Google Chrome をご利用ください。', $this->plugin_name );
    self::$default_link_text = __( 'ダウンロードページへ', $this->plugin_name );
    self::$default_url       = 'https://www.google.com/chrome/';

    if ( is_admin() ) {
      $admin = new Wp_Ie_Buster_Admin( $this->plugin_name );
    }

    add_action( 'wp_footer', array( $this, 'wp_ie_buster_app_print' ) );
  }

  public function wp_ie_buster_app_print() {
    global $is_IE;
    if ( $is_IE ) {
      $options   = get_option( $this->plugin_name );
      $main_text = ( ! empty( $options['main_text'] ) ) ? $options['main_text'] : self::$default_main_text;
      $link_text = ( ! empty( $options['link_text'] ) ) ? $options['link_text'] : self::$default_link_text;
      $url       = ( ! empty( $options['url'] ) ) ? $options['url'] : self::$default_url;
      echo '
    }
    <div id="ie-buster-app" style="position: fixed; top: 0px; left: 0; width: 100%; padding: 16px; box-sizing: border-box; z-index: 999999;">
      <div style="position: relative; width: 100%; max-width:866px; margin: 0 auto; padding: 16px 20px; background-color: #fff; box-shadow: rgba(0, 0, 0, 0.4) 0px 0px 5px 0px; box-sizing: border-box; font-family: SegoeUI, Meiryo, sans-serif;">
        <p style="display: block; float: left; width: 100%; max-width: 664px; margin: 0; color: #000; font-size: 14px; font-weight: 400; line-height: 1.5;">' . esc_html( $main_text ) . '</p>
        <a style="display: block; float: right; height: 36px; width: 154px; padding: 0 16px; background-color: rgb(0, 120, 212); box-sizing: border-box; color: #fff; font-size: 12px; font-weight: 400; line-height: 36px; text-align: center; text-decoration: none; white-space: nowrap;" href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $link_text ) . '</a>
        <div style="clear: both;"></div>
      </div>
    </div>
  ';
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
