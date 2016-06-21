<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Csf_Options {

  public function __construct()
  {
    add_filter( 'cs_framework_options', array( $this, 'csFrameworkOptions' ) );
  }

  public function csFrameworkOptions( $options )
  {

    $options      = array(); // remove old options

    // DESIGNER SETTINGS

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
          'id'      => 'zsb_designer_referral_id',
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

    // PRODUCT SETTINGS

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
        ),

        array(
          'id'      => 'zsb_products_img_bg',
          'type'    => 'switcher',
          'title'   => 'Change Product Image Background Color',
          'desc'    => 'Change the background color of the product images returned by Zazzle.',
          'default' => false,
        ),

        array(
          'id'      => 'zsb_products_img_bg_content',
          'type'    => 'color_picker',
          'title'   => 'Product Image Background Color',
          'desc'    => 'What color would you like for the background of the product image?<br/>Defaults to white.',
          'dependency' => array( 'zsb_products_img_bg', '==', 'true' )
        ),

      ),
    );

   // FILTER SETTINGS

   $options[]    = array(
     'name'      => 'zsb_section_filter',
     'title'     => 'Filter Settings',
     'icon'      => 'fa fa-filter',
     'fields'    => array(
       array(
         'type'    => 'subheading',
         'content' => 'Filter Options',
       ),

       array(
         'id'      => 'zsb_filter_keywords',
         'type'    => 'text',
         'title'   => 'Keyword Filter',
         'desc'    => 'Keywords to filter returned products by.<br />Separate multiple keywords with a comma (,).',
       ),

       array(
         'type'    => 'notice',
         'class'   => 'info',
         'content' => '<strong>Note:</strong> Zazzle will not provide me with a consumable list of Department IDs that can be used to populate a list. Instead they have a <a href="http://www.zazzle.co.uk/sell/affiliates/promotionaltools/rss" target="zsb_external">selector on their website</a>. Please use that to find the Department ID you need and paste it in the box below.'
       ),

       array(
         'id'      => 'zsb_filter_department',
         'type'    => 'text',
         'title'   => 'Department Filter',
         'desc'    => 'Returns only products from a specific department.',
         'help'    => 'Departments are essentially product types.',
         'options' => array(
           'item1'    => 'item 1'
         )
       ),

       array(
         'id'      => 'zsb_filter_product_line',
         'type'    => 'text',
         'title'   => 'Product Line Filter',
         'desc'    => 'A product line is the same as the categories you can make in your store.<br />Enter the CG number for the category you wish to filter by. Please view the documentation for more.',
       ),

       /*array(
         'id'     => 'zsb_filter_rating',
         'type'   => 'select',
         'title'  => 'Rating Filter',
         'desc'   => 'Returns only items that have the specified maturity rating.',
         'options'  =>  array(
            'G'   => 'G',
         )
       ),*/
     ),
   );

   // STYLING SETTINGS

   $options[]    = array(
     'name'      => 'zsb_section_styling',
     'title'     => 'Styling Options',
     'icon'      => 'fa fa-paint-brush',
     'fields'    => array(
       array(
         'type'     => 'subheading',
         'content'  => 'Styling Options',
       ),

       array(
         'id'       => 'zsb_custom_css',
         'type'     => 'textarea',
         'title'    => 'Custom CSS',
         'desc'     => 'Enter custom CSS rules to style the output of the plugin.',
       ),

     )
   );


   // DISPLAY SETTINGS

   $options[]    = array(
     'name'      => 'zsb_section_display',
     'title'     => 'Display Settings',
     'icon'      => 'fa fa-television',
     'fields'    => array(
       array(
         'type'    => 'subheading',
         'content' => 'Display Options',
       ),

       array(
         'id'      => 'zsb_display_title',
         'type'    => 'switcher',
         'title'   => 'Display Product Title',
         'desc'    => 'Should the product title be displayed?',
         'default' => true
       ),

       array(
         'id'      => 'zsb_display_author',
         'type'    => 'switcher',
         'title'   => 'Display By Line',
         'desc'    => 'Should the product author/designer be displayed?',
         'default' => true
       ),

       array(
         'id'      => 'zsb_display_description',
         'type'    => 'switcher',
         'title'   => 'Display Product Description',
         'desc'    => 'Should the product description be displayed?',
         'default' => true
       ),

       array(
         'id'      => 'zsb_display_price',
         'type'    => 'switcher',
         'title'   => 'Display Product Price',
         'desc'    => 'Should the product price be displayed?',
         'default' => true
       ),
     ),
   );


  return $options;

  }

}

new Zsb_Csf_Options;
