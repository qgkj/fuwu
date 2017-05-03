<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class card_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'card';
		parent::__construct();
	}
}

// end