<?php
/**
 * Fired during plugin activation
 *
 * @link       https://github.com/raosuresh94/
 * @since      1.0.0
 *
 * @package    Cf_Cms
 * @subpackage Cf_Cms/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Cf_Cms
 * @subpackage Cf_Cms/includes
 * @author     Suresh <raosuresh94@gmail.com>
 */
class Cf_Cms_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		self::add_shortcode();
		$table_name = $wpdb->prefix . TABLE_NAME;
		$collate    = $wpdb->get_charset_collate();
		$sql        = "CREATE TABLE {$table_name}(
            `id` INT(10) NOT NULL AUTO_INCREMENT,
            `user_first_name` varchar(255) NOT NULL,
            `user_last_name` varchar(255) NOT NULL,
            `user_phone` varchar(255) NOT NULL,
            `user_email` varchar(255) NOT NULL,
            `user_comment` longtext NOT NULL,
            `created_at` timestamp NOT NULL,
            PRIMARY KEY (id)
        ) $collate;";
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	/**
	 * Add Shortcode.
	 */
	public static function add_shortcode() {
		$body                 = array();
		$body['post_title']   = 'Contact Us';
		$body['post_status']  = 'publish';
		$body['post_content'] = '[CF_CMS_FORM]';
		$body['post_type']    = 'page';
		wp_insert_post( $body );
	}

}
