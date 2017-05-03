<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_collect_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name         = 'goods';
		$this->table_alias_name   = 'g';
		
		$this->view = array(
				'collect_goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	=> 'c',
				        'field' => "g.goods_id, g.goods_name, g.market_price, g.goods_thumb, IF(g.is_promote = 1 AND ".RC_Time::gmtime()." >= g.promote_start_date AND ".RC_Time::gmtime()." <= g.promote_end_date, g.promote_price, g.shop_price) AS goods_price",
						'on' 	=> 'g.goods_id = c.goods_id', 
				)
		);		
		parent::__construct();
	}
}

// end