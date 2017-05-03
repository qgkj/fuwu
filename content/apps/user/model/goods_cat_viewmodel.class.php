<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_cat_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'goods_cat';
		$this->table_alias_name	= 'gc';
		
		$this->view = array(
				'goods' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'field' => 'gc.cat_id, COUNT(*)|goods_num',
						'on'   	=> 'g.goods_id = gc.goods_id'
				)				
		);
		parent::__construct();
	}
}

// end