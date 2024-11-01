<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://jeweltheme.com
 * @since      1.0.0
 *
 * @package    WP_Awesome_Insta_Widget
 * @subpackage WP_Awesome_Insta_Widget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Awesome_Insta_Widget
 * @subpackage WP_Awesome_Insta_Widget/public
 * @author     Your Name <email@example.com>
 */
class WP_Awesome_Insta_Widget_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_Awesome_Insta_Widget    The ID of this plugin.
	 */
	private $WP_Awesome_Insta_Widget;

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
	 * @param      string    $WP_Awesome_Insta_Widget       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_Awesome_Insta_Widget, $version ) {

		$this->WP_Awesome_Insta_Widget = $WP_Awesome_Insta_Widget;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Awesome_Insta_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Awesome_Insta_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->WP_Awesome_Insta_Widget, plugin_dir_url( __FILE__ ) . 'css/wp-awesome-insta-widget-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WP_Awesome_Insta_Widget_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WP_Awesome_Insta_Widget_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->WP_Awesome_Insta_Widget, plugin_dir_url( __FILE__ ) . 'js/wp-awesome-insta-widget-public.js', array( 'jquery' ), $this->version, false );

	}

}
