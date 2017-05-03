<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class qrcode_validate_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'qrcode_validate';
		parent::__construct();
	}
}

// end