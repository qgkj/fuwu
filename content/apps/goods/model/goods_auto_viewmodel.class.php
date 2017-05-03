<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_auto_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods';
		$this->table_alias_name	= 'g';
		
		$this->view = array(
			'auto_manage' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'a',
				'field'	=> 'g.*,a.starttime,a.endtime',
				'on'	=> "g.goods_id = a.item_id AND a.type='goods'"
			)
		);		
		parent::__construct();
	}
}

// end