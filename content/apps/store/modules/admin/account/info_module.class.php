<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 认证申请
 * @author will.chen
 */
class info_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        
        //判断是否修改（预审核表有无信息）
        $merchant_info = RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();
        if(empty($merchant_info)) {
            $merchant_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();
        }
		
		/* 判断身份正面图片*/
		if(!file_exists(RC_Upload::upload_path($merchant_info['identity_pic_front'])) || empty($merchant_info['identity_pic_front'])) {
			$identity_pic_front = '';
		} else {
			$identity_pic_front = RC_Upload::upload_url($merchant_info['identity_pic_front']);
		}

		/* 判断身份反面图片*/
		if(!file_exists(RC_Upload::upload_path($merchant_info['identity_pic_back'])) || empty($merchant_info['identity_pic_back'])) {
			$identity_pic_back = '';
		} else {
			$identity_pic_back = RC_Upload::upload_url($merchant_info['identity_pic_back']);
		}

		/* 个人认证*/
		if ($merchant_info['validate_type'] == 1) {
			/* 判断手持身份图片*/
			if(!file_exists(RC_Upload::upload_path($merchant_info['personhand_identity_pic'])) || empty($merchant_info['personhand_identity_pic'])) {
				$identity_pic = '';
			} else {
				$identity_pic = RC_Upload::upload_url($merchant_info['personhand_identity_pic']);
			}
			return array(
					'validate_type'			=> $merchant_info['validate_type'],
					'responsible_person'	=> $merchant_info['responsible_person'],
					'identity_type'			=> $merchant_info['identity_type'],
					'identity_number'		=> $merchant_info['identity_number'],
					'identity_pic' 			=> $identity_pic,
					'identity_pic_front'	=> $identity_pic_front,
					'identity_pic_back'		=> $identity_pic_back,
					'contact_mobile'		=> $merchant_info['contact_mobile'],

			);
		} else {
			/* 判断营业执照图片*/
			if(!file_exists(RC_Upload::upload_path($merchant_info['business_licence_pic'])) || empty($merchant_info['business_licence_pic'])) {
				$business_licence_pic = '';
			} else {
				$business_licence_pic = RC_Upload::upload_url($merchant_info['business_licence_pic']);
			}
			return array(
					'validate_type'		    => $merchant_info['validate_type'],
					'responsible_person'	=> $merchant_info['responsible_person'],
					'company_name'			=> $merchant_info['company_name'],
					'business_licence_pic'	=> $business_licence_pic,
					'identity_pic_front'	=> $identity_pic_front,
					'identity_pic_back'		=> $identity_pic_back,
					'contact_mobile'		=> $merchant_info['contact_mobile'],
			);
		}
    }
}

//end