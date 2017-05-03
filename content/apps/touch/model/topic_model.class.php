<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
//RC_Loader::load_core_class('driver.model.model', false);

class topic_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->db_config  = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'topic';
		parent::__construct();
	}
}

// end