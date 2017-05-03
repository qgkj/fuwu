<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户帐号连接插件安装API
 * @author royalwang
 */
class connect_plugin_install_api extends Component_Event_Api {
	
	public function call(&$options) { 
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	        
	        $plugin_file = RC_Plugin::plugin_basename($plugin_file);
	        $plugin_dir  = dirname($plugin_file);
	        
	        $plugins               = ecjia_config::instance()->get_addon_config('connect_plugins', true);
	        $plugins[$plugin_dir]  = $plugin_file;
	        
	        ecjia_config::instance()->set_addon_config('connect_plugins', $plugins, true);
	    }

	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name        = $plugin_data['Name'];
	        $format_description = $plugin_data['Description'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['connect_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', __('帐号登录平台名称或connect_code不能为空'));
	        }
	    
	        $db = RC_Loader::load_app_model('connect_model', 'connect');
	         
	        /* 检测支付名称重复 */
	        $data = $db->where("`connect_name` = '" . $format_name . "' and `connect_code` = '" . $options['config']['connect_code'] . "'")->count();
	        if ($data > 0) {
	            return ecjia_plugin::add_error('plugin_install_error', __('帐号登录平台已存在'));
	        }
	         
	        /* 取得配置信息 */
	        $connect_config = serialize($options['config']['forms']);
	         
	        /* 安装，检查该支付方式是否曾经安装过 */
	        $count = $db->where("`connect_code` = '" . $options['config']['connect_code'] . "'")->count();
	         
	        if ($count > 0) {
	            /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
	            $data = array(
	                'connect_name' 		=> $format_name,
	                'connect_desc' 		=> $format_description,
	                'connect_config' 	=> $connect_config,
	                'enabled' 		    => 1
	            );
	             
	            $db->where("`connect_code` = '" . $options['config']['connect_code'] . "'")->update($data);
	             
	        } else {
	            /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
	            $data = array(
	                'connect_code' 		=> $options['config']['connect_code'],
	                'connect_name' 		=> $format_name,
	                'connect_desc' 		=> $format_description,
	                'connect_config' 	=> $connect_config,
	                'enabled' 		    => 1,
	            );
	            $db->insert($data);
	        }
	    
	        /* 记录日志 */
	        ecjia_admin::admin_log($format_name, 'install', 'connect');
	        return true;
	    }
	    
	    return false;
	}
	
}

// end