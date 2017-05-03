<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ad_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'ad';
		parent::__construct();
	}
}

// end