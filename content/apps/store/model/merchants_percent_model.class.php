<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_percent_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_percent';
		parent::__construct();
	}
}

// end