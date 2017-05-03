<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员排行数据模型
 */
class users_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'users';
		$this->table_alias_name = 'u';
		
		$this->view = array(
			'order_info' => array(
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'=> 'o',
				'on'   => 'o.user_id = u.user_id'
			)	
		);
		parent::__construct();
	}
}

// end