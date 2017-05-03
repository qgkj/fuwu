<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件调用工厂
 * @author royalwang
 */
class captcha_factory  {
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
			$captcha_plugins = ecjia_config::instance()->get_addon_config('captcha_plugins', true);
		    if (isset($captcha_plugins[$code])) {
		        RC_Plugin::load_files($captcha_plugins[$code]);
		    }
			$this->adapter_instance =  RC_Hook::apply_filters('captcha_factory_adapter_instance', null, $adapter_config);   //RC_Plugin::plugin_object($code);
			if ($this->adapter_instance)
				$this->adapter_instance->set_config($adapter_config);
		}
		return $this->adapter_instance;
	}
	
	public function __call($method_name, $method_args) {
		if (method_exists($this, $method_name))
			return call_user_func_array(array(& $this, $method_name), $method_args);
		elseif (
			!empty($this->adapter_instance)
			&& ($this->adapter_instance instanceof captcha_abstract)
			&& method_exists($this->adapter_instance, $method_name)
		) 
			return call_user_func_array(array(& $this->adapter_instance, $method_name), $method_args);
	}	
}

// end