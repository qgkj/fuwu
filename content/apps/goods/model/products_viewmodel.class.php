<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class products_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view =array();
	public function __construct() {
		$this->table_name = 'products';
		$this->table_alias_name	= 'p';

		$this->view = array(
			'package_goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'pg',
				'field' => 'p.product_id',
				'on'   	=> 'pg.product_id = p.product_id'
			)				
		);
		parent::__construct();
	}
}

// end