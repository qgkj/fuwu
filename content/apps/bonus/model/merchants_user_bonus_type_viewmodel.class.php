<?php
  
defined('IN_ROYALCMS') or exit('No permission resources.');

class merchants_user_bonus_type_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'bonus_type';
		$this->table_alias_name	= 'bt';
		
		$this->view = array(
			'seller_shopinfo' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'ssi',
				'on'   	=> 'ssi.id = bt.seller_id'
			)
		);
		parent::__construct();
	}
}

// end