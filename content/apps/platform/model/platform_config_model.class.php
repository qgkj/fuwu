<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_config_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'platform_config';
		parent::__construct();
	}
}

// end