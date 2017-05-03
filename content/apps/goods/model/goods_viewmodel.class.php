<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		$this->view = array(
			'goods_attr' => array (
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'a',
				'on' 	=> 'g.goods_id = a.goods_id'
			),
			'category' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'c',
				'on'    => 'g.cat_id = c.cat_id'
			),
			'brand' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'b',
				'on'	=> 'g.brand_id = b.brand_id'
			),
			'attribute' => array (
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'a',
				'on' 	=> 'g.goods_type = a.cat_id'
			),
            'member_price' 	=> array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'mp',
				'on' 	=> "mp.goods_id = g.goods_id AND mp.user_rank = ".$_SESSION['user_rank'],
			),
		);
		parent::__construct();
	}
}

// end
