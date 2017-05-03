<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class delivery_order_suppliers_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'delivery_order';
		$this->table_alias_name	= 'do';
		
		$this->view = array(
			'suppliers' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 's',
				'on'    => 'do.suppliers_id = s.suppliers_id',
			),
		);
		parent::__construct();
	}
}

// end
