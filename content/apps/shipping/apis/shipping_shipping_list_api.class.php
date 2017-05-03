<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取配送方式下拉列表
 * @author wutifang
 */
class shipping_shipping_list_api extends Component_Event_Api {
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_class('shipping_factory', 'shipping', false);
	}
	
    /**
     * @return array
     */
	public function call(&$options) {	
	   	return $this->get_shipping_list();
	}
	
	/**
	 * 取得配送方式列表
	 */
	private function get_shipping_list() {
		$db_shipping = RC_Model::model('shipping/shipping_model');

		$data = $db_shipping->shipping_select(array('shipping_id', 'shipping_code', 'shipping_name', 'shipping_desc', 'insure', 'support_cod', 'shipping_order', 'enabled'), array('enabled' => 1), 'shipping_order');
		$data or $data = array();
		
		$plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
			
		/* 插件已经安装了，获得名称以及描述 */
		$modules = array();
		
		if (!empty($data)) {
			foreach ($data as $_key => $_value) {
				if (isset($plugins[$_value['shipping_code']])) {
					$modules[$_key]['id']      			= $_value['shipping_id'];
					$modules[$_key]['code']      		= $_value['shipping_code'];
					$modules[$_key]['name']    			= $_value['shipping_name'];
					$modules[$_key]['desc']    			= $_value['shipping_desc'];
					$modules[$_key]['cod']     			= $_value['support_cod'];
					$modules[$_key]['shipping_order'] 	= $_value['shipping_order'];
					$modules[$_key]['insure_fee']  		= $_value['insure'];
					$modules[$_key]['enabled'] 			= $_value['enabled'];
						
					/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
					$shipping_handle = new shipping_factory($_value['shipping_code']);
					$config          = $shipping_handle->configure_config();
			
					/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
					if (isset($config['insure']) && ($config['insure'] === false)) {
						$modules[$_key]['is_insure'] = false;
					} else {
						$modules[$_key]['is_insure'] = true;
					}
				}
			}
		}
		return $modules;
	}
}

// end