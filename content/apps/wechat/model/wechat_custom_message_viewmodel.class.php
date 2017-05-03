<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_custom_message_viewmodel extends Component_Model_View {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'wechat_custom_message';
		$this->table_alias_name = 'm';
		
		$this->view = array(
			'wechat_user'	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'wu',
				'on'   	=> 	'wu.uid = m.uid'
			)
		);
		parent::__construct();
	}

}

// end