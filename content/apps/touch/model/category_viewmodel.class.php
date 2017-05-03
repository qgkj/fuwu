<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class category_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->db_config        = RC_Config::load_config('database');
		$this->db_setting       = 'default';
		$this->table_name       = 'category';
		$this->table_alias_name = 'c';
		$this->view             = array(
				'cat_recommend' => array(
						'type' 	=> Component_Model_View::TYPE_INNER_JOIN,
						'alias' => 'cr',
						'on' 	=> "cr.cat_id = c.cat_id"
				)
		);
		parent::__construct();
	}
}

// end