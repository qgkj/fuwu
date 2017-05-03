<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送方式安装API
 * @author royalwang
 */
class shipping_plugin_install_api extends Component_Event_Api 
{
	
	public function call(&$options) 
	{
	    
	    $plugin_data = array();
	    if (isset($options['file'])) {
			$plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	         
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	         
	        $plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
	        $plugins[$plugin_dir] = $plugin_file;
	    
	        ecjia_config::instance()->set_addon_config('shipping_plugins', $plugins, true);
	    }
	    
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        $format_description = $plugin_data['Description'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['shipping_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('shipping::shipping.no_shipping_name'));
	        }
	        
	        $insure = empty($options['config']['insure']) ? 0 : $options['config']['insure'];
	        
// 	        $shipping_data = $db->field(array('`shipping_id`','`print_bg`'))->find("`shipping_code` = '" . $options['config']['shipping_code'] . "'");
	        $shipping_data = RC_DB::table('shipping')->where('shipping_code', $options['config']['shipping_code'])->select('shipping_id', 'print_bg')->first();
	        
	        if ($shipping_data['shipping_id'] > 0) {
	            /* 该配送方式已经安装过, 将该配送方式的状态设置为 enable */
	            $data = array(
	                'shipping_name' => addslashes($format_name),
	                'shipping_desc' => addslashes($format_description),
            		'print_bg' 		=> $shipping_data['print_bg'],///????是不是应该是删除之前的
// 	                'print_bg' 		=> addslashes($options['config']['print_bg']),
	                'config_lable' 	=> addslashes($options['config']['config_lable']),
	                'print_model' 	=> $options['config']['print_model'],
	                'insure' 		=> $insure,
	                'support_cod' 	=> intval($options['config']['cod']),
	                'enabled' => 1,
	            );
// 	            $db->where("`shipping_code` = '" . $options['config']['shipping_code'] . "'")->update($data);
	            RC_DB::table('shipping')->where('shipping_code', $options['config']['shipping_code'])->update($data);
	        
	        } else {
	            /* 该配送方式没有安装过, 将该配送方式的信息添加到数据库 */
	            $data = array(
	                'shipping_code' => addslashes($options['config']['shipping_code']),
	                'shipping_name' => addslashes($format_name),
	                'shipping_desc' => addslashes($format_description),
	                'insure' 		=> $insure,
	                'support_cod' 	=> intval($options['config']['cod']),
	                'enabled' 		=> 1,
            		'print_bg' 		=> '',
// 	                'print_bg' 		=> addslashes($options['config']['print_bg']),
	                'config_lable' 	=> addslashes($options['config']['config_lable']),
	                'print_model' 	=> $options['config']['print_model'],
	            );
	            	
// 	            $id = $db->insert($data);
	            $id = RC_DB::table('shipping')->insertGetId($data);
	        }
	        
	        /* 记录管理员操作 */
	        ecjia_admin::admin_log(addslashes($format_name), 'install', 'shipping');
	        
	        return true;
	    }
	}
}

// end