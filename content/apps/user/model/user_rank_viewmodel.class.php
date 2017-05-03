<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class user_rank_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'user_rank';
		$this->table_alias_name = 'r';
		
		$this->view =array(
			'member_price'		=> array(
				'type'			=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'			=> 'mp',
				'on'			=> 'mp.user_rank = r.rank_id '
		    ),
		);
		parent::__construct();
	}
}

// end