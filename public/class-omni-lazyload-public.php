<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://webomnizz.com
 * @since      1.0.0
 *
 * @package    Omni_Lazyload
 * @subpackage Omni_Lazyload/public
 * @author     Jogesh <jogesh@webomnizz.com>
 */
class Omni_Lazyload_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lazysizes.js', array(), $this->version, true );
    }
    
    /**
     * Filter attachment for archive pages
     *
     * @param array $attr
     * 
     * @since 1.0.0
     * @return array
     */
    public function attachment_filter( $attr ) {

        if (is_array($attr) && count($attr) > 0) {
            $attr['class'] = $attr['class'] . ' lazyload';
    
            $old_src = $attr['src'];
            $old_src_set = $attr['srcset'];
    
            $attr['data-src'] = $old_src;
            $attr['data-srcset'] = $old_src_set;
    
            unset($attr['src'], $attr['srcset']);
    
            return $attr;
        }
    
        return $attr;
    }

    /**
     * Filter the images from the content to add lazyload 
     *
     * @param string $content
     * 
     * @since 1.0.0
     * @return string
     */
    public function the_content_filter( $content ) {

        $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
        $dom = new DOMDocument();
        @$dom->loadHTML($content);

        // Apply Lazy Image
        foreach ($dom->getElementsByTagName('img') as $node) { 
            $this->lazy_image( $node );
        }

        // Apply Lazy IFrame
        foreach ($dom->getElementsByTagName('iframe') as $node) { 
            $this->lazy_iframe( $node );
        }

        $newHtml = preg_replace('/^<!DOCTYPE.+?>/', '', str_replace( array('<html>', '</html>', '<body>', '</body>'), array('', '', '', ''), $dom->saveHTML()));
        return $newHtml;
    }

    /**
     * Apply Lazyloading on image
     *
     * @param object $node
     * @param string $class
     * 
     * @since 1.0.0
     * @return void
     */
    private function lazy_image( $node, $class = 'lazyload' ) {

        $oldsrc = $node->getAttribute('src');
        $old_srcset = $node->getAttribute('srcset');
        $old_classes = $node->getAttribute('class');

        $node->setAttribute("data-src", $oldsrc );
        $node->setAttribute("data-srcset", $old_srcset);

        $node->removeAttribute("srcset");
        $node->removeAttribute("src");

        $node->setAttribute("class", trim($old_classes) . " {$class}");
    }

    /**
     * Apply Lazyloading on iframe
     *
     * @param object $node
     * @param string $class
     * 
     * @since 1.0.0
     * @return void
     */
    private function lazy_iframe( $node, $class = 'lazyload' ) {

        $old_classes = $node->getAttribute('class');
        $node->setAttribute("class", trim($old_classes) . " {$class}");
    }
}
