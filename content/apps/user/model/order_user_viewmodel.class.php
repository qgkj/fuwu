<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_user_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_info';
		$this->table_alias_name = 'o';

		$this->view = array(
			'users' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'u',
				'field'		=> 'o.order_sn, o.is_separate, (o.goods_amount - o.discount) AS goods_amount, o.user_id',
				'on'		=> 'o.user_id = u.user_id'				
			)
		);
		parent::__construct();
	}
}

// end