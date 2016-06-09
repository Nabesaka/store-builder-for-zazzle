<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

Class Zsb_Error {

    /**
     * THESE SHOULD USE LAMBDA FUNCTIONS BUT THEY ARE THE VERSION CHECK WHICH WILL FAIL
     * IF PHP IS NOT A HIGH ENOUGH VERSION
     **/

    public static function incompatibleWp()
    {
        add_action( 'admin_notices', array( 'Zsb_Error', 'createIncompatibleWpError' ) );
    }

    public static function createIncompatibleWpError()
    {
        $class = 'notice notice-error';
        $message = __( '<strong>Store Builder:</strong> Your installed WordPress version is too old. Please upgrade if you wish to continue using this plugin. We have automatically disabled the plugin to prevent any errors.', 'store-builder');

        printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
    }

    public static function incompatiblePhp()
    {
        add_action( 'admin_notices', array( 'Zsb_Error', 'createIncompatiblePhpError' ) );
    }

    public static function createIncompatiblePhpError()
    {
        $class = 'notice notice-error';
        $message = __( '<strong>Store Builder:</strong> Version 5.3 of PHP is required for this plugin to work. Please ask your host to upgrade if you wish to continue using it. We have automatically disabled the plugin to prevent any errors.', 'store-builder');

        printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
    }

     public static function publicError($class, $message)
     {
         $message = __( '<strong>Store Builder:</strong> ' . $message, 'store-builder');

         printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
     }

}
