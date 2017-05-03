<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_config {
	private $config	= array();
	private $db_config;
	
	private static $instance = null;
	
	/**
	 * 返回当前终级类对象的实例
	 *
	 * @param $cache_config 缓存配置
	 * @return object
	 */
	public static function instance() {
	    if (self::$instance === null) {
	        self::$instance = new self();
	    }
	    return self::$instance;
	}
	
	public function __construct() {
		try {
		    $this->db_config = RC_Loader::load_model('shop_config_model');
		    $this->config = $this->_load_config();
		} catch(Exception $e) {
		}
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	public function load_config() {
		return RC_Hook::apply_filters('set_ecjia_config_filter', $this->config);
	}
	
	/**
	 * 清除配置文件缓存
	 */
	public function clear_cache() {
	    RC_Cache::app_cache_delete('shop_config', 'system');
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	private function _load_config($force = false) {
		$arr = array();
		$data = RC_Cache::app_cache_get('shop_config', 'system');
		if (empty($data) || $force) {
// 			$res = $this->db_config->field('`code`, `value`')->where('`parent_id` > 0')->select();
			$res = RC_DB::table('shop_config')->select('code', 'value')->where('parent_id', '>', 0)->get();
			if (!empty($res)) {
				foreach ($res AS $row) {
					$arr[$row['code']] = $row['value'];
				}
			}
			RC_Cache::app_cache_set('shop_config', $arr, 'system');
		} else {
			$arr = $data;
		}

		return $arr;
	}
	
	/**
	 * 检查配置项是否存在
	 * @param unknown $code
	 * @return boolean
	 */
	public function check_config($code) {
		$data = $this->load_config();

		if (isset($data[$code])) {
			return true;
		}

		return false;
	}
	
	/**
	 * 判断配置项值是否空, 为空是
	 * @param unknown $code
	 */
	public function check_exists($code) {
		$data = $this->load_config();

		if (isset($data[$code]) && !empty($data[$code])) {
			return true;
		}

		return false;
	}
	
	/**
	 * 读取某项配置
	 * @param unknown $code
	 * @return unknown|boolean
	 */
	public function read_config($code) {
		if ($this->check_config($code)) {
			$data = $this->load_config();
			return $data[$code];
		}

		return false;
	}
	
	
	/**
	 * 写入某项配置
	 * @param unknown $code
	 * @param unknown $value
	 */
	public function write_config($code, $value) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 		$rs = $this->db_config->where(array('code' => $code))->update(array('value' => $value));
		$rs = RC_DB::table('shop_config')->where('code', $code)->update(array('value' => $value));
		if ($rs) {
		    $this->clear_cache();
		    return true;
		}

		return false;
	}
	
	
	/**
	 * 插入一个配置信息
	 *
	 * @access  public
	 * @param   string      $parent     分组的code
	 * @param   string      $code       该配置信息的唯一标识
	 * @param   string      $value      该配置信息值
	 * @return  void
	 */
	public function insert_config($parent, $code, $value, $options = array()) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 		$parent_id = $this->db_config->where("`code` = '$parent' AND `parent_id` = 0")->get_field('id');
		$parent_id = RC_DB::table('shop_config')->where('code', $parent)->where('parent_id', 0)->pluck('id');
		$data = array(
				'parent_id' => $parent_id,
				'code' 		=> $code,
				'value' 	=> $value,
		);

		if (isset($options['type'])) {
			$data['type'] = $options['type'];
		}

		if (isset($options['store_range'])) {
			$data['store_range'] = $options['store_range'];
		}

		if (isset($options['store_dir'])) {
			$data['store_dir'] = $options['store_dir'];
		}

		if (isset($options['sort_order'])) {
			$data['sort_order'] = $options['sort_order'];
		}

		$this->db_config->insert_ignore($data);
		
		$this->clear_cache();
	}
	
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_config($code) {
	    if (!is_a($this->db_config, 'shop_config_model')) {
	        return null;
	    }
	    
// 	    $rs = $this->db_config->where(array('code' => $code))->delete();
	    $rs = RC_DB::table('shop_config')->where('code', $code)->delete();
	    if ($rs) {
	        $this->clear_cache();
	        return true;
	    }
	    
	    return false;
	}
	
	public function add_group($code, $id = null) {
	    $data = array(
	        'parent_id' => 0,
	        'code' 		=> $code,
	        'type' 	    => 'group',
	    );
	    
	    if ($id) {
	        $data['id'] = intval($id);
	    }
	    
	    $this->db_config->insert_ignore($data);
	}
	
	/**
	 * 载入全部配置信息
	 *
	 * @access  public
	 * @return  array
	 */
	private function _load_group($force = false) {
	    $arr = array();
	    $data = RC_Cache::app_cache_get('shop_config_group', 'system');
	    if (empty($data) || $force) {
	        $res = RC_DB::table('shop_config')->select('code', 'value')->where('parent_id', 0)->where('type', 'group')->get();
	        if (!empty($res)) {
	            foreach ($res AS $row) {
	                $arr[$row['code']] = $row['id'];
	            }
	        }
	        RC_Cache::app_cache_set('shop_config_group', $arr, 'system');
	    } else {
	        $arr = $data;
	    }
	
	    return $arr;
	}
	
	/**
	 * 检查配置项是否存在
	 * @param unknown $code
	 * @return boolean
	 */
	public function check_group($code) {
	    $data = $this->load_group();
	
	    if (isset($data[$code])) {
	        return true;
	    }
	
	    return false;
	}
	
	public function load_group()
	{
	    return RC_Hook::apply_filters('set_ecjia_config_filter', $this->_load_group());
	}
	
	/**
	 * 读取某项配置
	 * @param unknown $code
	 * @return unknown|boolean
	 */
	public function read_group($code) {
	    if ($this->check_group($code)) {
	        $data = $this->load_group();
	        return $data[$code];
	    }
	
	    return false;
	}
	
	/**
	 * 删除配置项
	 * @param string $code
	 */
	public function delete_group($code) {
	    return $this->delete_config($code);
	}
		
		
	/**
	 * 获取插件的配置项
	 * addon_app_actives
	 * addon_plugin_actives
	 * addon_widget_actives
	 * @param string $type
	 * @param string $code
	 * @param string|array $value
	 */
	public function get_addon_config($code, $unserialize = false, $use_platform = false) {   
	    if ($use_platform) {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    } else {
	        $code = 'addon_' . $code;
	    }  
	    
	    if ($this->check_config($code)) {
	    	$value = $this->read_config($code);
	    } else {
	        $this->insert_config('hidden', $code, '', array('type' => 'hidden'));
	        $value = '';
	    }
	    if ($unserialize) {
	        $value or $value = serialize(array());
	        $value = unserialize($value);
	    }
	    return $value;
	}
		
	/**
	 * 更新插件的配置项
	 * addon_app_actives
	 * addon_plugin_actives
	 * addon_widget_actives
	 * @param string $type
	 * @param string $code
	 * @param string|array $value
	 */
	public function set_addon_config($code, $value, $serialize = false, $use_platform = false) {
	  if ($use_platform) {
	        $code = 'addon_' . ecjia::current_platform() . '_' . $code;
	    } else {
	        $code = 'addon_' . $code;
	    } 
	    
	    if ($serialize) {
	        $value or $value = array();
	    	$value = serialize($value);
	    }
	    $data = $this->_load_config(true);
	    if (isset($data[$code])) {
	        $this->write_config($code, $value);
	    } else {
	        $this->insert_config('hidden', $code, $value, array('type' => 'hidden'));
	    }
	}
		
}


// end