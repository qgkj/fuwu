<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class collect_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'collect_goods';
		$this->table_alias_name = 'c';
		
		//添加视图选项，方便调用
		$this->view = array(
			'goods' => array(
   				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
          		'alias'	=> 'g',
          		'field' => "g.original_img, g.goods_id, g.goods_name, g.market_price, g.shop_price, g.goods_thumb, g.goods_img, g.original_img, g.goods_brief, g.goods_type AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, g.promote_price, g.promote_start_date, g.promote_end_date, c.rec_id, c.is_attention, g.click_count",
        		'on' 	=> 'g.goods_id = c.goods_id',
			),
			'member_price' => array(
     	 		'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
       			'alias'	=> 'mp',
         		'on' 	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'",
          	)
		);
		
		parent::__construct();
	}
}

// end