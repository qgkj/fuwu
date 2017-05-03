<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_mass_history_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_mass_history';
		parent::__construct();
	}
	

}

// end