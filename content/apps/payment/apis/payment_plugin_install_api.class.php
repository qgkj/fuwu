<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 支付方式安装API
 * @author royalwang
 */
class payment_plugin_install_api extends Component_Event_Api {
	
	public function call(&$options) {
	    $plugin_data = array();
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	        
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	        
	        $plugins = ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
	        $plugins[$plugin_dir] = $plugin_file;
	         
	        ecjia_config::instance()->set_addon_config('payment_plugins', $plugins, true, true);
	    }
	   
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        $format_description = $plugin_data['Description'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['pay_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('payment::payment.plugin_install_error'));
	        }
	       
// 	        $db = RC_Loader::load_app_model('payment_model', 'payment');
	        
	        /* 检测支付名称重复 */
// 	        $data = $db->where("`pay_name` = '" . $format_name . "' and `pay_code` = '" . $options['config']['pay_code'] . "'")->count();
	        $data = RC_DB::table('payment')->where('pay_name', $format_name)->where('pay_code', $options['config']['pay_code'])->count();
	        
	        if (!$data) {
	            /* 取得配置信息 */
	            $pay_config = serialize($options['config']['forms']);
	             
	            /* 取得和验证支付手续费 */
	            $pay_fee    = empty($options['config']['pay_fee']) ? 0 : $options['config']['pay_fee'];
	             
	            /* 安装，检查该支付方式是否曾经安装过 */
// 	            $count = $db->where("`pay_code` = '" . $options['config']['pay_code'] . "'")->count();
	         	$count = RC_DB::table('payment')->where('pay_code', $options['config']['pay_code'])->count();
	         	
	            if ($count > 0) {
	                /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
	                $data = array(
	                    'pay_name' 		=> $format_name,
	                    'pay_desc' 		=> $format_description,
	                    'pay_config' 	=> $pay_config,
	                    'pay_fee' 		=> $pay_fee,
	                    'enabled' 		=> 1
	                );
	                 
// 	                $db->where("`pay_code` = '" . $options['config']['pay_code'] . "'")->update($data);
	                RC_DB::table('payment')->where('pay_code', $options['config']['pay_code'])->update($data);
	                 
	            } else {
	                /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
	                $data = array(
	                    'pay_code' 		=> $options['config']['pay_code'],
	                    'pay_name' 		=> $format_name,
	                    'pay_desc' 		=> $format_description,
	                    'pay_config' 	=> $pay_config,
	                    'pay_fee' 		=> $pay_fee,
	                    'enabled' 		=> 1,
	                    'is_online' 	=> $options['config']['is_online'],
	                    'is_cod' 		=> $options['config']['is_cod'],
	                );
// 	                $db->insert($data);
	                RC_DB::table('payment')->insert($data);
	            }
	        } 
	        /* 支付名称重复不处理
	        else {
	            return ecjia_plugin::add_error('plugin_install_error', __('支付方式已存在'));
	        }*/

	        /* 记录日志 */
	        ecjia_admin::admin_log($format_name, 'install', 'payment');
	        return true;
	    }
	}
}

// end