<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	
	public function __construct() {
		$this->table_name = 'shipping';
		$this->table_alias_name	= 's';
		
		$this->view = array(
			'shipping_area' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'a',
				'on' 	=> 'a.shipping_id = s.shipping_id ', 
			),
			'area_region' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'r',
				'on' 	=> 'r.shipping_area_id = a.shipping_area_id ',
			)
		);
		parent::__construct();
	}
	
	public function shipping_area_find($where, $field='*', $join='') {
		if (!empty($join)) {
			return $this->join($join)->field($field)->find($where);
		}
	}
}

// end