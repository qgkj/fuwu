<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class virtual_card_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'virtual_card';
		$this->table_alias_name = 'vc';
		
		$this->view = array(
			'goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
// 				'field' => 'vc.card_id, vc.goods_id, g.goods_name,vc.card_sn, vc.card_password, vc.end_date, vc.crc32',
				'on' 	=> 'vc.goods_id = g.goods_id'
			)
		);		
		parent::__construct();
	}
}

// end