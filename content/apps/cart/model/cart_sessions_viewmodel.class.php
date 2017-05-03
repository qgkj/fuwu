<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_sessions_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view =array();
	public function __construct() {
		$this->table_name = 'cart';
		$this->table_alias_name = 'c';
		
		//定义视图选项
		$this->view =array(
			'sessions' => array(
				'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 's',
				'field' => 'DISTINCT session_id',
				'on'    => 'c.session_id = s.sesskey'
			)		
		);
		parent::__construct();
	}
}

// end