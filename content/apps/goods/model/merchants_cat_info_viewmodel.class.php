<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_cat_info_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name         = 'merchants_category';
		$this->table_alias_name   = 'mc';
		
		$this->view = array(
				'merchants_shop_information' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	=> 'ms',
						'on' 	=> 'mc.user_id = ms.user_id', 
				),
		        'category' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	=> 'c',
						'on' 	=> 'mc.cat_id = c.cat_id', 
				),
		);		
		parent::__construct();
	}
}

// end