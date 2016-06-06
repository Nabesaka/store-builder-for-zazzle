<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
/**
 *
 * Plugin Name: Store Builder For Zazzle
 * Plugin URI: http://return-true.com
 * Author: Paul Robinson
 * Author URI: http://return-true.com
 * Version: 1.0
 * Description: A plugin that parses the Zazzle Feed of a Zazzle user and displays it in a customizable way.
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: store-builder
 **/

// Require CodeStar Framework
require_once plugin_dir_path( __FILE__ ) . 'lib/csf/cs-framework.php';

// Require CodeStar Settings
require_once plugin_dir_path( __FILE__ ) . 'lib/csf-settings.php';
// Require CodeStar Options
require_once plugin_dir_path( __FILE__ ) . 'lib/csf-options.php';

// Main ZSB Class
Class Zsb_Main {

  public function __construct()
  {

  }

}

new Zsb_Main;
