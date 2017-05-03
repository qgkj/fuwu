<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class push_event_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'push_event';
		$this->table_alias_name = 'pe';
		
		$this->view =array(
				'mobile_manage' => array( 
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'mm',
						'on'    => 'mm.app_id = pe.app_id'				
				),
				'mail_templates' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'mt',
						'on'    => 'mt.template_id = pe.template_id and type="push"',
				),
		);
		
		
		parent::__construct();
	}
}

// end