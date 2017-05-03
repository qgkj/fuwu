<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class attribute_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'attribute';
		parent::__construct();
	}
}

// end