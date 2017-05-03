<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 站外投放JS数据模型
 */
class adsense_model extends Component_Model_Model {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'adsense';
		parent::__construct();
	}
}

// end