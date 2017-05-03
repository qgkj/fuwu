<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 入驻申请撤销
 * @author
 */
class cancel_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

        $this->authadminSession();
		$value		    = $this->requestData('mobile');
		$validate_code	= $this->requestData('validate_code');

		if (empty($validate_code) || empty($value)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}

		if (!empty($validate_code)) {
			/* 判断校验码*/
			if ($_SESSION['merchant_validate_code'] != $validate_code) {
				return new ecjia_error('validate_code_error', '校验码错误！');
			} elseif ($_SESSION['merchant_validate_expiry'] < RC_Time::gmtime()) {
				return new ecjia_error('validate_code_time_out', '校验码已过期！');
			} elseif ($_SESSION['merchant_validate_mobile'] != $value){
                return new ecjia_error('validate_mobile_error', '手机号码错误！');
            }

            $preaudit_id = RC_DB::table('store_preaudit')->where('contact_mobile', '=', $value)->pluck('id');
            RC_DB::table('store_preaudit')->where('contact_mobile', $value)->delete();
            RC_DB::table('store_check_log')->where('store_id', $preaudit_id)->delete();
            return array();
		}
    }
}

//end