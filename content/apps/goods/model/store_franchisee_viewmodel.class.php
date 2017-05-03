<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class store_franchisee_viewmodel extends Component_Model_View {
    public $table_name = '';
	public $view =array();
	public function __construct() {
		$this->table_name = 'store_franchisee';
        $this->table_alias_name = 'sf';

        $this->view = array(
			'store_category' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'sc',
				'on'   	=> 'sf.cat_id = sc.cat_id'
			),
            'collect_store' => array(
                'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'cs',
				'on'   	=> 'cs.store_id = sf.store_id'
            )
		);
		parent::__construct();
	}
}

// end
