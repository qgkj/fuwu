<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_reply_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'wechat_reply';
		$this->table_alias_name = 'wr';
		
		$this->view = array(
			'wechat_rule_keywords' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'wrk',
				'on'   	=> 	'wrk.rid = wr.id'
			),
		);
		
		parent::__construct();
	}

}

// end