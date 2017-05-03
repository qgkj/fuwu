<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家关键字模型
 */
class store_keywords_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'store_keywords';
		parent::__construct();
	}
}

// end