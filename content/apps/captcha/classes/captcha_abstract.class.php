<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件抽象类
 * @author royalwang
 */
abstract class captcha_abstract {

	protected $config = array();
	
	public function __construct($config = array()) {
		$this->config = array_merge($this->config, $config);
	}
	
	/**
	 * 使用 $this->name 获取配置
	 * @param  string $name 配置名称
	 * @return multitype    配置值
	 */
	public function __get($name) {
		return $this->config[$name];
	}
	
	public function __set($name, $value) {
		if(isset($this->config[$name])) {
			$this->config[$name] = $value;
		}
	}
	
	public function __isset($name) {
		return isset($this->config[$name]);
	}

	public function set_config($config) {
		$this->config = array_merge($this->config, $config);
		return $this;
	}

	abstract public function generate_image();

	abstract public function verify_word($word);

}

// end