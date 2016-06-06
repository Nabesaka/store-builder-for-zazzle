<?php

Class Zsb_Settings {

  public function __construct()
  {
    add_filter( 'cs_framework_settings', array( $this, 'cs_framework_settings' ) );
  }

  public function cs_framework_settings( $settings )
  {

    $settings      = array(); // remove old options

    $settings      = array(
      'menu_title'      => 'Store Builder',
      'menu_type'       => 'options', // menu, submenu, options, theme, etc.
      'menu_slug'       => 'zsb-options',
      'ajax_save'       => false,
      'show_reset_all'  => true,
      'framework_title' => 'Store Builder for Zazzle <small>by Paul Robinson (<a href="https://return-true.com">Return True</a>)</small>',
    );

    return $settings;

  }

}

new Zsb_Settings;
