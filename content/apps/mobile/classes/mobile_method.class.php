<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件使用方法
 * @author royalwang
 */
class mobile_method  {
    
    //预设配置项存储key
    const STORAGEKEY_shortcut_data          = 'mobile_shortcut_data';
    const STORAGEKEY_discover_data          = 'mobile_discover_data';
    const STORAGEKEY_cycleimage_data        = 'mobile_cycleimage_data';
    const STORAGEKEY_cycleimage_phone_data  = 'mobile_cycleimage_phone_data';
	
	public function __construct() {
		
	}
	 
	/**
	 * 轮播广告图片数据
	 * @param bool $format
	 * @return Ambigous <string, multitype:Ambigous <mixed, ArrayObject, string> >
	 */
	public function shortcut_data($format = false) {
		$playerdb = array();
	 	if (ecjia::config(self::STORAGEKEY_shortcut_data, ecjia::CONFIG_EXISTS)) {
	 		$data = ecjia::config(self::STORAGEKEY_shortcut_data);
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
	 * 百宝箱图片数据
	 * @param bool $format
	 * @return Ambigous <string, multitype:Ambigous <mixed, ArrayObject, string> >
	 */
	public function discover_data($format = false) {
		$playerdb = array();
		if (ecjia::config(self::STORAGEKEY_discover_data, ecjia::CONFIG_EXISTS)) {
			$data = ecjia::config(self::STORAGEKEY_discover_data);
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
	 * 移动端banner数据
	 * @param bool $format
	 * @return Ambigous <string, multitype:Ambigous <mixed, ArrayObject, string> >
	 */
	public function cycleimage_data($format = false) {
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
	 * 移动端banner数据
	 * @param bool $format
	 * @return Ambigous <string, multitype:Ambigous <mixed, ArrayObject, string> >
	 */
	public function cycleimage_phone_data($format = false) {
		$playerdb = array();
		if (ecjia::config(self::STORAGEKEY_cycleimage_phone_data, ecjia::CONFIG_EXISTS)) {
			$data = ecjia::config(self::STORAGEKEY_cycleimage_phone_data);
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
	 * 保证shortcut存储结构正确
	 * @param array $array
	 *             array(
	 *                 'src' => '',
	 *                 'url' => '',
	 *                 'text'=> '',
	 *                 'sort'=> '',
	 *                 'display' => '',
	 *             )
	 * @return array
	 */
	public function shortcut_struct($array) {
	    $shortcut_struct = array();
	    $shortcut_struct['src'] = isset($array['src']) ? $array['src'] : '';
	    $shortcut_struct['url'] = isset($array['url']) ? $array['url'] : '';
	    $shortcut_struct['text'] = isset($array['text']) ? $array['text'] : '';
	    $shortcut_struct['sort'] = isset($array['sort']) ? $array['sort'] : 0;
	    $shortcut_struct['display'] = isset($array['display']) ? $array['display'] : 1;
	    return $shortcut_struct;
	}
	 		
    /**
     * 对shortcut data按sort进行排序
     */
	public function shortcut_sort($flashdb) {
	    $flashdb_sort   = array();
	    $_flashdb       = array();
	    foreach ($flashdb as $key => $value) {
	        $flashdb_sort[$key] = $value['sort'];
	    }
	    asort($flashdb_sort, SORT_NUMERIC);
	    	
	    foreach ($flashdb_sort as $key => $value) {
	        $_flashdb[] = $flashdb[$key];
	    }
	    unset($flashdb, $flashdb_sort);
	    
	    return $_flashdb;
	}
	
}

// end