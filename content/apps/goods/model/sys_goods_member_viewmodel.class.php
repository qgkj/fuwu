<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sys_goods_member_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name = 'g';
		
		$this->view = array(
			'member_price' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'field' => "g.promote_price, g.promote_start_date, g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') AS shop_price",
				'on'   	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
			)				
		);
		parent::__construct();
	}
}

// end