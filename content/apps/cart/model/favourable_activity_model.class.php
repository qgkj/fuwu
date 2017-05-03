<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class favourable_activity_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'favourable_activity';
		parent::__construct();
	}
}

//end