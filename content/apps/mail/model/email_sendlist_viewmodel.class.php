<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class email_sendlist_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'email_sendlist';
		$this->table_alias_name = 'e';
		
		//添加视图选项，方便调用
		
		$this->view = array(
			'mail_templates' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
				'alias'	=> 'm',
				'field'	=> "e.id, e.email, e.pri, e.error, FROM_UNIXTIME(e.last_send) AS last_send, m.template_subject, m.type",
				'on' 	=> 'e.template_id = m.template_id', 
			)
		);
		
		parent::__construct();
	}
	
	public function email_sendlist_find($id) {
		return $this->where(array('id' => $id))->find();
	}
	
	public function email_sendlist_select($ids) {
		return $this->in(array('id' => $ids))->select();
	}
	
	public function email_sendlist_count($option) {
		return $this->join($option['table'])->where($option['where'])->count($option['count']);
	}
	
	public function email_sendlist($option) {
		return $this->join($option['table'])->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
	}

}

// end