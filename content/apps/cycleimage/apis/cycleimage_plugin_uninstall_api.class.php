<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 轮播图卸载API
 * @author songqian
 */
class cycleimage_plugin_uninstall_api extends Component_Event_Api {
	
	public function call(&$options) {
	    if (isset($options['file'])) {
	        $plugin_file   = $options['file'];
	        $plugin_file   = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir    = dirname($plugin_file);
	    
	        $plugins       = ecjia_config::instance()->get_addon_config('cycleimage_plugins', true);
	        unset($plugins[$plugin_dir]);
	    
	        ecjia_config::instance()->set_addon_config('cycleimage_plugins', $plugins, true);
	    
	        return true;
	    }
	    
	    return false;
	}
}

// end