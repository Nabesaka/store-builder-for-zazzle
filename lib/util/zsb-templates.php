<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.

class Zsb_Templates {

    /**
     * Path to template files
     *
     * @var string
     */
    private $path;

    /**
     * Enable/disable Twig cache
     *
     * @var boolean/string
     */
    private $cache;

    /**
     * Twig Instance
     *
     * @var Twig_Environment
     */
    public $twig;

    public function __construct($path = false, $cache = null, $debug = false)
    {
        // Set template path relative to this file
        $this->path = ( $path ? $path : plugin_dir_path( __FILE__ ) . '../../templates/' );
        $this->cache = ( !is_null( $cache ) ? $cache : '/templates/cache' );
        $this->debug = ( $debug ? $debug : false );

        $this->initTwig();
    }

    private function initTwig()
    {
        $loader = new Twig_Loader_Filesystem( $this->path );
        $this->twig = new Twig_Environment($loader, array(
            'cache' => $this->cache,
            'debug' => $this->debug,
        ));
    }

    public function render($template, $opts)
    {
        $this->twig->render( $template, $opts );
    }

}
