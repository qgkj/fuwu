<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取支付方式信息
 * @author wutifang
 */
class payment_pay_info_api extends Component_Event_Api {
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_class('payment_factory', 'payment', false);
	}
	
    /**
     * @return array
     */
	public function call(&$options) {	
		if (!isset($options['code'])) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('payment::payment.invalid_parameter'));
		}
	   	return $this->get_pay_info($options['code']);
	}
	
	/**
	 * 获取支付方式信息
	 */
	private function get_pay_info($code) {
// 		$db_payment = RC_Loader::load_app_model('payment_model', 'payment');
		
		/* 查询该支付方式内容 */
// 		$pay = $db_payment->payment_find(array('pay_code' => $code, 'enabled' => 1));
		$pay = RC_DB::table('payment')->where('pay_code', $code)->where('enabled', 1)->first();
		
		if (empty($pay)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('payment::payment.payment_not_available'));
		}
		
		/* 取得配置信息 */
		if (is_string($pay['pay_config'])) {
			$pay_config = unserialize($pay['pay_config']);
			
			/* 取出已经设置属性的code */
			$code_list = array();
			if (!empty($pay_config)) {
				foreach ($pay_config as $key => $value) {
					$code_list[$value['name']] = $value['value'];
				}
			}
			$payment_handle = new payment_factory($code);
			$pay['pay_config'] = $payment_handle->configure_forms($code_list, true);
		}
		/* 如果以前没设置支付费用，编辑时补上 */
		if (!isset($pay['pay_fee'])) {
			$pay['pay_fee'] = 0;
		}
		return $pay;
	}
}

// end