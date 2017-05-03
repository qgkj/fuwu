<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class searchengine_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'searchengine';
		parent::__construct();
	}
}

// end