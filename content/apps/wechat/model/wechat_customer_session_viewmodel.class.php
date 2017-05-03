<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_customer_session_viewmodel extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_customer_session';
		$this->table_alias_name = 'cs';
		
		$this->view = array(
			'wechat_customer'	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'c',
				'on'   	=> 	'c.kf_account = cs.kf_account and c.wechat_id = cs.wechat_id'
			),
			'wechat_user'	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'wu',
				'on'   	=> 	'wu.openid = cs.openid and wu.wechat_id = cs.wechat_id'
			)
		);
		parent::__construct();
	}
}

// end