<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class booking_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name 		= 'goods_attr';
		$this->table_alias_name = 'g';
		
		$this->view = array(
			'attribute' => array(
    			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
    			'alias'	=> 'a',
    			'on'   	=> 'g.attr_id = a.attr_id and g.goods_attr_id'
				)
		);
		parent::__construct();
	}
}

// end