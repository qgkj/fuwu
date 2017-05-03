<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 轮播图片程序
 */
class index extends ecjia_front {

	/**
	 * 析构函数
	 */
	public function __construct() {	
		parent::__construct();
		
  		RC_Loader::load_app_func('global');
  		
	}
	

	public function init() {
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Thu, 27 Mar 1975 07:38:00 GMT');
		header('Last-Modified: ' . date('r'));
		header('Pragma: no-cache');

		$code = trim($_GET['code']);
		
		$cycleimage = RC_Loader::load_app_class('cycleimage_method');
		
		$cycleimage->print_cycleimage_script($code);	
	}

}

// end
