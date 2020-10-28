<?php
/**
 * Cf_Cms_Data.
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
class Cf_Cms_Data extends WP_List_Table {

	/**
	 * Data Array.
	 *
	 * @var $data
	 */
	private $data = array();

	/**
	 * Initiate Object of class.
	 */
	public static function run() {
		return new self();
	}

	/**
	 * Function for create initate object.
	 */
	public function __construct() {
		global $wpdb;
		$table_name = $wpdb->prefix . TABLE_NAME;
		$this->delete();
		$query   = $wpdb->prepare( "SELECT * FROM `$table_name`" );
		$results = $wpdb->get_results( $query, ARRAY_A );
		$data    = array();
		foreach ( $results as $key => $value ) {
			$data[] = array(
				'id'      => $value['id'],
				'name'    => $value['user_first_name'] . ' ' . $value['user_last_name'],
				'email'   => $value['user_email'],
				'phone'   => $value['user_phone'],
				'comment' => $value['user_comment'],
				'date'    => gmdate( get_option( 'date_format', $value['created_at'] ) ),
			);
		}
		parent::__construct();
		$this->data = $data;
	}

	/**
	 * Get all Column Name.
	 */
	public function get_columns() {
		$columns = array(
			'cb'      => '<input type="checkbox" />',
			'name'    => 'Name',
			'email'   => 'Email',
			'phone'   => 'Phone',
			'comment' => 'Comment',
			'date'    => 'Date',
		);
		return $columns;
	}

	/**
	 * Prepare Data for display.
	 */
	public function prepare_items() {
		$columns               = $this->get_columns();
		$hidden                = array();
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
		$this->items           = $this->data;
		$per_page              = $this->get_items_per_page( 'data_per_page', 10 );
		$current_page          = $this->get_pagenum();
		$total_items           = count( $this->data );
		$data                  = array_slice( $this->data, ( ( $current_page - 1 ) * $per_page ), $per_page );
		$this->set_pagination_args(
			array(
				'total_items' => $total_items,
				'per_page'    => $per_page,
			)
		);
		$this->found_data = $data;
		$this->items      = $data;
	}

	/**
	 * Set Default Column needs to show.
	 *
	 * @param array $item Array of column items.
	 * @param array $column_name Get column Name.
	 */
	public function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'name':
			case 'email':
			case 'phone':
			case 'comment':
			case 'date':
				return $item[ $column_name ];
			default:
				return $item; // Show the whole array for troubleshooting purposes.
		}
	}

	/**
	 * Set Sortable column name.
	 */
	public function get_sortable_columns() {
		$sortable_columns = array(
			'name'    => array( 'name', false ),
			'email'   => array( 'email', false ),
			'phone'   => array( 'phone', false ),
			'comment' => array( 'comment', false ),
			'date'    => array( 'date', false ),
		);
		return $sortable_columns;
	}

	/**
	 * Get Column Name.
	 *
	 * @param array $item Get Delete action Column.
	 */
	public function column_name( $item ) {
		$page    = ( ! empty( $_REQUEST['page'] ) ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '';
		$nonce   = wp_create_nonce( 'delete_contact' );
		$actions = array(
			'delete' => sprintf( '<a href="?page=%s&action=%s&record=%s">Delete</a>', $page, 'delete', $item['id'] ),
		);

		return sprintf( '%1$s %2$s', $item['name'], $this->row_actions( $actions ) );
	}

	/**
	 * Get all Actions.
	 */
	public function get_bulk_actions() {
		$actions = array(
			'delete' => 'Delete',
		);
		return $actions;
	}

	/**
	 * Column for checkbox.
	 *
	 * @param array $item Set Items.
	 */
	public function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="record[]" value="%s" />',
			$item['id']
		);
	}

	/**
	 * Delete Functionality
	 */
	public function delete() {
		global $wpdb;
		// phpcs:ignore
		$action     = ( ! empty( $_GET['action'] ) ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
		// phpcs:ignore
		$record_id  = ( ! empty( $_GET['record'] ) ) ? sanitize_text_field( wp_unslash( $_GET['record'] ) ) : '';
		$table_name = $wpdb->prefix . TABLE_NAME;
		if ( 'delete' === $action && ! empty( $record_id ) ) {
			if ( is_array( $record_id ) ) {
				foreach ( $record_id as $id ) {
					// phpcs:ignore
					$wpdb->delete( $table_name, array( 'id' => $id ) );
				}
			} else {
				// phpcs:ignore
				$wpdb->delete( $table_name, array( 'id' => $record_id ) );
			}
		}
	}
}
