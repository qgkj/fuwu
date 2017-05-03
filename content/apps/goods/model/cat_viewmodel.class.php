<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cat_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'goods_cat';
		$this->table_alias_name	= 'g';
		parent::__construct();
	}
}

// end