<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class virtual_card_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'virtual_card';
		parent::__construct();
	}
}

// end