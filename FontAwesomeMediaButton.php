<?php
/*
Plugin Name: Font Awesome Button
Description: Add media button to wordprss editor for choosing font awesome icon
Version: 1.0.0
Author: Khaer Ansori
*/

class FontAwesomeMediaButton
{
  private static $instance;
	const VERSION = '4.5';

  private static function has_instance() {
    return isset( self::$instance ) && null != self::$instance;
  }

  public static function get_instance() {
    if ( ! self::has_instance() ) {
      self::$instance = new FontAwesomeMediaButton;
    }

    return self::$instance;
  }

  public static function setup() {
    self::get_instance();
  }

  protected function __construct() {
    if ( ! self::has_instance() ) {
      $this->init();
    }
  }

  public function init() {
    add_action( 'init', array( $this, 'register_plugin_styles' ) );
    add_action( 'init', array( $this, 'register_plugin_scripts' ) );
    add_action( 'media_buttons', array($this, 'register_media_button'), 15);
    add_shortcode( 'fa-icon', array( $this, 'setup_shortcode' ) );
  }

  public function register_plugin_styles() {
		wp_enqueue_style( 'font-awesome-styles', plugins_url( 'css/font-awesome.min.css', __FILE__ ), array(), self::VERSION );
    wp_enqueue_style( 'simplemodal', plugins_url('css/jquery.simplemodal-1.4.4.css', __FILE__), array(), self::VERSION);
	}

  public function register_plugin_scripts()
  {
    wp_enqueue_script('jquery');
    wp_enqueue_script('simplemodal', plugins_url('js/jquery.simplemodal-1.4.4.js', __FILE__), array('jquery'));
    wp_enqueue_script('font-awesome-media-button', plugins_url('js/FontAwesomeMediaButton.js', __FILE__), array('simplemodal'));
  }

  public function register_media_button()
  {
    $html = '<button type="button" id="font-awesome-media-button" class="button" data-editor="content">';
    $html .= '<i class="fa fa-flag"><!-- flag --></i> Add Font Awesome Icon</button>';

    echo $html;
  }

  public function setup_shortcode($params)
  {
    return '<i class="fa fa-' . esc_attr( $params['icon'] ) . '"></i>';
  }
}
FontAwesomeMediaButton::setup();
 ?>
