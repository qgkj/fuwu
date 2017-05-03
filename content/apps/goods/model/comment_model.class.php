<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class comment_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'comment';
		parent::__construct();
	}
}

// end