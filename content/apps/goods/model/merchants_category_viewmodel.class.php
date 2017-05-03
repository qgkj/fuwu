<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_category_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_category';
		$this->table_alias_name = 'c';

		$this->view = array(
			'merchants_category' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 's',
					'on'    => 'c.cat_id = s.parent_id ',
			),
		);
		parent::__construct();
	}
}

// end
