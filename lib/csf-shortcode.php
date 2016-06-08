<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Csf_Shortcode {

  public function __construct()
  {
    add_filter( 'cs_shortcode_options', array( $this, 'cs_shortcode_options' ) );
  }

  public function cs_shortcode_options( $options )
  {

    return array();

  }

}

new Zsb_Csf_Shortcode;
