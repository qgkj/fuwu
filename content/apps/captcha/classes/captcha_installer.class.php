<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class captcha_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.captcha';
        parent::__construct($id);
    }
    
    
    public function install() {
        if (!ecjia::config('captcha', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'captcha', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('captcha_width', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'captcha_width', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('captcha_height', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'captcha_height', '', array('type' => 'hidden'));
        }
    }
    
    
    public function uninstall() {
        if (ecjia::config('captcha', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('captcha');
        }
        if (ecjia::config('captcha_width', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('captcha_width');
        }
        if (ecjia::config('captcha_height', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('captcha_height');
        }
    }
    
}

// end