<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_log_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view =array();
	public function __construct() {
		$this->table_name = 'admin_log';
		$this->table_alias_name	= 'al';
		
		//定义视图选项
		$this->view =array(
				//定义users 表关联
				'admin_user' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'au',
						'field' => 'al.*, au.user_name',
						'on'   => 'au.user_id = al.user_id'
				)
				
		);
		
		parent::__construct();
	}



}

// end