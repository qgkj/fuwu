<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cat_recommend_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'cat_recommend';
		$this->table_alias_name = 'cr';
		
		$this->view = array(
				'category' => array(
						'type'  => Component_Model_View::TYPE_INNER_JOIN,
						'alias' => 'c',
						'field' => 'c.cat_id, c.cat_name, cr.recommend_type',
						'on'   	=> 'cr.cat_id = c.cat_id'
				)				
		);	
		parent::__construct();
	}
}

// end