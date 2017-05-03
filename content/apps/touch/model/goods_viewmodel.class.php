<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->db_config  = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		$this->view = array(
				'auto_manage' => array(
						'type' 	   => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'	   => 'a',
						'on'	   => "g.goods_id = a.item_id AND a.type='goods'"
				),
				'category' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'c',
						'on'       => 'g.cat_id = c.cat_id'
				),
				'brand' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'b',
						'on'       => 'g.brand_id = b.brand_id '
				),
				'comment' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'r',
						'on'       => 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1'
				),
				'bonus_type' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'm',
						'on'       => 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . RC_Time::gmtime () . '" AND m.send_end_date >= "' . RC_Time::gmtime () . '"'
				),
				'goods_attr' => array (
					'type'         => Component_Model_View::TYPE_LEFT_JOIN,
					'alias'        => 'a',
					'on'           => 'g.goods_id = a.goods_id' 
					),
				'member_price'   => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'mp',
						'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
				),
				'link_goods'   => array(
						'type'     => Component_Model_View::TYPE_RIGHT_JOIN,
						'alias'    => 'lg',
						'on'       => 'g.goods_id = lg.link_goods_id'
				),
		 		'package_goods' => array(
		 				'type'     => Component_Model_View::TYPE_RIGHT_JOIN,
		 				'alias'    => 'pg',
		 				'on'       => 'pg.goods_id = g.goods_id ',
		 		),
	    		'products' => array(
	    				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
	    				'alias'    => 'p',
	    				'on'       => 'pg.product_id = p.product_id',
	    		),
				'collect_goods' => array(
						'type' 	   => Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	   => 'cg',
						'on' 	   => 'g.goods_id = cg.goods_id', 
				),
				'cart' => array(
						'type'     => Component_Model_View::TYPE_LEFT_JOIN,
						'alias'    => 'c',
						'on'       => 'g.goods_id =c.goods_id'
				)
		);
		parent::__construct();
	}

}

// end