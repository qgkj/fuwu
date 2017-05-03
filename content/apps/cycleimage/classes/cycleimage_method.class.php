<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件使用方法
 * @author royalwang
 */
class cycleimage_method  {
    
    //预设配置项存储key
    const STORAGEKEY_cycleimage_data    = 'cycleimage_data';
    const STORAGEKEY_cycleimage_style   = 'cycleimage_style';
    const STORAGEKEY_cycleimage_plugins = 'cycleimage_plugins';
    
	public function __construct() {}
	
	/**
	 * 获取所有可用的验证码
	 */
	public function cycle_list() {
		$plugins          = RC_Plugin::get_plugins();
		
		$captcha_plugins  = ecjia_config::instance()->get_addon_config(self::STORAGEKEY_cycleimage_plugins, true);
		
		$list = array();
		foreach ($captcha_plugins as $code => $plugin) {
		    if (isset($plugins[$plugin])) {
		        $list[$code]                          = $plugins[$plugin];
		        $list[$code]['code']                  = $code;
		        $list[$code]['format_name']           = $list[$code]['Name'];
		        $list[$code]['format_description']    = $list[$code]['Description'];
		        $list[$code]['screenshot'] 	          = RC_Plugin::plugin_dir_url($plugin) . '/preview.jpg';
		    }
		}

		return $list;
	}
	 
	/**
	 * 轮播广告图片数据
	 * @param bool $format
	 * @return Ambigous <string, multitype:Ambigous <mixed, ArrayObject, string> >
	 */
	public function player_data($format = false) {
		$playerdb = array();
	 	if (ecjia::config(self::STORAGEKEY_cycleimage_data, ecjia::CONFIG_EXISTS)) {
	 		$data = ecjia::config(self::STORAGEKEY_cycleimage_data);
	 		if (!empty($data)) {
		 		$data = unserialize($data);
		 		foreach ($data as $key => $val) {
		 			if (strpos($val['src'], 'http') === false) {
		 				$key += 1;
		 				$playerdb[$key] = $val;
		 				if ($format) {
		 					$playerdb[$key]['src'] = RC_Upload::upload_url() . '/' . ltrim($val['src'], '/');
		 				}
		 			}
		 		}
	 		}
	 	}
	 	return $playerdb;
	}

	/**
	 * 取得指定code的轮播图
	 * @param $code
	 */
	public function print_cycleimage_script($code) {
		echo $this->get_cycleimage_script($code);
	}
	
	
	public function get_cycleimage_script($code) {
	    if (empty($code)) {
	        $code = ecjia::config(self::STORAGEKEY_cycleimage_style);
	    }
	    
	    $cycleimage_plugins = ecjia_config::instance()->get_addon_config(self::STORAGEKEY_cycleimage_plugins, true);
	    if (isset($cycleimage_plugins[$code])) {
	        require_once SITE_PLUGIN_PATH . $cycleimage_plugins[$code];
	    }
	    
	    $script = RC_Hook::apply_filters('cycleimage_print_script', '', $this->player_data(true));
	    return $script;
	}
	
}

// end