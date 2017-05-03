<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class region_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'region';
		parent::__construct ();
	}
	
	/**
	 * 获得指定国家的所有省份
	 * @access public
	 * @param
	 * int country 国家的编号
	 * @return array
	 */
	function get_regions($type = 0, $parent = 0) {
		return $this->field ( 'region_id, region_name' )->where (array('region_type' => $type, 'parent_id' => $parent))->select();
	}
}

// end