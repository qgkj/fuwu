<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
//RC_Loader::load_core_class('driver.model.model', false);

class tag_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'tag';
		parent::__construct();
	}
}

// end