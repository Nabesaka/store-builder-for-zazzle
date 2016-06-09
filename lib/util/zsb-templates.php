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
    public $cache;

    /**
     * Twig Instance
     *
     * @var Twig_Environment
     */
    public $twig;

    public function __construct()
    {
        // Set template path
        $this->path = plugin_dir_path( __FILE__ ) . '/templates/';
        $this->cache = '/templates/cache';

    }

    private function initTwig()
    {
        $loader = new Twig_Loader_Filesystem( $this->path );
        $this->twig = new Twig_Environment($loader, array(
            'cache' => $this->cache,
        ));
    }

}
