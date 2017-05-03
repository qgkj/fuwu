<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile extends ecjia_front {
	public function __construct() {	
		parent::__construct();	
		
  		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('templates/front', __FILE__));
	}
	
	public function info() {
		$article_info = RC_Api::api('article', 'article_info', array('id' => $_GET['id']));
		$this->assign('article_info', $article_info);
		$this->display('article_info.dwt');
	}
}

// end