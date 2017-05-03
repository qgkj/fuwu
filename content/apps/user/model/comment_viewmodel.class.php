<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class comment_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'comment';
		$this->table_alias_name = 'c';
		
		//添加视图选项，方便调用
		$this->view = array(
				'comment' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
						'alias'	=> 'r',
						'field' => 'c.*, g.goods_name AS cmt_name, r.content AS reply_content, r.add_time AS reply_time',
						'on' 	=> 'r.parent_id = c.comment_id AND r.parent_id > 0', 
				),
				'goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	=> 'g',
						'on'	=> 'c.comment_type=0 AND c.id_value = g.goods_id',
				)
		);
		parent::__construct();
	}
}

// end