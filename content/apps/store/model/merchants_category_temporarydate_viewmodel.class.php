<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_category_temporarydate_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_category_temporarydate';
		$this->table_alias_name = 'mct';
		
		$this->view =array(
				'category' => array( 
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'c',
						'field' => '',
						'on'    => 'mct.cat_id = c.cat_id'				
				),
		);
		parent::__construct();
	}
}

// end