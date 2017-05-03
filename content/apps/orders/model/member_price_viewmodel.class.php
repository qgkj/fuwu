<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class member_price_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'member_price';
		$this->table_alias_name	= 'mp';

		$this->view = array(
			'user_rank' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'r',
				'field' => 'mp.user_price, r.rank_name',
				'on'    => 'mp.user_rank  = r.rank_id',
			),
		);		
		parent::__construct();
	}
}

// end