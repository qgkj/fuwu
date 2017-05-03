<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 支付方式卸载API
 * @author royalwang
 */
class payment_plugin_uninstall_api extends Component_Event_Api {
	
	public function call(&$options) {
	    
	    $plugin_data = array();
	    if (isset($options['file'])) {
	        $plugin_file = $options['file'];
	        $plugin_data = RC_Plugin::get_plugin_data($plugin_file);
	        
	        $plugin_file = RC_Plugin::plugin_basename( $plugin_file );
	        $plugin_dir = dirname($plugin_file);
	    
	        $plugins = ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
	        unset($plugins[$plugin_dir]);
	    
	        ecjia_config::instance()->set_addon_config('payment_plugins', $plugins, true, true);
	    }
	    
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['pay_code'])) {
	            return ecjia_plugin::add_error('plugin_uninstall_error', RC_Lang::get('payment::payment.plugin_uninstall_error'));
	        }
	        
	        /* 从数据库中删除支付方式 */
	        // $db = RC_Loader::load_app_model('payment_model', 'payment');
	        // $db->where("`pay_code` = '" . $options['config']['pay_code'] . "'")->delete();
	        RC_DB::table('payment')->where('pay_code', $options['config']['pay_code'])->delete();
	        
	        /* 记录日志 */
	        ecjia_admin::admin_log($format_name, 'uninstall', 'payment');
	        
	        return true;
	    }

	}
}

// end