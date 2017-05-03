<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理员签到记录
 * @author will.chen
 */
class checkin_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$checkin_type = $this->requestData('checkin_type');
		
		if (empty($checkin_type)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		/* 获取配送员信息*/
		$staff_info   = RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->first();
		
		/* 获取配送员打卡最后一条记录信息*/
		$checkin_log  = RC_DB::table('express_checkin')->where('user_id', $_SESSION['staff_id'])->orderBy('log_id', 'desc')->first();
		
		/* 获取当前时间戳*/
		$time         = RC_Time::gmtime();
		$fomated_time = RC_Time::local_date('Y-m-d', $time);
		/* 在线设定*/
		if ($checkin_type == 'online') {
			/* 判断用户在线状态*/
			if ($staff_info['online_status']  == 1 ) {
				return new ecjia_error('already_online', '您已处于在线状态！');
			}
			/* 首次*/
			if (empty($checkin_log)) {
				RC_DB::table('express_checkin')->insertGetId(array('user_id' => $_SESSION['staff_id'], 'checkin_date' => $fomated_time, 'start_time' => $time));
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 1));
			} else {
				if ($checkin_log['checkin_date'] != $fomated_time) {
					/* 判断当天是否有过签到*/
					RC_DB::table('express_checkin')->insertGetId(array('user_id' => $_SESSION['staff_id'], 'checkin_date' => $fomated_time, 'start_time' => $time));
					RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 1));
				} elseif ($checkin_log['checkin_date'] == $fomated_time && !empty($checkin_log['end_time'])) {
					/* 判断当天有签单，并有结束签到时间*/
					RC_DB::table('express_checkin')->insertGetId(array('user_id' => $_SESSION['staff_id'], 'checkin_date' => $fomated_time, 'start_time' => $time));
					RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 1));
				} else {
					return new ecjia_error('already_online', '您已处于在线状态！');
				}
			}
		}
		
		/* 离线设定*/
		if  ($checkin_type == 'offline') {
			/* 判断用户在线状态*/
			if ($staff_info['online_status']  == 4) {
				return new ecjia_error('already_offline', '您已处于离线状态！');
			}
			if (empty($checkin_log) || ($checkin_log['checkin_date'] == $fomated_time && $checkin_log['end_time'] > 0) || $checkin_log['checkin_date'] != $fomated_time) {
				return new ecjia_error('offline_error', '您还未开始接单状态，无法设置离线状态！');
			} else {
				$duration = $time - $checkin_log['start_time'];
				RC_DB::table('express_checkin')->where('log_id', $checkin_log['log_id'])->update(array('end_time' => $time, 'duration' => $duration));
				RC_DB::table('staff_user')->where('user_id', $_SESSION['staff_id'])->update(array('online_status' => 4));
			}
		}
		return array();
	 }	
}

// end