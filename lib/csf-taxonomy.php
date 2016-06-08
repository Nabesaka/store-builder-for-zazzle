<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Csf_Taxonomy {

  public function __construct()
  {
    add_filter( 'cs_taxonomy_options', array( $this, 'cs_taxonomy_options' ) );
  }

  public function cs_taxonomy_options( $options )
  {

    return array();

  }

}

new Zsb_Csf_Taxonomy;
