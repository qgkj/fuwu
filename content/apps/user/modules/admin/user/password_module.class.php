<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员修改密码
 * @author will
 */
class password_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
		$new_password = $this->requestData('password');
		$adminid = $this->requestData('uid', 0);
		$admin_name = $this->requestData('user_name');
		if (empty($new_password) || $adminid == 0 ) {
			$result = new ecjia_error('post_error', __('提交信息有误!'));
			return $result;
		}
		
		if (strlen($new_password) < 6 ) {
			$result = new ecjia_error('passwordlength_error', __('请输入至少6位数密码！'));
			return $result;
		}
		
		$db = RC_Model::model('user/admin_user_model');
		/* 以用户的原密码，与code的值匹配 */
		$name = $db->field('user_name')->where(array('user_id' => $adminid))->find();
		
		if ($admin_name == $name) {
			$result = new ecjia_error('info_error', __('信息错误！'));
			return $result;
		} else {
			// 更新管理员的密码
			$ec_salt = rand(1, 9999);
			$data = array(
					'password' => md5(md5($new_password) . $ec_salt),
					'ec_salt'  => $ec_salt
			);
		
			$result = $db->where(array('user_id' => $adminid))->update($data);
		
			if ($result) {
				$data['data'] = __('密码修改成功!');
				return $data;
			} else {
				$result = new ecjia_error('update_error', __('密码修改失败!'));
				return $result;
			}
		}
	    
	}
}

// end