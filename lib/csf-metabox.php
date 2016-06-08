<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Csf_Metabox {

    public function __construct()
    {
      add_filter( 'cs_metabox_options', array( $this, 'cs_metabox_options' ) );
    }

    public function cs_metabox_options( $options )
    {
        return array();
    }

}

new Zsb_Csf_Metabox;
