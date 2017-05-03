<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_goods_comment_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'og';
		
		$this->view = array(			
		    'goods' 	=> array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'g',
// 		        'field'     => 'o.*,o.goods_price * o.goods_number AS subtotal,g.goods_thumb,g.original_img,g.goods_img',
		        'on' 		=> 'og.goods_id = g.goods_id'
		    ),
			'order_comment' => array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'oc',
		        'on' 		=> 'og.goods_id = oc.goods_id and og.order_id = oc.order_id'
		    ),
			'comment'  => array(
		        'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' 	=> 'c',
				'on' 		=> 'oc.comment_id = c.comment_id'
		    ),
		);	
		parent::__construct();
	}
}

// end