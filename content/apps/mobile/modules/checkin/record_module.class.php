<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 签到记录
 * @author will.chen
 */
class record_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
    	
		$filite_user        = $this->requestData('filite_user', 'current'); 
		$checkin_award_open = intval(ecjia::config('checkin_award_open'));
		$checkin_data       = array(
				'checkin_award_open'	    => $checkin_award_open,
				'lable_checkin_extra_award'	=> null,
				'checkin_award'			    => 0,
				'checkin_day'			    => 0,
				'checkin_extra_day'		    => 0,
				'checkin_extra_award'	    => 0,
				'checkin_record'		    => array(),
		);
		if ($checkin_award_open) {
			$checkin_data['checkin_award']       = intval(ecjia::config('checkin_award'));
			$checkin_extra_award_config          = ecjia::config('checkin_extra_award');
			$checkin_extra_award                 = unserialize($checkin_extra_award_config);
			$checkin_data['checkin_extra_day']   = $checkin_extra_award['day'];
			$checkin_data['checkin_extra_award'] = $checkin_extra_award['extra_award'];
		}
		
		if ($filite_user == 'current') {
			$this->authSession();
			
			$db = RC_Model::model('mobile/mobile_checkin_model');
			
			$month = RC_Time::local_getdate();
			// 创建本月开始时间
			$month_start = RC_Time::local_mktime(0, 0, 0, $month['mon'], 1, $month['year']);
			// 创建本月结束时间
			$month_end 	= RC_Time::local_mktime(23, 59, 59, $month['mon'], date('t'), $month['year']);
			
			$checkin_result = $db
                			->where(array('user_id' => $_SESSION['user_id'], 'checkin_time >= "'.$month_start.'" and checkin_time <= "'.$month_end.'"'))
                			->select();
			
			$checkin_list = array();
			if (!empty($checkin_result)) {
				$db_user     = RC_Model::model('user/users_model');
				$user_info   = $db_user->field(array('user_name'))->find(array('user_id' => $_SESSION['user_id']));
				$uid         = sprintf("%09d", $_SESSION['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
				$dir1        = substr($uid, 0, 3);//把uid分段
				$dir2        = substr($uid, 3, 2);
				$dir3        = substr($uid, 5, 2);
				
				$filename    = md5($user_info['user_name']);
				$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				
				if(!file_exists($avatar_path)) {
					$avatar_img = '';
				} else {
					$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				}
				$continue_checkin_day = $last_day = 0;
				foreach ($checkin_result as $val) {
					/* 获取签到日期天*/
					$day = RC_Time::local_date('d', $val['checkin_time']);
					if ($val['integral'] == $checkin_data['checkin_award']) {
						if (intval($day) == ($last_day + 1)) {
							$continue_checkin_day++;
						}
					} else {
						$continue_checkin_day = 0;
					}
					$last_day = $day;
					$checkin_data['checkin_record'][] = array(
							'user_name'		    => $user_info['user_name'],
							'avatar_img'	    => $avatar_img,
							'integral'		    => intval($val['integral']),
							'label_integral'	=> $val['integral'].ecjia::config('integral_name'),
							'time'			    => RC_Time::local_time($val['checkin_time']),
							'formatted_time'    => RC_Time::local_date(ecjia::config('time_format'), $val['checkin_time']),
					);
				}
				if ($checkin_award_open && $checkin_data['checkin_extra_day'] > 0 && $checkin_data['checkin_extra_award'] > 0 && $continue_checkin_day > 0) {
					$now_day = RC_Time::local_date('d', RC_Time::gmtime());
					if ($last_day == $now_day) {
						$day                                       = $checkin_data['checkin_extra_day'] - $continue_checkin_day;
						$checkin_data['checkin_day']               = $continue_checkin_day;
						$checkin_data['lable_checkin_extra_award'] = '连续签到'.$continue_checkin_day.'天，再签到'.$day.'天可额外获得'.$checkin_data['checkin_extra_award'].'积分奖励';
					}
				}
			}
			
			
			
			$pager = array(
					"total" => 0,
					"count" => 0,
					"more"	=> 0
			);
		} else {
			$db_view = RC_Model::model('mobile/mobile_checkin_viewmodel');
			/* 获取数量 */
			$size    = $this->requestData('pagination.count', 15);
			$page    = $this->requestData('pagination.page', 1);
			
			$checkin_count = $db_view->join(null)->count();
			//实例化分页
			$page_row = new ecjia_page($checkin_count, $size, 6, '', $page);
			
			$checkin_result = $db_view
                    			->field(array('mc.*', 'user_name'))
                    			->join(array('users'))
                    			->order(array('checkin_time' => 'DESC'))
                    			->limit($page_row->limit())
                    			->select();
			
			$checkin_list = array();
			if (!empty($checkin_result)) {
				foreach ($checkin_result as $val) {
					$uid  = sprintf("%09d", $val['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
					$dir1 = substr($uid, 0, 3);//把uid分段
					$dir2 = substr($uid, 3, 2);
					$dir3 = substr($uid, 5, 2);
					
					$filename    = md5($val['user_name']);
					$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
					
					if(!file_exists($avatar_path)) {
						$avatar_img = '';
					} else {
						$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
					}
					$checkin_data['checkin_record'][] = array(
							'user_name'		=> $val['user_name'],
							'avatar_img'	=> $avatar_img,
							'integral'		=> intval($val['integral']),
							'label_points'	=> $val['integral'].ecjia::config('integral_name'),
							'time'			=> RC_Time::local_time($val['checkin_time']),
							'formatted_time' => RC_Time::local_date(ecjia::config('time_format'), $val['checkin_time']),
					);
				}
			}
			
			$pager = array(
					"total" => $page_row->total_records,
					"count" => $page_row->total_records,
					"more"	=> $page_row->total_pages <= $page ? 0 : 1,
			);
		}
		
		return array('data' => $checkin_data, 'pager' => $pager);
	}
}

// end