<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/raosuresh94/
 * @since      1.0.0
 *
 * @package    Cf_Cms
 * @subpackage Cf_Cms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cf_Cms
 * @subpackage Cf_Cms/public
 * @author     Suresh <raosuresh94@gmail.com>
 */
class Cf_Cms_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

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
		 * defined in Cf_Cms_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cf_Cms_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cf-cms-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cf-cms-public.js', array( 'jquery' ), $this->version, false );

		wp_localize_script(
			$this->plugin_name,
			'cf_cms',
			array(
				'ajax'    => admin_url( 'admin-ajax.php' ),
				'success' => __( 'Request sucessfully submitted!', 'cf-cms' ),
				'error'   => __( 'Please fill all the details!', 'cf-cms' ),
			)
		);

	}

	/**
	 * Render Contact Form
	 *
	 * @param array  $attr Attr.
	 * @param string $content Conteng.
	 */
	public function render_contact_form( $attr = array(), $content = null ) {
		ob_start();
			require __DIR__ . '/templates/template-form.php';
		return ob_get_clean();
	}

	/**
	 * AJAX Callback function on form submit
	 */
	public function cms_cf_submit() {
		if ( ! wp_verify_nonce($_POST['nonce'], 'cms_cf_submit' ) ) {
			wp_send_json(
				array(
					'status'  => true,
					'message' => 'Security',
				)
			);
		}
		if ( $this->save_form_data( $_POST ) ) {
			wp_send_json(
				array(
					'status'  => true,
					'message' => 'We are getting issue to save your data!',
				)
			);
		}
		wp_send_json(
			array(
				'status'  => false,
				'message' => 'Data Saved Succesfully',
			)
		);
	}

	/**
	 * Save The posted data to Database
	 *
	 * @param array $data Posted data.
	 */
	private function save_form_data( $data ) {
		global $wpdb;
		$table                   = $wpdb->prefix . TABLE_NAME;
		$body                    = array();
		$body['user_first_name'] = $data['user_first_name'];
		$body['user_last_name']  = $data['user_last_name'];
		$body['user_phone']      = $data['user_phone'];
		$body['user_email']      = $data['user_email'];
		$body['user_comment']    = $data['user_comment'];
		//phpcs:ignore
		$response = $wpdb->insert( $table, $body );

		if ( is_wp_error( $response ) ) {
			return true;
		}
		return false;
	}

}
