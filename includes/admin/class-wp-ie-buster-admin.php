<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

class Wp_Ie_Buster_Admin {

  private $plugin_name;
  private $option_name;

  public function __construct( $plugin_name ) {
    $this->plugin_name = $plugin_name;
    $this->option_name = $plugin_name;

    add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
  }

  public function plugins_loaded() {
    $this->options = get_option( $this->option_name );

    add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    add_action( 'admin_init', array( $this, 'admin_init' ) );
  }

  public function admin_menu() {
    add_options_page(
      __( 'WP IE Buster', 'wp-ie-buster' ),
      __( 'WP IE Buster', 'wp-ie-buster' ),
      'manage_options',
      $this->plugin_name . '-settings',
      [ $this, 'display' ]
    );
  }

  function admin_init() {
    register_setting(
      $this->plugin_name,
      $this->option_name
    );
    add_settings_section(
      'basic_settings',
      __( 'Basic Settings', 'wp-ie-buster' ),
      null,
      $this->plugin_name
    );
    add_settings_field(
      'main_text',
      __( 'Main text', 'wp-ie-buster' ),
      [ $this, 'main_text_callback' ],
      $this->plugin_name,
      'basic_settings'
    );
    add_settings_field(
      'link_text',
      __( 'Link text', 'wp-ie-buster' ),
      [ $this, 'link_text_callback' ],
      $this->plugin_name,
      'basic_settings'
    );
    add_settings_field(
      'url',
      __( 'URL', 'wp-ie-buster' ),
      [ $this, 'url_callback' ],
      $this->plugin_name,
      'basic_settings'
    );
    add_settings_field(
      'debug_mode',
      __( 'Debug Mode', 'wp-ie-buster' ),
      [ $this, 'debug_mode_callback' ],
      $this->plugin_name,
      'basic_settings'
    );
  }

  public function main_text_callback() {
    $main_text = isset( $this->options['main_text'] ) ? $this->options['main_text'] : '';
    ?>
    <input
      name="<?php echo $this->option_name; ?>[main_text]"
      type="text"
      id="main_text"
      placeholder="<?php echo esc_attr( Wp_Ie_Buster::get_default_main_text() ); ?>"
      value="<?php echo esc_attr( $main_text ); ?>"
      class="regular-text"
    />
    <?php
  }

  public function link_text_callback() {
    $link_text = isset( $this->options['link_text'] ) ? $this->options['link_text'] : '';
    ?>
    <input
      name="<?php echo $this->option_name; ?>[link_text]"
      type="text"
      id="link_text"
      placeholder="<?php echo esc_attr( Wp_Ie_Buster::get_default_link_text() ); ?>"
      value="<?php echo esc_attr( $link_text ); ?>"
      class="regular-text"
    />
    <?php
  }

  public function url_callback() {
    $url = isset( $this->options['url'] ) ? $this->options['url'] : '';
    ?>
    <input
      name="<?php echo $this->option_name; ?>[url]"
      type="text"
      id="url"
      placeholder="<?php echo esc_attr( Wp_Ie_Buster::get_default_url() ); ?>"
      value="<?php echo esc_attr( $url ); ?>"
      class="regular-text"
    />
    <?php
  }

  public function debug_mode_callback() {
    $debug_mode = isset( $this->options['debug_mode'] ) ? $this->options['debug_mode'] : '';
    ?>
    <input
      name="<?php echo $this->option_name; ?>[debug_mode]"
      type="checkbox"
      id="debug_mode"
      value="1"
      <?php checked( '1', $debug_mode ); ?>
    /> <?php echo __( 'Displayed in all browsers for logged-in users', 'wp-ie-buster' ); ?>
    <?php
  }

  function display() {
    ?>
    <form action='options.php' method='post'>
      <h1><?php _e( 'WP IE Buster', 'wp-ie-buster' ); ?></h1>
      <?php
      settings_fields( $this->plugin_name );
      do_settings_sections( $this->plugin_name );
      submit_button();
      ?>
    </form>
    <?php
  }
}
