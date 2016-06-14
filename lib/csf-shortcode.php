<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Csf_Shortcode {

  public function __construct()
  {
    add_filter( 'cs_shortcode_options', array( $this, 'cs_shortcode_options' ) );
  }

  public function cs_shortcode_options( $shortcodes )
  {

    /*
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
    'show_product_price'    => cs_get_option( 'zsb_display_price' ),*/

    // Remove default shortcodes
    $shortcodes   = array();

    // Set custom shortcodes
    $shortcodes[]   = array(
      'name'        => 'zsb_shortcode',
      'title'       => 'Store Builder Shortcode',
      'shortcodes'  => array(
        array(
          'name'    => 'store-builder',
          'title'   => 'Store Builder',
          'fields'  => array(

            array(
              'id'    => 'referral_id',
              'type'  => 'text',
              'title' => 'Referral ID',
              'help'  => 'Enter the Referral ID found on your associates page in the Zazzle Dashboard. Allows you to get referral when a customer purchases a product.'
            ),

            array(
              'id'    => 'designer_id',
              'type'  => 'text',
              'title' => 'Designer ID',
              'help'  => 'Use to filter products to a specific designer/author.'
            ),

            array(
              'id'    => 'products_per_page',
              'type'  => 'number',
              'title' => 'Products Per Page',
              'help'  => 'How many products to show per page',
            ),

            array(
              'id'    => 'sort_by',
              'type'  => 'select',
              'title' => 'Sort By',
              'options'     => array(
                'date_created'    => 'Date Created',
                'popularity|0'    => 'Popularity (All Time)',
                'popularity|1'    => 'Popularity (Today)',
                'popularity|7'    => 'Popularity (This Week)',
                'popularity|30'   => 'Popularity (This Month)',
              ),
              'default_option' => 'Select Sorting',
            ),

          )
        )
      )
    );

    return $shortcodes;

  }

}

new Zsb_Csf_Shortcode;
