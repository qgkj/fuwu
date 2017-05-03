<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员登录
 * @author will
 */
class signin_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		$this->authadminSession();
		
		$username	= $this->requestData('username');
		$password	= $this->requestData('password');
		$device		= $this->device;

		if (empty($username) || empty($password)) {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
			return $result;
		}
		
		//根据用户名判断是商家还是平台管理员
		//如果商家员工表存在，以商家为准
		$row_staff = RC_DB::table('staff_user')->where('mobile', $username)->first();
		
		if ($row_staff) {
		    //商家
		    return signin_merchant($username, $password, $device);
		} else {
		    //平台
		    return signin_admin($username, $password, $device);
		}
	}
}

function signin_merchant($username, $password, $device) {
    /* 收银台请求判断处理*/
    if (!empty($device) && is_array($device) && $device['code'] == '8001') {
        $adviser_info = RC_Model::model('achievement/adviser_model')->find(array('username' => $username));
        if (empty($adviser_info)) {
			$result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
			return $result;
        }
        $admin_info = RC_DB::table('staff_user')->where('user_id', $adviser_info['admin_id'])->first();
        $username	= $admin_info['mobile'];
        $salt	    = $admin_info['salt'];
    } else {
        $salt = RC_DB::table('staff_user')->where('mobile', $username)->pluck('salt');
    }
    
    /* 检查密码是否正确 */
    $db_staff_user = RC_DB::table('staff_user')->selectRaw('user_id, mobile, name, store_id, nick_name, email, last_login, last_ip, action_list, avatar, group_id, online_status');
    if (!empty($salt)) {
        $db_staff_user->where('mobile', $username)->where('password', md5(md5($password).$salt) );
    } else {
        $db_staff_user->where('mobile', $username)->where('password', md5($password) );
    }
    $row = $db_staff_user->first();
    
    if ($row) {
        // 登录成功
        /* 设置session信息 */
        /*  
         [store_id] => 15
         [store_name] => 天天果园专营店
         [staff_id] => 1
         [staff_mobile] => 15921158110
         [staff_name] => hyy
         [staff_email] => hyy
         [last_login] => 1476816441
         adviser_id
         shop_guide
         [admin_id] => 0
         [admin_name] => 0
         [action_list] => all
         [email] => 0
         [device_id]
         [ip] => 0.0.0.0
          */
    
    
        $_SESSION['admin_id']	    = 0;
        $_SESSION['admin_name']	    = null;
        $_SESSION['action_list']    = $row['action_list'];
         
        $_SESSION['store_id']	    = $row['store_id'];
        $_SESSION['store_name']	    = RC_DB::table('store_franchisee')->where('store_id', $row['store_id'])->pluck('merchants_name');
        $_SESSION['staff_id']	    = $row['user_id'];
        $_SESSION['staff_mobile']	= $row['mobile'];
        $_SESSION['staff_name']	    = $row['name'];
        $_SESSION['staff_email']	= $row['email'];
        
        $_SESSION['last_login']	    = $row['last_login'];
        $_SESSION['last_ip']	    = $row['last_ip'];
        
        /* 获取device_id*/
        $device_id = RC_Model::model('mobile/mobile_device_model')->where(array('device_udid' => $device['udid'], 'device_client' => $device['client'], 'device_code' => $device['code']))->get_field('id');
        $_SESSION['device_id']	    = $row['device_id'];
         
        if ($device['code'] == '8001') {
            $_SESSION['adviser_id']	= $row['user_id'];
            $_SESSION['admin_name']	= $row['mobile'];
        }
         
        if (empty($row['salt'])) {
            $salt = rand(1, 9999);
            $new_possword = md5(md5($password) . $salt);
            $data = array(
                'salt'	=> $salt,
                'password'	=> $new_possword
            );
            RC_DB::table('staff_user')->where('user_id', $_SESSION['admin_id'])->update($data);
        }
    
        if ($row['action_list'] == 'all' && empty($row['last_login'])) {
            $_SESSION['shop_guide'] = true;
        }
    
        $data = array(
            'last_login' 	=> RC_Time::gmtime(),
            'last_ip'		=> RC_Ip::client_ip(),
        );
        RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update($data);
    
        $out = array(
            'session' => array(
                'sid' => RC_Session::session_id(),
                'uid' => $_SESSION['admin_id']
            ),
        );
        $role_name = $group = '';
        
        switch ($row['group_id']) {
        	case -1 : 
        		$role_name	= "配送员";
        		$group		= 'express';
        		break;
        	default:
        		if ($row['group_id'] > 0) {
        			$role_name = RC_DB::table('staff_group')->where('group_id', $row['group_id'])->pluck('group_name');
        		}
        		break;
        }

        /* 登入后默认设置离开状态*/
        if ($row['online_status'] != 4 && $group == 'express') {
        	RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 4));
        	/* 获取当前时间戳*/
        	$time = RC_Time::gmtime();
        	$fomated_time = RC_Time::local_date('Y-m-d', $time);
        	/* 查询签到记录*/
        	$checkin_log = RC_DB::table('express_checkin')->where('user_id', $_SESSION['staff_id'])->orderBy('log_id', 'desc')->first();
        	if ($fomated_time == $checkin_log['checkin_date'] && empty($checkin_log['end_time'])) {
        		$duration = $time - $checkin_log['start_time'];
        		RC_DB::table('express_checkin')->where('log_id', $checkin_log['log_id'])->update(array('end_time' => $time, 'duration' => $duration));
        	}
        }
        
        $out['userinfo'] = array(
            'id' 			=> $row['user_id'],
            'username'		=> $row['mobile'],
            'email'			=> $row['email'],
            'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
            'last_ip'		=> RC_Ip::area($row['last_ip']),
            'role_name'		=> $role_name,
        	'group'			=> $group,
            'avator_img'	=> !empty($row['avatar']) ? RC_Upload::upload_url($row['avatar']) : null,
        );
        
        if ($device['code'] == '8001') {
            $out['userinfo']['username'] = $adviser_info['username'];
            $out['userinfo']['email']	 = $adviser_info['email'];
        }
        
        //修正关联设备号
        $result = ecjia_app::validate_application('mobile');
        if (!is_ecjia_error($result)) {
            if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
            	$db_mobile_device = RC_Model::model('mobile/mobile_device_model');
            	$device_data = array(
            			'device_udid'	=> $device['udid'],
            			'device_client'	=> $device['client'],
            			'device_code'	=> $device['code'],
            			'user_type'		=> 'merchant',
            	);
            	$device_info = $db_mobile_device->find($device_data);
            	if (empty($device_info)) {
            		$device_data['add_time'] = RC_Time::gmtime();
            		$db_mobile_device->insert($device_data);
            	} else {
            		$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['staff_id'], 'update_time' => RC_Time::gmtime()));
            	}
            }
        }
         
        return $out;
    } else {
        return new ecjia_error('login_error', __('您输入的帐号信息不正确'));
    }
}

