<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'wechat_user';
		$this->table_alias_name = 'u';
		
		$this->view = array(
			'wechat_tag' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'wt',
				'on'   	=> 	'wt.wechat_id = u.wechat_id'
			),
			'users'	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'us',
				'on'   	=> 	'us.user_id = u.ect_uid'
			),
			'wechat_user_tag' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'ut',
				'on'   	=> 	'ut.userid = u.uid'
			),
		);
		
		parent::__construct();
	}

}

// end