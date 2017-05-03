<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 验证码安装API
 * @author royalwang
 */
class captcha_plugin_install_api extends Component_Event_Api {
	
	public function call(&$options) { 
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	        
	        $plugins = ecjia_config::instance()->get_addon_config('captcha_plugins', true);
	        $plugins[$plugin_dir] = $plugin_file;
	        
	        ecjia_config::instance()->set_addon_config('captcha_plugins', $plugins, true);
	        
	        return true;
	    }
	    
	    return false;
	}
}

// end