<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 签到
 * @author will.chen
 */
class integral_module extends api_front implements api_interface {

	public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();	
		
		$db           = RC_Model::model('mobile/mobile_checkin_model');
		/* 获取当天时间段*/
		$time         = RC_Time::gmtime();
		$date         = RC_Time::local_date('Y-m-d', $time);
		$start_time   = RC_Time::local_strtotime($date);
		$end_time	  = RC_Time::local_strtotime($date. ' 23:59:59');
		
		$checkin_info = $db->where(array('user_id' => $_SESSION['user_id'], 'checkin_time >= "'.$start_time.'" and checkin_time <= "'.$end_time.'"'))->find();
		if (empty($checkin_info)) {
			$integral = 0;
			if (ecjia::config('checkin_award_open')) {
				$integral = ecjia::config('checkin_award'); 
			}
			
			$db->insert(array(
					'user_id'		=> $_SESSION['user_id'],
					'checkin_time'	=> $time,
					'integral'		=> $integral,
					'source'		=> 'ECJia_app'
			));

			if (ecjia::config('checkin_award_open')) {
				$checkin_extra_award = ecjia::config('checkin_extra_award');
				$checkin_extra_award = unserialize($checkin_extra_award);
				
				if ($checkin_extra_award['day'] > 0) {
					$continuous_start_time      = $start_time - ($checkin_extra_award['day']-1)*86400;
					$continuous_signin_integral = $checkin_extra_award['extra_award'] + $integral;
					$checkin_list               = $db->where(array(
										'user_id' => $_SESSION['user_id'], 
										'checkin_time >= "'.$continuous_start_time.'" and checkin_time <= "'.$end_time.'"',
										'integral' => array('neq' => $continuous_signin_integral)))
										->select();
					if (count($checkin_list) == $checkin_extra_award['day']) {
						$integral = $continuous_signin_integral;
						$db->where(array(
								'user_id'		=> $_SESSION['user_id'],
			 					'checkin_time'	=> $time,
								'source'		=> 'ECJia_app'
						))->update(array('integral' => $integral));
					}
				}
				RC_Api::api('user', 'account_change_log', array('user_id' => $_SESSION['user_id'], 'pay_points' => $integral, 'change_desc' => '签到送积分'));
			}
		} else {
			return new ecjia_error('checkin_repeat', '您今天已成功签到！');	
		}
		
		return array();
	}
}

// end