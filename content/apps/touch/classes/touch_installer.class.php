<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('touch', 'touch', false);
class touch_installer  extends ecjia_installer {

    protected $dependent = array(
        'ecjia.touch'    => '1.0',
    );

    public function __construct() {
        $id = 'ecjia.touch';
        parent::__construct($id);
    }

    public function install() {
        if (!ecjia::config(touch::STORAGEKEY_template, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', touch::STORAGEKEY_template, '', array('type' => 'hidden'));
        }
        if (!ecjia::config(touch::STORAGEKEY_stylename, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', touch::STORAGEKEY_stylename, '', array('type' => 'hidden'));
        }

        if (!ecjia::config(touch::STORAGEKEY_map_qq_referer, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('wap', touch::STORAGEKEY_map_qq_referer, '', array('type' => 'text', 'sort_order' => 2));
        }
        
        if (!ecjia::config(touch::STORAGEKEY_map_qq_key, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('wap', touch::STORAGEKEY_map_qq_key, '', array('type' => 'text', 'sort_order' => 3));
        }
       
        return true;
    }

    public function uninstall() {

        if (ecjia::config(touch::STORAGEKEY_template, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(touch::STORAGEKEY_template);
        }
        if (ecjia::config(touch::STORAGEKEY_stylename, ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config(touch::STORAGEKEY_stylename);
        }
        
        if (ecjia::config(touch::STORAGEKEY_map_qq_referer, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config(touch::STORAGEKEY_map_qq_referer);
        }
        
        if (ecjia::config(touch::STORAGEKEY_map_qq_key, ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config(touch::STORAGEKEY_map_qq_key);
        }
       
        return true;
    }
}

// end