function signin_admin($username, $password, $device) {
    $db_user = RC_Model::model('user/admin_user_model');
    //到家后台不允许平台管理员登录
    if (!empty($device) && is_array($device) && ($device['code'] == '6001' || $device['code'] == '6002')) {
        if ($db_user->where(array('user_name' => $username))->count()) {
            return new ecjia_error('login_error', __('平台管理员请登录掌柜管理'));
        } else {
            return new ecjia_error('login_error', __('您输入的帐号信息不正确'));
        }
        
    }
    
    /* 收银台请求判断处理*/
    if (!empty($device) && is_array($device) && $device['code'] == '8001') {
        $adviser_info = RC_Model::model('achievement/adviser_model')->find(array('username' => $username));
        if (empty($adviser_info)) {
            $result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
            return $result;
        }
        $admin_info = $db_user->field(array('user_name', 'ec_salt'))->find(array('user_id' => $adviser_info['admin_id']));
        $username	= $admin_info['user_name'];
        $ec_salt	= $admin_info['ec_salt'];
    } else {
        $ec_salt    = $db_user->where(array('user_name' => $username))->get_field('ec_salt');
    }
    
    
    /* 检查密码是否正确 */
    if (!empty($ec_salt)) {
        $row = $db_user->field('user_id, user_name, email, password, last_login, action_list, last_login, suppliers_id, ec_salt, seller_id, role_id, ru_id')
        ->find(array('user_name' => $username, 'password' => md5(md5($password).$ec_salt)));
    } else {
        $row = $db_user->field('user_id, user_name, email, password, last_login, action_list, last_login, suppliers_id, ec_salt, seller_id, role_id, ru_id')
        ->find(array('user_name' => $username, 'password' => md5($password)));
    }
    
    if ($row) {
        // 登录成功
        /* 设置session信息 */
        $_SESSION['admin_id']	    = $row['user_id'];
        $_SESSION['admin_name']	    = $row['user_name'];
        $_SESSION['action_list']	= $row['action_list'];
        $_SESSION['last_login']	    = $row['last_login'];
        $_SESSION['suppliers_id']	= $row['suppliers_id'];
        
        $_SESSION['store_id']	    = 0;
        $_SESSION['store_name']	    = null;
        $_SESSION['staff_id']	    = 0;
        $_SESSION['staff_mobile']	= null;
        $_SESSION['staff_name']	    = null;
        $_SESSION['staff_email']	= null;
        
        $_SESSION['last_ip']	    = $row['last_ip'];
        	
        /* 获取device_id*/
        $device_id = RC_Model::model('mobile/mobile_device_model')->where(array('device_udid' => $device['udid'], 'device_client' => $device['client'], 'device_code' => $device['code']))->get_field('id');
        $_SESSION['device_id']	    = $row['device_id'];
    
        	
        if ($device['code'] == '8001') {
            $_SESSION['adviser_id']	= $row['id'];
            $_SESSION['admin_name']	= $row['username'];
        }
        	
        if (empty($row['ec_salt'])) {
            $ec_salt = rand(1, 9999);
            $new_possword = md5(md5($password) . $ec_salt);
            $data = array(
                'ec_salt'	=> $ec_salt,
                'password'	=> $new_possword
            );
            $db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
        }
    
        if ($row['action_list'] == 'all' && empty($row['last_login'])) {
            $_SESSION['shop_guide'] = true;
        }
    
        $data = array(
            'last_login' 	=> RC_Time::gmtime(),
            'last_ip'		=> RC_Ip::client_ip(),
        );
        $db_user->where(array('user_id' => $_SESSION['admin_id']))->update($data);
    
        $out = array(
            'session' => array(
                'sid' => RC_Session::session_id(),
                'uid' => $_SESSION['admin_id']
            ),
        );
        $db_role = RC_Loader::load_model('role_model');
        $role_name = $db_role->where(array('role_id' => $row['role_id']))->get_field('role_name');
        	
        $out['userinfo'] = array(
            'id' 			=> $row['user_id'],
            'username'		=> $row['user_name'],
            'email'			=> $row['email'],
            'last_login' 	=> RC_Time::local_date(ecjia::config('time_format'), $row['last_login']),
            'last_ip'		=> RC_Ip::area($row['last_ip']),
            'role_name'		=> !empty($role_name) ? $role_name : '',
            'avator_img'	=> RC_Uri::admin_url('statics/images/admin_avatar.png'),
        );
        	
        if ($device['code'] == '8001') {
            $out['userinfo']['username'] = $adviser_info['username'];
            $out['userinfo']['email']	 = $adviser_info['email'];
        }
        	
        //修正关联设备号
        $result = ecjia_app::validate_application('mobile');
        if (!is_ecjia_error($result)) {
            if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
                $db_mobile_device = RC_Model::model('mobile/mobile_device_model');
                $device_data = array(
                    'device_udid'	=> $device['udid'],
                    'device_client'	=> $device['client'],
                    'device_code'	=> $device['code'],
                    'user_type'		=> 'admin',
                );
                $device_info = $db_mobile_device->find($device_data);
                if (empty($device_info)) {
                	$device_data['add_time'] = RC_Time::gmtime();
                	$db_mobile_device->insert($device_data);
                } else {
                	$db_mobile_device->where($device_data)->update(array('user_id' => $_SESSION['admin_id'], 'update_time' => RC_Time::gmtime()));
                }
            }
        }
        	
        return $out;
    } else {
        $result = new ecjia_error('login_error', __('您输入的帐号信息不正确'));
        return $result;
    }
}

// end