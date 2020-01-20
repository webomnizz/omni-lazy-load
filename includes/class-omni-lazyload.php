<?php

class Omni_Lazyload {

    protected $loader;

	protected $plugin_name;

	protected $version;

    public function __construct() {
		if ( defined( 'OMNI_LAZYLOAD_VERSION' ) ) {
			$this->version = OMNI_LAZYLOAD_VERSION;
		} else {
			$this->version = '1.0.0';
        }
        
		$this->plugin_name = 'omni-lazyload';

		$this->load_dependencies();
		$this->define_public_hooks();
    }
    
    private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-omni-lazyload-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-omni-lazyload-public.php';

		$this->loader = new Omni_Lazyload_Loader();
	}

	private function define_public_hooks() {

		$omniz_lazyload = new Omni_Lazyload_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $omniz_lazyload, 'enqueue_scripts' );

		$this->loader->add_filter( 'wp_get_attachment_image_attributes', $omniz_lazyload, 'attachment_filter' );
		$this->loader->add_filter( 'the_content', $omniz_lazyload, 'the_content_filter' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}

if (! function_exists('omni_lazyload')) {

    function omni_lazyload() {
		$lazyload = new Omni_Lazyload();
		$lazyload->run();
    }
}