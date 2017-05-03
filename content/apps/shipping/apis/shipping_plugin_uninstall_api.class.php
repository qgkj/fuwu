<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送方式卸载API
 * @author royalwang
 */
class shipping_plugin_uninstall_api extends Component_Event_Api 
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
	        unset($plugins[$plugin_dir]);
	         
	        ecjia_config::instance()->set_addon_config('shipping_plugins', $plugins, true);
	    }
		
	    if (isset($options['config']) && !empty($plugin_data['Name'])) {
	        $format_name = $plugin_data['Name'];
	        
	        /* 检查输入 */
	        if (empty($format_name) || empty($options['config']['shipping_code'])) {
	            return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('shipping::shipping.no_shipping_name'));
	        }
	        
	        RC_Loader::load_app_func('global', 'shipping');
	        
	        $db = RC_Model::model('shipping/shipping_model');
	        $db_area = RC_Model::model('shipping/shipping_area_model');
	        $db_region = RC_Model::model('shipping/shipping_area_region_model');
	        
	        /* 获得该配送方式的ID */
	        $row = $db->field('shipping_id, shipping_name, print_bg')->find("`shipping_code` = '" . $options['config']['shipping_code'] . "'");
	        $shipping_id = $row['shipping_id'];
	        $shipping_name = $row['shipping_name'];
	        
	        /* 删除 shipping_fee 以及 shipping 表中的数据 */
	        if ($row) {
	            $all_area_ids = $db_area->where("`shipping_id` = $shipping_id")->get_field('shipping_area_id', true);
	        
	            if (!empty($all_area_ids)) {
	                $db_region->in(array('shipping_area_id' => $all_area_ids))->delete();
	                $db_area->where("`shipping_id` = $shipping_id")->delete();
	            }
	            $db->where("`shipping_id` = $shipping_id")->delete();
	            	
	            //删除上传的非默认快递单
// 	            if (($row['print_bg'] != '') && (!is_print_bg_default($row['print_bg']))) {
	            if ($row['print_bg'] != '') {
		            	$uploads_dir_info    = RC_Upload::upload_dir();
		            	$data_file_to_delete = $uploads_dir_info[basedir] . $row['print_bg'];
		            	if( is_file($data_file_to_delete) == TRUE ) {
		            		chmod($data_file_to_delete, 0666);
		            		unlink($data_file_to_delete);
		            	}
// 	                unlink(ROOT_PATH . $row['print_bg']);
	            }

	            	
	            //记录管理员操作
	            ecjia_admin::admin_log(addslashes($shipping_name), 'uninstall', 'shipping');
	            
	            return true;
	        }
	    }
	}
}

// end