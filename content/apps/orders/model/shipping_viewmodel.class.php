<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单统计数据模型
 */
class shipping_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'shipping';
		$this->table_alias_name = 'sp';
		
		$this->view = array(
			'order_info' => array(
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'=> 'i',
				'on'   => 'sp.shipping_id = i.shipping_id'
			),	
		);
		parent::__construct();
	}
}

// end