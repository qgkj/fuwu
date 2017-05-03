<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class term_meta_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'term_meta';
		parent::__construct();
	}

}

// end