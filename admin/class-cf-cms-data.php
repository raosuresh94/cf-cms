<?php

/**
 * Contact Form Data
 */

class CmsData extends WP_List_Table
{
    private $data = array();

    public static function run()
    {
        return new self();
    }

    public function __construct()
    {
        global $wpdb;
        $table_name = $wpdb->prefix.TABLE_NAME;
        $this->delete();
        $results = $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
        $data = array();
        foreach ($results as $key => $value) {
            $data[] = array(
                'id' => $value['id'],
                'name' => $value['user_first_name'].' '.$value['user_last_name'],
                'email' => $value['user_email'],
                'phone' => $value['user_phone'],
                'comment' => $value['user_comment'],
                'date' => date(get_option('date_format', $value['created_at'])),
            );
        }
        parent::__construct();
        $this->data = $data;
    }
    public function get_columns()
    {
        $columns = array(
          'cb'        => '<input type="checkbox" />',
          'name' => 'Name',
          'email' => 'Email',
          'phone' => 'Phone',
          'comment' => 'Comment',
          'date'    => 'Date',
        );
        return $columns;
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $this->data;
        $per_page = $this->get_items_per_page('data_per_page', 10);
        $current_page = $this->get_pagenum();
        $total_items = count($this->data);
        $data = array_slice($this->data, (($current_page-1)*$per_page), $per_page);
        $this->set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page
        ));
        $this->found_data = $data;
        $this->items = $data;
    }

    public function column_default($item, $column_name)
    {
        switch ($column_name) {
            case 'name':
            case 'email':
            case 'phone':
            case 'comment':
            case 'date':
                return $item[ $column_name ];
            default:
                return print_r($item, true) ; //Show the whole array for troubleshooting purposes
        }
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
          'name'  => array('name',false),
          'email' => array('email',false),
          'phone' => array('phone',false),
          'comment' => array('comment',false),
          'date'   => array('date',false)
        );
        return $sortable_columns;
    }

    public function column_name($item)
    {
        $actions = array(
                  'delete'    => sprintf('<a href="?page=%s&action=%s&record=%s">Delete</a>', $_REQUEST['page'], 'delete', $item['id']),
              );
      
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions));
    }

    public function get_bulk_actions()
    {
        $actions = array(
          'delete'    => 'Delete'
        );
        return $actions;
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="record[]" value="%s" />',
            $item['id']
        );
    }

    public function delete()
    {
        global $wpdb;
        $action = $_GET['action'];
        $record_id = $_GET['record'];
        $table_name = $wpdb->prefix.TABLE_NAME;
        if ($action=='delete' && !empty($record_id)) {
            if (is_array($record_id)) {
                foreach ($record_id as $id) {
                    $wpdb->delete($table_name, array('id'=>$id));
                }
            } else {
                $wpdb->delete($table_name, array('id'=>$record_id));
            }
        }
    }
}
