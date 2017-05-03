<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_area_region_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	
	public function __construct() {
		$this->table_name = 'area_region';
		$this->table_alias_name	= 'a';
		
		$this->view = array(
			'region' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN, 
				'alias' => 'r',
				'on' 	=> 'a.region_id = r.region_id',
			)
		);
		parent::__construct();
	}
	
	public function shipping_region_select($where, $field='*', $join='') {
		if (!empty($join)) {
			return $this->join($join)->field($field)->where($where)->select();
		}
	}
}

// end