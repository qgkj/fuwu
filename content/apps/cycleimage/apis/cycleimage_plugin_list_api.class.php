<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 轮播图插件列表API
 * @author songqian
 */
class cycleimage_plugin_list_api extends Component_Event_Api {
	
	public function call(&$options) {
		
// 		$db = RC_Loader::load_model('addons_model');
		
// 		$data = $db->where(array('subjection' => 'cycleimage', 'enabled' => 1))->select();

// 		$list = array();
// 		if ($data) {
// 			foreach ($data as $value) {
// 				RC_Lang::load_plugin($value['directory']);
// 				$plugin = RC_Plugin::plugin_info($value['identifier']);
// 				$value['name'] 			= $plugin['plugin']['format_name'];
// 				$value['description'] 	= $plugin['plugin']['format_description'];
// 				$value['code'] 			= $value['identifier'];
// 				//$value['screenshot'] 	= _FILE_PLUGIN($value['directory']) . 'preview.jpg';
// 				$value['screenshot'] 	= RC_Plugin::plugin_dir_url($value['directory'].'/preview.jpg');
// 				$list[$value['identifier']] = $value;
// 				unset($plugin);
// 			}
// 		}

// 		return $list;
	}
}

// end