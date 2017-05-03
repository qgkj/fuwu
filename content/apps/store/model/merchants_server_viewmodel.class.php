<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchants_server_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_server';
		$this->table_alias_name = 's';
		
		$this->view =array(
			'merchants_shop_information' => array( 
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'mis',
					'field' => '',
					'on'    => 's.user_id = mis.user_id'				
			),
			'users' => array( 
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'u',
					'on'    => 's.user_id = u.user_id'				
			),
			'merchants_steps_fields' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'msf',
					'on'    => 's.user_id = msf.user_id'
			),
			'merchants_percent' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'mp',
					'on'    => 'mp.percent_id = s.suppliers_percent'
			)
		);
		parent::__construct();
	}
}

// end