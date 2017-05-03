<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sys_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		
		$this->view = array(
				'collect_goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	=> 'c',
						'on' 	=> 'g.goods_id = c.goods_id', 
				),
				'users' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
						'alias'	=> 'u',
						'on' 	=> 'c.user_id = u.user_id', 
				)
		);		
		parent::__construct();
	}
}

// end