<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_article_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'goods_article';
		$this->table_alias_name = 'ga';
		
		$this->view = array(
			'goods' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
// 				'field' => 'g.goods_id, g.goods_name',
				'on'    => 'g.goods_id  = ga.goods_id',
			),
			'article' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'a',
				'on'    => 'ga.article_id = a.article_id'
			)
		);		
		parent::__construct();
	}
}

// end