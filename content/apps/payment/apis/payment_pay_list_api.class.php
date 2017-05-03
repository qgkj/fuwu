<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取支付方式下拉列表
 * @author wutifang
 */
class payment_pay_list_api extends Component_Event_Api {
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_class('payment_factory', 'payment', false);
	}
	
    /**
     * @return array
     */
	public function call(&$options) {	
	   	return $this->get_pay_list();
	}
	
	/**
	 * 获取支付方式列表
	 */
	private function get_pay_list() {
// 		$db_payment = RC_Loader::load_app_model('payment_model', 'payment');
		
		$plugins = ecjia_config::instance()->get_addon_config('payment_plugins', true, true);

// 		$data = $db_payment->payment_select('pay_order');
		$data = RC_DB::table('payment')->orderby('pay_order')->get();
		$data or $data = array();
		$modules = array();
		if (!empty($data)) {
			foreach ($data as $_key => $_value) {
				if (isset($plugins[$_value['pay_code']])) {
					$modules[$_key]['id'] 		= $_value['pay_id'];
					$modules[$_key]['code'] 	= $_value['pay_code'];
					$modules[$_key]['name'] 	= $_value['pay_name'];
					$modules[$_key]['pay_fee'] 	= $_value['pay_fee'];
					$modules[$_key]['is_cod'] 	= $_value['is_cod'];
					$modules[$_key]['desc'] 	= $_value['pay_desc'];
					$modules[$_key]['pay_order']= $_value['pay_order'];
					$modules[$_key]['enabled'] 	= $_value['enabled'];
				}
			}
		}
		return $modules;
	}
}

// end