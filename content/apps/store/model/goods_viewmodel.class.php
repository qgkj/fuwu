<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		
		$this->view = array(
				'member_price' => array(
						'type' 	    => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'     => 'mp',
						'on' 	    => "mp.goods_id = g.goods_id and mp.user_rank = '$_SESSION[user_rank]'"
				),
				'warehouse_goods' => array(
				     	'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
					 	'alias'		=> 'wg',
					 	'on'		=> 'g.goods_id = wg.goods_id'
				),
				'warehouse_area_goods' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'wag',
						'on'		=> 'g.goods_id = wag.goods_id'
				),
		);
		parent::__construct();
	}
}

// end