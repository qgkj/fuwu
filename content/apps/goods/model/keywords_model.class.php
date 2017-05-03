<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class keywords_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'keywords';
		parent::__construct();
	}

}

// end