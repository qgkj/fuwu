<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class invitee_record_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'invitee_record';
		parent::__construct();
	}
}

// end