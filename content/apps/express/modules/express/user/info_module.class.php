<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 快递员基本信息
 * @author will.chen
 */
class info_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
        $staff_user          = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
        $express_count_stats = RC_DB::table('express_user')->where('user_id', $_SESSION['staff_id'])->first();
        $assign_count        = RC_DB::table('express_order')->where('staff_id', $_SESSION['staff_id'])->where('from', 'assign')->where('status', 5)->count();
        $grab_count          = RC_DB::table('express_order')->where('staff_id', $_SESSION['staff_id'])->where('from', 'grab')->where('status', 5)->count();
        
        
        $express_user_info = array(
			'user_id'		       	=> $_SESSION['staff_id'],
        	'avatar_img'	        => !empty($staff_user['avatar']) ? RC_Upload::upload_url($staff_user['avatar']) : '',
        	'staff_name'	        => $staff_user['name'],
        	'mobile'		        => $staff_user['mobile'],
        	'email'			        => $staff_user['email'],
        	'delivery_count'		=> !empty($express_count_stats) ? $express_count_stats['delivery_count'] : 0,
        	'sum_delivery_money'	=> RC_DB::table('express_order')->where('staff_id', $_SESSION['staff_id'])->where('status', 5)->sum('shipping_fee'),
        	'sum_delivery_distance'	=> !empty($express_count_stats) ? $express_count_stats['delivery_distance'] : 0,
        	'express_type_stats'	=> array(
        		'assign_count'		=> $assign_count,
        		'grab_count'		=> $grab_count,
        	),
        	'role_name'				=> '配送员',
        	'last_login' 			=> RC_Time::local_date(ecjia::config('time_format'), $staff_user['last_login']),
        );
		return $express_user_info;
	 }	
}

// end