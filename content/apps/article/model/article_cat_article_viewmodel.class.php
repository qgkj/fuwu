<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class article_cat_article_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'article_cat';
		$this->table_alias_name = 'a';

		$this->view = array(
			'article_cat' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'b',
				'field' => 'a.cat_id, a.cat_name, a.sort_order AS parent_order, a.cat_id, b.cat_id AS child_id, b.cat_name AS child_name, b.sort_order AS child_order',
				'on'    => 'b.parent_id = a.cat_id',
			)
		);
		parent::__construct();
	}
}

// end