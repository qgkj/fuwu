<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 更新头像信息
 * @author will.chen
 */
class connect_update_user_avatar_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['avatar_url'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
	    $avatar_url    = trim($options['avatar_url']);
		$get_file      = @file_get_contents($avatar_url);
		if ($get_file) {
			
			$filename        = md5($_SESSION['user_id']);
			$path            = RC_Upload::upload_path() . 'data/avatar';
			$avatar_path     = $path.'/'.$filename.'.jpg';
			
			//创建目录
			$result = royalcms('files')->makeDirectory($path, 0777, true, true);
			//删除原有图片
			royalcms('files')->delete($avatar_path);
			$fp = @fopen($avatar_path,"w");
			@fwrite($fp, $get_file);
			@fclose($fp);
			$rs = RC_DB::TABLE('users')->where('user_id', $_SESSION['user_id'])->update(array('avatar_img' => 'data/avatar'.'/'.$filename.'.jpg'));
		}
        return true;
    }
}

// end