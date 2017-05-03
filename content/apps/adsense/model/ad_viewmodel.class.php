<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ad_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'ad';
		$this->table_alias_name = 'ad';
		
		$this->view = array(
			'ad_position' => array(
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'p',
				'on' => 'p.position_id  = ad.position_id' 
			) 
		);
		parent::__construct();
	}
}

// end