<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

//支付方式列表
class payment_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	$this->authSession();
    	$is_cod       = $this->requestData('is_cod', true);
    	$cod_fee      = $this->requestData('cod_fee', 0);
    	$device		  = $this->device;
    	$device_code  = isset($device['code']) ? $device['code'] : '';
    	
        $payment_method = RC_Loader::load_app_class('payment_method','payment');
        $payment_list = $payment_method->available_payment_list($is_cod, $cod_fee);
        foreach ($payment_list as $key => $val) {
        	if ($device_code != '8001') {
        		if ($val['pay_code'] == 'pay_koolyun' || $val['pay_code'] == 'pay_cash') {
        			unset($payment_list[$key]);
        			continue;
        		}
        	}
        	unset($payment_list[$key]['pay_desc']);
        	unset($payment_list[$key]['pay_config']);
        }
        $payment_list = array_values($payment_list);
        if (!empty($payment_list)) {
        	return array('payment' => $payment_list);
        } else {
        	return new ecjia_error(8, 'fail');
        }
    }
}

// end