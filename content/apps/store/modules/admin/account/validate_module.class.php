<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 认证申请
 * @author will.chen
 */
class validate_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }

		$validate_code = $this->requestData('validate_code', '');

		$time = RC_Time::gmtime();
		if (empty($validate_code) || $_SESSION['merchant_validate_code'] != $validate_code || $_SESSION['merchant_validate_expiry'] < $time) {
			return new ecjia_error('code_error', '验证码不正确！');
		}

		$merchant_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();

		$responsible_person 		= $this->requestData('responsible_person', '');
		$identity_type 				= $this->requestData('identity_type', '');
		$identity_number 			= $this->requestData('identity_number', '');
		$company_name 				= $this->requestData('company_name', '');
		

		$data = array();

		if (!empty($responsible_person)) {
			$data['responsible_person'] = $responsible_person;
			unset($merchant_info['responsible_person']);
		}
		
		if (!empty($identity_type)) {
			$data['identity_type'] = $identity_type;
			unset($merchant_info['identity_type']);
		}

		if (!empty($identity_number)) {
			$data['identity_number'] = $identity_number;
			unset($merchant_info['identity_number']);
		}

		if (!empty($company_name)) {
			$data['company_name'] = $company_name;
			unset($merchant_info['company_name']);
		}

		$store_preaudit_info   = RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();
		$store_franchisee_info = RC_DB::table('store_franchisee')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->first();

		$save_path = 'merchant/'.$_SESSION['store_id'].'/data/identity_pic';
		$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));

		/* 手持身份证*/
		if (isset($_FILES['identity_pic'])) {
			$image_info	= $upload->upload($_FILES['identity_pic']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$personhand_identity_pic = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['personhand_identity_pic'])) {
// 					$upload->remove($store_preaudit_info['personhand_identity_pic']);
// 				}
				$data['personhand_identity_pic'] = $personhand_identity_pic;
				unset($merchant_info['personhand_identity_pic']);
			}
		}

		/* 身份证正面*/
		if (isset($_FILES['identity_pic_front'])) {
			$image_info	= $upload->upload($_FILES['identity_pic_front']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$identity_pic_front = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['identity_pic_front'])) {
// 					$upload->remove($store_preaudit_info['identity_pic_front']);
// 				}
				$data['identity_pic_front'] = $identity_pic_front;
				unset($merchant_info['identity_pic_front']);
			}
		} 

		/* 手持身反面*/
		if (isset($_FILES['identity_pic_back'])) {
			$image_info	= $upload->upload($_FILES['identity_pic_back']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$identity_pic_back = $upload->get_position($image_info);
// 				if (!empty($store_preaudit_info['identity_pic_back'])) {
// 					$upload->remove($store_preaudit_info['identity_pic_back']);
// 				}
				$data['identity_pic_back'] = $identity_pic_back;
				unset($merchant_info['identity_pic_back']);
			}
		}

		/* 营业执照*/
		if (isset($_FILES['business_licence_pic'])) {
			$save_path = 'merchant/'.$_SESSION['store_id'].'/data/business_licence';
			$upload_business_licence = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));

			$image_info	= $upload_business_licence->upload($_FILES['business_licence_pic']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$business_licence_pic = $upload_business_licence->get_position($image_info);
// 				if (!empty($store_preaudit_info['business_licence_pic'])) {
// 					$upload_business_licence->remove($store_preaudit_info['business_licence_pic']);
// 				}
				$data['business_licence_pic'] = $business_licence_pic;
				unset($merchant_info['business_licence_pic']);
			}
		}

		$data['identity_status'] = 1;
		if ($merchant_info['identity_status'] != 2) {
		    RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->update(array('identity_status' => 1));
		}
		$data['apply_time'] = RC_Time::gmtime();
		unset($merchant_info['manage_mode']);unset($merchant_info['status']);unset($merchant_info['shop_close']);unset($merchant_info['apply_time']);
		unset($merchant_info['confirm_time']);unset($merchant_info['identity_status']);unset($merchant_info['percent_id']);unset($merchant_info['sort_order']);
		$data = array_merge($data, $merchant_info);

		if ($store_preaudit_info) {
			RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->update($data);
		} else {
			RC_DB::table('store_preaudit')->where(RC_DB::raw('store_id'), $_SESSION['store_id'])->insertGetId($data);
		}
		
		//审核日志
		RC_Loader::load_app_func('merchant_franchisee', 'franchisee');
		add_check_log($data, $store_franchisee_info);

		return array();
    }

}

//end