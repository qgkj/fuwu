<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class feedback_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'feedback';
		$this->table_alias_name = 'f';
		
		$this->view = array(
				'admin_user' => array(
						'type' 	=>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 	'au',
						'field' => 	'f.*, r.msg_id AS reply_id, r.user_name  AS reply_name, au.email AS reply_email,r.msg_content AS reply_content , r.msg_time AS reply_time',
						'on'   	=>  'au.user_id = "'.$_SESSION['admin_id'].'" '
				),
				'feedback' 	 => array(
						'type' 	=>	Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 	'r',
						'on'   	=>  'r.parent_id = f.msg_id '
				)
		);
		parent::__construct();
	}
}

// end