<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class category_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'category';
		$this->table_alias_name = 'c';
		
		$this->view =array(
				'goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'field' => 'c.cat_id, c.cat_name, COUNT(g.goods_id) AS goods_count',
						'on' 	=> 'c.cat_id = g.cat_id '
				),
				'category' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'cc',
						'on' 	=> 'c.cat_id = cc.cat_id '
				)
		);
		
		parent::__construct();
	}
}

// end