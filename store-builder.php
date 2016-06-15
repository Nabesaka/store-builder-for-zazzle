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
 *
 * IMPORTANT: Composer is used to manage dependencies but they are included in VCS
 **/

// Require Composer Autoloader
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

// Require CodeStar Framework
require_once plugin_dir_path( __FILE__ ) . 'lib/csf/cs-framework.php';

// Not using PSR-4 autoloading for these classes to keep things simple. May update it in the future.
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
// Include ZSB Product Class
require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-product.php';
// Include ZSB Products Class
require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-products.php';
// Include ZSB Template Parser
require_once plugin_dir_path( __FILE__ ) . '/lib/util/zsb-templates.php';


// Main ZSB Class
Class Zsb_Main {

  // ZAZZLE FEED URL
  private $API_URL = 'http://feed.zazzle.com/';

  // ZAZZLE FEED SUFFIX
  private $API_SUFFIX = 'feed';

  public function __construct()
  {
    // Do some compatibility checking
    add_action( 'admin_init', array( $this, 'checkCompat' ) );

    // Get the feed from Zazzle
    add_shortcode( 'store-builder', array( $this, 'buildShortcode' ) );

  }

  public function checkCompat()
  {

    // Check version of WordPress
    if( version_compare( get_bloginfo('version'), '3.0' ) < 0 ) {
      Zsb_Error::incompatible_wp();
      deactivate_plugins( plugin_basename( __FILE__ ) );
      return false; // End Exec
    }

    // Check version of PHP
    if( version_compare( PHP_VERSION, '5.3' ) < 0 ) {
      Zsb_Error::incompatible_php();
      deactivate_plugins( plugin_basename( __FILE__ ) );
      return false; // End Exec
    }

  }

  public function buildShortcode( $atts )
  {

    // Set default atts & merge overrides
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

    // Split out the attributes used only in the FEED URL
    $urlAtts = $this->getFeedAtts( $atts );
    // Get the feed with the correct options set
    $feed = $this->getFeed( $urlAtts, $atts['designer_id'] );

    // Convert feed to Products (see zsb-products.php)
    $products = new Zsb_Products( $feed );

    // If error is true, throw an error
    if($products->getError()) {
      Zsb_Error::publicError( 'notice notice-error', 'There was a problem converting the Feed data to individual products or there was a problem fetching the feed from Zazzle!' );
      return false;
    }
    
    // Setup twig template system (template path, caching, debug)
    $template = new Zsb_Templates( plugin_dir_path( __FILE__ ) . 'templates', false, true );

    return $template->twig->render( 'standard.html.twig', array( 'products' => $products ) );

  }

  public function getFeed( $atts, $designer )
  {

    // Create API URL, if designer is empty it will default to all products
    $url = $this->API_URL . $designer . '/' . $this->API_SUFFIX;

    // For debugging only - prevents cache from persisting
    delete_transient( 'zsb_feed_cache' );

    if( get_transient( 'zsb_feed_cache', false ) )
      return get_transient( 'zsb_feed_cache' );

    // urlencode all items in the atts array
    array_map( 'urlencode', $atts );

    // Build a query string from them & add to URL
    $url = $url . '?' . build_query( $atts );

    $feed = wp_remote_get($url, array(
      'timeout' => 20,
      'redirection' => 0,
      'user-agent' => 'Store Builder For Zazzle WordPress Plugin (By Paul Robinson/Return True)',
    ));

    if( is_wp_error( $feed ) ) {
      Zsb_Error::publicError( 'notice notice-error', 'There was an unknown error fetching the feed.' );
    }

    set_transient( 'zsb_feed_cache', $feed['body'], 3600 );

    return $feed['body'];

  }

  public function getFeedAtts( $atts )
  {

    // Split out sorting method
    $sort = explode( '|', $atts['sort_by'] );

    // If explode resulted in 1 item it is empty or not popularity
    if( count( $sort ) > 1 ) {
      $st = $sort[0];
      $sp = $sort[1];
    } else {
      $st = 'date_created';
      $sp = null;
    }

    return array(
      'qs'  => $atts['keyword_filter'],
      'ps'  => $atts['products_per_page'],
      'bg'  => str_replace( '#', '', $atts['img_bg'] ), // Remove # from color. Not very neat, but quick and easy.
      'isz' => $atts['image_size'],
      'st'  => $st,
      'sp'  => $sp,
      'dp'  => $atts['department_filter'],
      'cg'  => $atts['product_line_filter'],
    );

  }

}

new Zsb_Main;
