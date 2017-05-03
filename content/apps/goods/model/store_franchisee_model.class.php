<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_franchisee_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'store_franchisee';
		parent::__construct();
	}
	
	public function get_store_name_by_id($store_id = 0) {
	    return RC_DB::table('store_franchisee')->where('store_id', $store_id)->pluck('merchants_name');
	}
}

// end