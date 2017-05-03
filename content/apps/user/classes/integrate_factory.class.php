<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件调用工厂
 * @author royalwang
 */
class integrate_factory  {
	private $adapter_instance 	= null;
	
	public function __construct($adapter_name = '', $adapter_config = array()) {
		$this->set_adapter($adapter_name, $adapter_config);
	}
	
	/**
	 * 构造适配器
	 * @param  $adapter_name 适配器code
	 * @param  $adapter_config 适配器配置
	 */
	public function set_adapter($adapter_name, $adapter_config = array()) {
		if (!is_string($adapter_name)) 
			return false;
		else {
			$code = strtolower($adapter_name);
			$integrate_plugins = ecjia_config::instance()->get_addon_config('user_integrate_plugins', true);
		    if (isset($integrate_plugins[$code])) {
		        RC_Plugin::load_files($integrate_plugins[$code]);
		    }
			$this->adapter_instance =  RC_Hook::apply_filters('integrate_factory_adapter_instance', null, $adapter_config);
		}
		return $this->adapter_instance;
	}
	
	public function __call($method_name, $method_args) {
		if (method_exists($this, $method_name)) {
		    return call_user_func_array(array(&$this, $method_name), $method_args);
		} elseif (
			!empty($this->adapter_instance)
			&& ($this->adapter_instance instanceof integrate_abstract)
			&& method_exists($this->adapter_instance, $method_name)
		) {
		    return call_user_func_array(array(& $this->adapter_instance, $method_name), $method_args);
		}	
	}	
}

// end