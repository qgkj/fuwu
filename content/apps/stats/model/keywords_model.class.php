<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 搜索引擎模型
 */
class keywords_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'keywords';
		parent::__construct();
	}
}

// end