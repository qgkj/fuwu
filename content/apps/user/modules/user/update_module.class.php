<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户 头像上传
 * @author royalwang
 */
class update_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		
		$user_name = $this->requestData('user_name');
		$db = RC_Model::model('user/users_model');
		if (isset($_FILES['avatar_img'])) {
			$save_path = 'data/avatar_img';
			$upload = RC_Upload::uploader('image', array('save_path' => $save_path, 'auto_sub_dirs' => true));
			
			$image_info	= $upload->upload($_FILES['avatar_img']);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$avatar_img = $upload->get_position($image_info);
				$old_avatar_img = $db->where(array('user_id' => $_SESSION['user_id']))->get_field('avatar_img');
				if (!empty($old_avatar_img)) {
					$upload->remove($old_avatar_img);
				}
				$db->where(array('user_id' => $_SESSION['user_id']))->update(array('avatar_img' => $avatar_img));
			} else {
				return new ecjia_error('avatar_img_error', '头像上传失败！');
			}
			
// 			$uid = $user_id;
// 			$userinfo = $db->field('user_name')->find(array('user_id' => $uid));
				
// 			$uid = abs(intval($uid));//保证uid为绝对的正整数
				
// 			$uid = sprintf("%09d", $uid);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
				
// 			$dir1 = substr($uid, 0, 3);//把uid分段
// 			$dir2 = substr($uid, 3, 2);
// 			$dir3 = substr($uid, 5, 2);
				
// 			if (empty($userinfo)) {
// 				return new ecjia_error('user_error', __('用户信息错误！'));
// 			}
				
// 			$filename = md5($userinfo['user_name']);
			
// 			$path = RC_Upload::upload_path() . 'data' . DIRECTORY_SEPARATOR . 'avatar' . DIRECTORY_SEPARATOR . $dir1 . DIRECTORY_SEPARATOR . $dir2 . DIRECTORY_SEPARATOR . $dir3;
// 			$filename_path = $path. DIRECTORY_SEPARATOR . substr($uid, -2)."_".$filename.'.jpg';
				
// 			//创建目录
// 			$result = RC_Filesystem::mkdir($path, 0777, true, true);
			
// 			//删除原有图片
// 			RC_Filesystem::delete($filename_path);
			
// 			@unlink($filename_path);//删除原有图片
// 			$img = base64_decode($img);
// 			file_put_contents($filename_path, $img);//返回的是字节数printr(a);
		}
		
		if (!empty($user_name)) {
			$user_exists = $db->where(array('user_id' => array('neq' => $_SESSION['user_id']), 'user_name' => $user_name))->find();
			if ($user_exists) {
				return new ecjia_error('user_name_exists', '用户名已存在！');	
			} else {
				$data = array('object_type' => 'ecjia.user', 'object_group' => 'update_user_name', 'object_id' => $_SESSION['user_id'], 'meta_key' => 'update_time');
				
				/* 判断会员名更改时间*/
				$last_time = RC_Model::model('term_meta_model')->find($data);
				$time = RC_Time::gmtime();
				$limit_time = $last_time['meta_value'] + 2592000;
				if (empty($last_time) || $limit_time  < $time) {
					$db->where(array('user_id' => $_SESSION['user_id']))->update(array('user_name' => $user_name));
					$_SESSION['user_name']		= $user_name;
					$_SESSION['update_time']	= RC_Time::gmtime();
					if (empty($last_time)) {
						$data['meta_value'] = $time;
						RC_Model::model('term_meta_model')->insert($data);
					} else {
						RC_Model::model('term_meta_model')->where($data)->update(array('meta_value' => $time));	
					}
				} else {
					return new ecjia_error('not_repeat_update_username', '30天内只允许修改一次会员名称！');
				}
				
			}
		}
		
 		RC_Loader::load_app_func('admin_user', 'user');
 		$user_info = EM_user_info($_SESSION['user_id']);
 		return $user_info;
 		
	}
}

// end