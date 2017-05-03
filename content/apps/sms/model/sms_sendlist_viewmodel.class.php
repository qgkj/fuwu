<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_sendlist_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'sms_sendlist';
		$this->table_alias_name = 'e';
		
		//添加视图选项，方便调用
		
		$this->view = array(
			'mail_templates' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
				'alias'	=> 'm',
				'field'	=> "e.id, e.mobile,e.sms_content, e.pri, e.last_send, e.error, m.template_subject, m.type",
				'on' 	=> 'e.template_id = m.template_id', 
			)
		);
		
		parent::__construct();
	}

}

// end