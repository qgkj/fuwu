<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 地区切换程序
 */
class region extends ecjia_front {
	public function __construct() {
		parent::__construct();
	}
	
	
	public function init() {
		$db_region 	= RC_Model::model('shipping/region_model');
		$type      	= !empty($_GET['type'])   ? intval($_GET['type'])   : 0;
		$parent		= !empty($_GET['parent']) ? intval($_GET['parent']) : 0;
		
		$arr['regions'] = $db_region->get_regions($type, $parent);
		$arr['type']    = $type;
		$arr['target']  = !empty($_GET['target']) ? stripslashes(trim($_GET['target'])) : '';
		$arr['target']  = htmlspecialchars($arr['target']);
		
		echo json_encode($arr);
	}
}

// end