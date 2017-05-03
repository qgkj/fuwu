<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户 头像上传
 * @author royalwang
 */
class update_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
    	if ($_SESSION['admin_id' ] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$user_name = $this->requestData('username');
		$old_password = $this->requestData('old_password');
		$new_password = $this->requestData('new_password');
		
		if ($_SESSION['staff_id']) {
			/* 修改头像*/
			if (isset($_FILES['avatar_img'])) {
				$save_path = 'data/staff/avatar_img';
				$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
					
				$image_info	= $upload->upload($_FILES['avatar_img']);
				/* 判断是否上传成功 */
				if (!empty($image_info)) {
					$avatar_img = $upload->get_position($image_info);
					$old_avatar_img = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('avatar');
					if (!empty($old_avatar_img)) {
						$upload->remove($old_avatar_img);
					}
					RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('avatar' => $avatar_img));
				} else {
					return new ecjia_error('avatar_img_error', '头像上传失败！');
				}
			}
			/* 修改用户名*/
			if (!empty($user_name)) {
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('name' => $user_name));
				$_SESSION['staff_name']		= $user_name;
			}
			
			/* 修改登录密码*/
			if (!empty($old_password) && !empty($new_password)) {
				/* 查询旧密码并与输入的旧密码比较是否相同 */
				$db_old_password	= RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('password');
				$old_ec_salt		= RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->pluck('salt');
				
				if (empty($old_ec_salt)) {
					$old_ec_password = md5($old_password);
				} else {
					$old_ec_password = md5(md5($old_password).$old_ec_salt);
				}
				if ($db_old_password != $old_ec_password) {
					return new ecjia_error('old_password_error', '输入的旧密码错误！');
				}
				
				if ($db_old_password == md5(md5($new_password).$old_ec_salt)) {
					return new ecjia_error('new_password_error', '新密码与原始密码相同！');
				}
				
				$salt		= rand(1, 9999);
				$password	= md5(md5($new_password) . $salt);
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('password' => $password, 'salt' => $salt));
			}
		}
		
 		return array();
 		
	}
}

// end