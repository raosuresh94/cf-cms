<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/raosuresh94/
 * @since      1.0.0
 *
 * @package    Cf_Cms
 * @subpackage Cf_Cms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cf_Cms
 * @subpackage Cf_Cms/admin
 * @author     Suresh <raosuresh94@gmail.com>
 */
class Cf_Cms_Admin {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cf_Cms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cf_Cms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf-cms-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cf_Cms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cf_Cms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cf-cms-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register Menus.
	 */
	public function register_menu() {
		add_menu_page(
			'Contact Form DB',
			'Contact Form DB',
			'manage_options',
			'contact_form_db',
			array( $this, 'render_menu_page' ),
			'dashicons-chart-line'
		);

	}

	/**
	 * Render Page For Contact DB Menu.
	 */
	public function render_menu_page() {
		$data = new Cf_Cms_Data();
		// phpcs:ignore 
		$page = ( ! empty( $_GET['page'] ) ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
		echo '<div class="wrap"><h2>Contact Form Submitted Data</h2>';
		echo '<form id="contact_form_db" action="" method="get">';
		echo '<input type="hidden" name="page" value="' . esc_attr( $page ) . '" />';
		$data->prepare_items();
		$data->display();
		echo '</form>';
		echo '</div>';
	}

}
