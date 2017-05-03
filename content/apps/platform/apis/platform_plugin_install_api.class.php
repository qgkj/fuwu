<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 公众平台插件安装API
 * @author royalwang
 */
class platform_plugin_install_api extends Component_Event_Api 
{
	
	public function call(&$options) 
	{
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	        
	        $plugin_file = RC_Plugin::plugin_basename($plugin_file);
	        $plugin_dir = dirname($plugin_file);
	        
	        $plugins = ecjia_config::instance()->get_addon_config('platform_plugins', true);
	        $plugins[$plugin_dir] = $plugin_file;
	        
	        ecjia_config::instance()->set_addon_config('platform_plugins', $plugins, true);
	    }

	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        $format_description = $plugin_data['Description'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['ext_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('platform::platform.platform_plug_null_name'));
	        }
	    
	        $db = RC_Loader::load_app_model('platform_extend_model', 'platform');
	         
	        /* 检测支付名称重复 */
	        $data = $db->where("`ext_name` = '" . $format_name . "' and `ext_code` = '" . $options['config']['ext_code'] . "'")->count();
	        if ($data > 0) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('platform::platform.plug_exist'));
	        }
	         
	        /* 取得配置信息 */
	        $connect_config = serialize($options['config']['forms']);
	         
	        /* 安装，检查该支付方式是否曾经安装过 */
	        $count = $db->where("`ext_code` = '" . $options['config']['ext_code'] . "'")->count();
	         
	        if ($count > 0) {
	            /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
	            $data = array(
	                'ext_name' 		=> $format_name,
	                'ext_desc' 		=> $format_description,
	                'ext_config' 	=> $connect_config,
	                'enabled' 		=> 1
	            );
	             
	            $db->where("`ext_code` = '" . $options['config']['ext_code'] . "'")->update($data);
	             
	        } else {
	            /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
	            $data = array(
	                'ext_code' 		=> $options['config']['ext_code'],
	                'ext_name' 		=> $format_name,
	                'ext_desc' 		=> $format_description,
	                'ext_config' 	=> $connect_config,
	                'enabled' 		=> 1,
	            );
	            $db->insert($data);
	        }
	        
	        RC_Loader::load_app_func('global', 'platform');
	        assign_adminlog_content();
	    
	        /* 记录日志 */
	        ecjia_admin::admin_log($format_name, 'install', 'platform');
	        return true;
	    }
	}
}

// end