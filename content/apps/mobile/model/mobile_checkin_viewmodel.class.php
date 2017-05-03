<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile_checkin_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name       = 'mobile_checkin';
		$this->table_alias_name = 'mc';
		
		//定义视图选项
		$this->view = array(
			'users' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'u',
				'on'    => 'mc.user_id = u.user_id'
			),
			
		);
		parent::__construct();
	}
}

// end