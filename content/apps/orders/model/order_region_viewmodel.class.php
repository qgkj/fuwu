<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_region_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'order_info';
		$this->table_alias_name	= 'o';
		
		$this->view = array(
	 		'region' => array(
		     	'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'c',
			 	'on'   => 'o.country = c.region_id'				
			),
			'region as p' => array(
			 	'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'on'   => 'o.province = p.region_id'
			),
			'region as t' => array(
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'on'   => 'o.city = t.region_id'
			),
			'region as d' => array(
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'on'   => 'o.district = d.region_id'
			)
    	);	
		parent::__construct();
	}
}

// end