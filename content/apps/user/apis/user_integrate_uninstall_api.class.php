<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员整合插件卸载API
 * @author royalwang
 */
class user_integrate_uninstall_api extends Component_Event_Api {
	
	public function call(&$options) {
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir  = dirname($plugin_file);
	         
	        $plugins = ecjia_config::instance()->get_addon_config('user_integrate_plugins', true);	        
	        unset($plugins[$plugin_dir]);
	         
	        ecjia_config::instance()->set_addon_config('user_integrate_plugins', $plugins, true);
	         
	        return true;
	    }
	     
	    return false;
	}
}

// end