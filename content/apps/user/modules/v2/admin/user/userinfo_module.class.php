<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员信息
 * @author will
 */
class userinfo_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		
        if ($_SESSION['admin_id' ] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        if ($_SESSION['staff_id']) {
            //商家
            return get_user_info_merchant();
        } else {
            //平台
            return get_user_info_admin();
        }
		
	}
}

function get_user_info_merchant() {
    $result = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
    
    if ($result) {
        $userinfo = array(
            'id' 		    => $result['user_id'],
            'username'	    => $result['name'],
            'email'		    => $result['email'],
            'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $result['last_login']),
            'last_ip'		=> RC_Ip::area($result['last_ip']),
            'role_name'		=> $result['group_id'] ? RC_DB::table('staff_group')->where('group_id', $result['group_id'])->pluck('group_name') : null,
            'avator_img'	=> $result['avatar'] ? RC_Upload::upload_url($result['avatar']) : null,
        );
    } else {
        return new ecjia_error('error', '用户信息不存在，你是火星来的吧');
    }
    
    return $userinfo;
}

function get_user_info_admin() {
    $db = RC_Model::model('user/admin_user_model');
    $db_role = RC_Loader::load_model('role_model');
    
    $result = $db->find(array('user_id' => $_SESSION['admin_id']));
    
    if (isset($_SESSION['adviser_id']) && !empty($_SESSION['adviser_id'])) {
        $adviser_info = RC_Model::model('achievement/adviser_model')->find(array('id' => $_SESSION['adviser_id']));
        $result['user_name'] = $adviser_info['username'];
        $result['email']	 = $adviser_info['email'];
    }
    
    $userinfo = array(
        'id' 		    => $result['user_id'],
        'username'	    => $result['user_name'],
        'email'		    => $result['email'],
        'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $result['last_login']),
        'last_ip'		=> RC_Ip::area($result['last_ip']),
        'role_name'		=> $db_role->where(array('role_id' => $result['role_id']))->get_field('role_name'),
        'avator_img'	=> RC_Uri::admin_url('statics/images/admin_avatar.png'),
    );
    
    return $userinfo;
}

// end