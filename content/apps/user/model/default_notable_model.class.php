<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class default_notable_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = '';
		parent::__construct();
	}
}

// end