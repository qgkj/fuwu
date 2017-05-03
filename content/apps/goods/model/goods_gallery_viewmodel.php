<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_gallery_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name         = 'goods_gallery';
		$this->table_alias_name   = 'album';
		
		$this->view = array(
				'goods' => array(
						'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,  
						'alias'	=> 'g',
						'on' 	=> 'album.goods_id = g.goods_id', 
				)
		);		
		parent::__construct();
	}
}

// end