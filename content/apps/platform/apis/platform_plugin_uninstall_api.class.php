<?php
  

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 公众平台插件卸载
 * @author royalwang
 */
class platform_plugin_uninstall_api extends Component_Event_Api 
{
	public function call(&$options) 
	{
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	         
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	    
	        $plugins = ecjia_config::instance()->get_addon_config('platform_plugins', true);
	        unset($plugins[$plugin_dir]);
	    
	        ecjia_config::instance()->set_addon_config('platform_plugins', $plugins, true);
	    }
	     
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	    
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['ext_code'])) {
	            return ecjia_plugin::add_error('plugin_uninstall_error', RC_Lang::get('platform::platform.platform_plug_null_name'));
	        }
	    
	        RC_Loader::load_app_func('global', 'platform');
	        assign_adminlog_content();
	        
	        /* 从数据库中删除支付方式 */
	        $db = RC_Loader::load_app_model('platform_extend_model', 'platform');
	        $db->where("`ext_code` = '" . $options['config']['ext_code'] . "'")->delete();
	    
	        /* 记录日志 */
	        ecjia_admin::admin_log($format_name, 'uninstall', 'platform');
	    
	        return true;
	    }
	    
	    return false;
	}
}

// end