<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_activity_package_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods_activity';
		$this->table_alias_name = 'ga';
		
		$this->view = array(
			'package_goods' => array(
				'type' 		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' 	=> 'pg',
			    'field'     => 'pg.goods_id, ga.act_id, ga.act_name, ga.act_desc, ga.goods_name, ga.start_time,ga.end_time, ga.is_finished, ga.ext_info',
				'on' 		=> 'pg.package_id = ga.act_id'
		    )
		);	
		parent::__construct();
	}
}

// end