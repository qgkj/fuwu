<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_activity_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods_activity';
		$this->table_alias_name = 'ga';
		
		$this->view = array(
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on' 	=> 'ga.goods_id =g.goods_id'
			),
		    'store_franchisee' => array(
		        'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
		        'alias' => 'ssi',
		        'on' 	=> 'ssi.store_id =g.store_id'
		    )
		);
		
		parent::__construct();
	}
}

// end