<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cart_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name       = 'cart';
		$this->table_alias_name = 'c';
		
		//定义视图选项
		$this->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on'    => 'c.goods_id = g.goods_id'
			),
			'cart' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'cb',
				'on'    => 'c.goods_id = cb.parent_id'
			),
			'member_price'   => array(
				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'    => 'mp',
				'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
			),
			'group_goods'	=> array(
				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'    => 'gg',
				'on'       => 'c.goods_id = gg.goods_id'
			),
			'bonus_type'	=> array(
				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'    => 'bt',
				'on'       => 'g.bonus_type_id = bt.type_id'
			)
		);
		parent::__construct();
	}
}

// end