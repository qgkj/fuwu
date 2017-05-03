<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class article_cat_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'article_cat';
		$this->table_alias_name = 'c';

		$this->view = array(
			'article_cat' => array(
				'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	's',
				'on'    => 	's.parent_id = c.cat_id',
			),
			'article' => array(
				'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 	'a',
				'on'   => 	'a.cat_id = c.cat_id'
			)
		);
		parent::__construct();
	}
}

// end