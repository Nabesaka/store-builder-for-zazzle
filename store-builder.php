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
// Require CodeStar Metabox -- nulls out defaults
require_once plugin_dir_path( __FILE__ ) . '/lib/csf-metabox.php';
// Require CodeStar Taxonomy -- nulls out defaults
require_once plugin_dir_path( __FILE__ ) . '/lib/csf-taxonomy.php';
// Require CodeStar Shortcode -- nulls out defaults
require_once plugin_dir_path( __FILE__ ) . '/lib/csf-shortcode.php';

// Include ZSB Error Class to show error messages
require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-error.php';

// Include ZSB Parser Class to parse Feed into a product Class
require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-product.php';

require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-products.php';


// Main ZSB Class
Class Zsb_Main {

  // ZAZZLE FEED URL
  private $API_URL = 'http://feed.zazzle.com/';

  // ZAZZLE FEED SUFFIX
  private $API_SUFFIX = 'feed';

  public function __construct()
  {
    // Do some compatibility checking
    add_action( 'admin_init', array( $this, 'check_compat' ) );

    // Get the feed from Zazzle
    add_shortcode( 'store-builder', array( $this, 'build_shortcode' ) );

  }

  public function check_compat()
  {

    // Check version of WordPress
    if( version_compare( get_bloginfo('version'), '3.0' ) < 0 ) {
      Zsb_Error::incompatible_wp();
      deactivate_plugins( plugin_basename( __FILE__ ) );
    }

    // Check version of PHP
    if( version_compare( PHP_VERSION, '5.3' ) < 0 ) {
      Zsb_Error::incompatible_php();
      deactivate_plugins( plugin_basename( __FILE__ ) );
    }

  }

  public function build_shortcode( $atts )
  {

    $atts = shortcode_atts(array(
      'referral_id'           => cs_get_option( 'zsb_designer_referral_id' ),
      'designer_id'           => cs_get_option( 'zsb_designer_designer_id' ),
      'products_per_page'     => cs_get_option( 'zsb_products_per_page' ),
      'sort_by'               => cs_get_option( 'zsb_products_sort' ),
      'image_size'            => cs_get_option( 'zsb_products_image_size' ),
      'link_product'          => cs_get_option( 'zsb_products_zazzle_link' ),
      'alt_link'              => cs_get_option( 'zsb_products_alt_link_content' ),
      'img_bg'                => cs_get_option( 'zsb_products_img_bg_content' ),
      'keyword_filter'        => cs_get_option( 'zsb_filter_keywords' ),
      'department_filter'     => cs_get_option( 'zsb_filter_department' ),
      'product_line_filter'   => cs_get_option( 'zsb_filter_product_line' ),
      'show_product_title'    => cs_get_option( 'zsb_display_title' ),
      'show_product_author'   => cs_get_option( 'zsb_display_author' ),
      'show_product_desc'     => cs_get_option( 'zsb_display_description' ),
      'show_product_price'    => cs_get_option( 'zsb_display_price' ),
    ), $atts);

    $feed = $this->get_feed( $atts );

    $products = new Zsb_Products( $feed );

    if($products->getError())
      Zsb_Error::public_error('notice notice-error', 'There was a problem converting the Feed data to products. This is normally caused by there being no products returned.');

  }

  public function get_feed( $atts )
  {

    $url = $this->API_URL . $atts['designer_id'] . '/' . $this->API_SUFFIX;

    if( $cache = get_transient( 'zsb_feed_cache' ) )
          return $cache;

    $feed = wp_remote_get($url, array(
      'timeout' => 20,
      'redirection' => 0,
      'user-agent' => 'Store Builder Plugin for WordPress (By Paul Robinson/Return True)',
    ));

    if( is_wp_error( $feed ) ) {
      Zsb_Error::public_error('notice notice-error', 'There was an unknown error fetching the feed.');
    }

    set_transient( 'zsb_feed_cache', $feed['body'], 3600);

    return $feed['body'];

  }

}

new Zsb_Main;
