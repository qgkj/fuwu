<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

abstract class ecjia_installer {

	protected $dependent = array();
	
	public function __construct($id) {
		$this->id	 	= $id;
		$this->dir 		= ecjia_app::get_app_dir($id);
		$this->info 	= RC_App::get_app_package($this->dir);
	}
	
	
	public function package() {
		return $this->info;
	}
	
	
	/**
	 * 应用安装依赖提示
	 */
	public function dependent() {
		return true;
	}
	
	/**
	 * 应用安装控制器
	 */
	abstract public function install();
	
	/**
	 * 应用卸载控制器
	 */
	abstract public function uninstall();
	
	/**
	 * 应用升级控制器
	 */
	public function upgrade() {
		
	}
	
}

// end