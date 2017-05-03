<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_message_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view =array();
	public function __construct() {
		$this->table_name = 'admin_message';
		$this->table_alias_name = 'a';
		
		//定义视图选项
		$this->view =array(
				'admin_user' => array(
						'type'  =>Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'b',
						'field' => 'a.*,b.user_name',
						'on'   => 'b.user_id = a.sender_id '
				)
				
		);
		
		
		parent::__construct();
	}



}

// end