<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class payment_order_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	
	public function __construct() {
		$this->table_name = 'payment';
		$this->table_alias_name = 'p';
		
		$this->view = array(
			'order_info' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'i',
				'field' => 'i.pay_id, p.pay_name, i.pay_time, COUNT(i.order_id) AS order_num',
				'on'  	=> 'p.pay_id = i.pay_id',
			)
		);
		parent::__construct();
	}
}

// end