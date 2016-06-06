<?php

Class Zsb_Options {

  public function __construct()
  {
    add_filter( 'cs_framework_options', array( $this, 'cs_framework_options' ) );
  }

  public function cs_framework_options( $options )
  {

    $options      = array(); // remove old options

    // Options for ZSB
    /**
     * Referal ID - Text Field
     * Designer ID (Slug) - Text Field
     * -------------------------------
     * Products Per Page - Number Field
     * Sorting (Created / Popularity) - Select Field
     * Product Image Size - Select Field
     * Link to Product - Switcher Field
     * Alternative Link - Text Field
     * Change Image BG Color - Switcher Field
     * Image BG Color - Text Field
     * -------------------------------
     * Keyword Filter - Text Field
     * Department Filter - Select Field
     * Rating Filter - Select Field
     * -------------------------------
     * Show Product Title - Switcher Field
     * Show By Line (Designer) - Switcher Field
     * Show Description - Switcher Field
     * Show Price - Switcher Field
     * -------------------------------
     * Template Options - More Later
     * -------------------------------
     **/

    $options[]    = array(
      'name'      => 'zsb_section_designer',
      'title'     => 'Designer Settings',
      'icon'      => 'fa fa-paint-brush',
      'fields'    => array(
        array(
          'type'    => 'subheading',
          'content' => 'Designer Options',
        ),

        array(
          'id'      => 'zsb_designer_referal_id',
          'type'    => 'text',
          'title'   => 'Referral ID',
          'desc'    => 'This will enable you to earn referral on any purchases made after a visitor clicks through to Zazzle.',
          'help'    => 'Enter the Referral ID found on your associates page in the Zazzle Dashboard.'
        ),

        array(
          'id'      => 'zsb_designer_designer_id',
          'type'    => 'text',
          'title'   => 'Designer ID',
          'desc'    => 'Will filter products by the designer name entered. Leave blank to show products from all designers.',
          'help'    => 'This is also known as your Store Name.'
        ),
      ),
    );

    $options[]    = array(
      'name'      => 'zsb_section_products',
      'title'     => 'Product Settings',
      'icon'      => 'fa fa-gift',
      'fields'    => array(
        array(
          'type'    => 'subheading',
          'content' => 'Product Options',
        ),

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => '<strong>Note:</strong> All the options below can be overridden using shortcode options. These are global options used if you choose not to override them.',
        ),

        array(
          'id'      => 'zsb_products_per_page',
          'type'    => 'number',
          'title'   => 'Products Per Page',
          'desc'    => 'Determines how many products to show per page.',
          'help'    => 'Enter the Referral ID found on your associates page in the Zazzle Dashboard.',
          'attributes'  => array(
            'min'   => 1,
            'max'   => 100,
          ),
        ),

        array(
          'id'      => 'zsb_products_sort',
          'type'    => 'select',
          'title'   => 'Sorting Options',
          'desc'    => 'Sorts the products.<br/>If left unselected sorting will be by Date Created.',
          'options'     => array(
            'date_created'    => 'Date Created',
            'popularity|0'    => 'Popularity (All Time)',
            'popularity|1'    => 'Popularity (Today)',
            'popularity|7'    => 'Popularity (This Week)',
            'popularity|30'   => 'Popularity (This Month)',
          ),
          'default_option' => 'Select Sorting',
        ),

        array(
          'type'    => 'notice',
          'class'   => 'danger',
          'content' => '<strong>Note:</strong> Zazzle do not allow the use of Popularity Sorting and selecting a Product Image Size. If you select popularity sorting Zazzle will automatically return Product Images sized at 152px X 152px regardless of the Product Image Size setting below.',
        ),

        array(
          'id'      => 'zsb_products_image_size',
          'type'    => 'select',
          'title'   => 'Product Image Size',
          'desc'    => 'Select Product Images size.<br/>If left unselected 152x152px will be used by default.',
          'options'     => array(
            'tiny'    => '50px X 50px',
            'small'   => '92px X 92px',
            'medium'  => '152px X 152px',
            'large'   => '210px X 210px',
            'huge'    => '328px X 328px',
          ),
          'default_option' => 'Select Image Size',
        ),

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => '<strong>Note:</strong> If both Zazzle Product Linking and Custom URLs are enabled Custom URLs will take precedence.',
        ),

        array(
          'id'      => 'zsb_products_zazzle_link',
          'type'    => 'switcher',
          'title'   => 'Link Product To Zazzle',
          'desc'    => 'If enabled the link will include your Referral ID if one has been supplied.',
          'default' => true,
          'dependency' => array( 'zsb_products_alt_link', '==', 'false' )
        ),

        array(
          'id'      => 'zsb_products_alt_link',
          'type'    => 'switcher',
          'title'   => 'Link Product To Custom URL',
          'desc'    => 'Allow products to link to a custom URL of your choice.',
          'default' => false,
        ),

        array(
          'id'      => 'zsb_products_alt_link_content',
          'type'    => 'text',
          'title'   => 'Custom Product URL',
          'desc'    => 'You may choose to link all products to a URL of your choice if Zazzle linking is disabled.',
          'attributes'    => array(
            'placeholder'   => 'http://www.example.com/'
          ),
          'dependency' => array( 'zsb_products_alt_link', '==', 'true' )
        )
      ),
    );

    return $options;

  }

}

new Zsb_Options;
