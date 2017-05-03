<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_prize_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'wechat_prize';
		$this->table_alias_name = 'p';
		
		$this->view = array(
			'wechat_user' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'u',
				'on'   	=> 	'p.openid = u.openid'
			),
		);
		
		parent::__construct();
	}
}

// end