<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_brand_member_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
        $this->table_name = 'goods';
        $this->table_alias_name = 'g';

        $this->view = array(
            'brand' => array(
                'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'b',
                'field' => "g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.shop_price AS org_price, g.promote_price, IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, goods_img, g.original_img, b.brand_name",
                'on' 	=> 'b.brand_id = g.brand_id '
            ),
            'member_price' => array(
                'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'mp',
                'on' 	=> "mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
            )
        );
        parent::__construct();
    }
}

// end