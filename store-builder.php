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

    $feed = $this->get_feed( $atts['designer_id'] );

    $products = $this->create_products( $feed );

    print_r($products);

  }

  public function get_feed( $designer = '' )
  {

    $url = $this->API_URL . $designer . '/' . $this->API_SUFFIX;

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

  public function create_products( $feed )
  {

    $products = array();

    $xml = new SimpleXMLElement($feed);
    $xml->registerXPathNamespace('opensearch', 'http://a9.com/-/spec/opensearch/1.1/');
    $xml->registerXPathNamespace('media', 'http://search.yahoo.com/mrss/');

    foreach($xml->xpath('/rss/channel/item') as $item) {

      $product = new Zsb_Product();

      $product->setTitle($item->title);
      $product->setDesigner($item->author);
      $product->setPrice($item->price);
      $product->setDate($item->pubDate);
      $product->setLink($item->guid);
      $product->setDescription($item->xpath('media:description')[0]);
      $product->setDescriptionHTML($item->description);
      $product->setImageUrl($item->xpath('media:thumbnail')[0]->attributes()->url);
      $product->setRating($item->xpath('media:rating')[0]);
      $product->setKeywords($item->xpath('media:keywords')[0]);

      $products[] = $product;

    }

    if( is_array($products) && !empty($products) )
      return $products;

    return false;

  }

}

new Zsb_Main;
