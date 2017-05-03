<?php
  
defined('IN_ROYALCMS') or exit('No permission resources.');

class bonus_type_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'bonus_type';
		$this->table_alias_name	= 'bt';
		
		$this->view = array(
			'user_bonus' 	=> array(
				'type' 			=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' 		=> 'ub',
				'field' 		=> 'bt.type_id, bt.type_name, bt.type_money, ub.bonus_id',
				'on'   			=> 'bt.type_id = ub.bonus_type_id'
			),
			/*商家优惠红包*/
			'store_franchisee' 	=> array(
				'type' 			=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' 		=> 's',
				'on'   			=> 'bt.store_id = s.store_id'
			),
		);
		parent::__construct();
	}
	
	/*获取商家优惠红包列表*/
	public function seller_coupon_list($options) {
		$record_count = $this->join(array('store_franchisee', 'user_bonus'))->where($options['where'])->count('DISTINCT bt.type_id');
		//实例化分页
		$page_row = new ecjia_page($record_count, $options['size'], 6, '', $options['page']);
		$res = $this->join(array('store_franchisee', 'user_bonus'))->where($options['where'])->field('s.merchants_name, bt.*,ub.user_id')->group('bt.type_id')->limit($page_row->limit())->select();
		return array('coupon_list' => $res, 'page' => $page_row);
	}
}

// end