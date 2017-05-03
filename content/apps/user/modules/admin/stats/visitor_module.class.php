<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ##访客数量
 * @author luchongchong
 */
class visitor_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		$result = $this->admin_priv('flow_stats');
		
		if (is_ecjia_error($result)) {
			return $result;
		}
		//传入参数
		$start_date = $this->requestData('start_date');
		$end_date = $this->requestData('end_date');
		if (empty($start_date) || empty($end_date)) {
			return new ecjia_error(101, '参数错误');
		}
		$cache_key = 'admin_stats_visitor_'.md5($start_date.$end_date);
		$data = RC_Cache::app_cache_get($cache_key, 'api');
        
		if (empty($data)) {
			$response = visitor($start_date, $end_date);
			RC_Cache::app_cache_set($cache_key, $response, 'api', 60);
			//流程逻辑结束
		} else {
			$response = $data;
		}
		return $response;
	}

}
function visitor($start_date, $end_date)
{
	$type = $start_date == $end_date ? 'time' : 'day';

	$start_date = RC_Time::local_strtotime($start_date. ' 00:00:00');
	$end_date	= RC_Time::local_strtotime($end_date. ' 23:59:59');

	$db_stats = RC_Model::model('stats/stats_model');

	/* 计算出有多少天*/
	$day = round(($end_date - $start_date)/(24*60*60));
	/* 计算时间刻度*/
	$group_scale = ($end_date+1-$start_date)/6;
	$stats_scale = ($end_date+1-$start_date)/30;

	$where = array();

// 	/* 判断请求时间，一天按小时返回*/
// 	if ($type == 'day') {
// 		$field = "CONCAT(FROM_UNIXTIME(access_time, '%Y-%m-%d'), ' 00:00:00') as new_day,count(DISTINCT ip_address) as visitors";
// 	} else {
// 		$field = "CONCAT(FROM_UNIXTIME(access_time, '%Y-%m-%d %H'), ':00:00') as new_day,count(DISTINCT ip_address) as visitors";
// 	}
// 	$arr = $db_stats->field("count(visit_times) as visit_times,count(DISTINCT ip_address) as visitor_number")->where($where)->find();

// 	$total_visitors	= $arr['visitor_number'];
// 	$visit_times	= $arr['visit_times'];
// 	$web_visitors	= $arr['visitor_number'];

	$field = 'count(visit_times) as visit_times,count(DISTINCT ip_address) as visitor_number';

	$total_visitors = $visit_times = $web_visitors = 0;
	$stats = $group = array();
	$temp_start_time = $start_date;
	$now_time = RC_Time::gmtime();
	$j = 1;
	while ($j <= 30) {
		if ($temp_start_time > $now_time) {
			break;
		}
		$temp_end_time = $temp_start_time + $stats_scale;
		if ($j == 30) {
			$temp_end_time = $temp_end_time-1;
		}
		$temp_total_visitors = 0;
		$result = $db_stats->field($field)
						->where(array_merge($where,array('access_time >="' .$temp_start_time. '" and access_time<="' .$temp_end_time. '"')))
						->group('ip_address')
						->order(array('access_time' => 'asc'))
						->select();

		if (!empty($result)) {
			foreach ($result as $val) {
				$temp_total_visitors += $val['visitor_number'];
				$total_visitors += $val['visitor_number'];
				$visit_times += $val['visit_times'];
			}
			$stats[] = array(
					'time'				=> $temp_start_time,
					'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
					'visitors'			=> $temp_total_visitors,
					'value'				=> $temp_total_visitors,
			);
		} else {
			$stats[] = array(
					'time'				=> $temp_start_time,
					'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_start_time),
					'visitors'			=> 0,
					'value'				=> 0,
			);
		}
		$temp_start_time += $stats_scale;
		$j++;
	}

	$i = 1;
	$temp_group = $start_date;
	while ($i <= 7) {
		if ($i == 7) {
			$group[] = array(
					'time'				=> $end_date,
					'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $end_date),
			);
			break;
		}
		$group[] = array(
				'time'				=> $temp_group,
				'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s', $temp_group),
		);
		$temp_group += $group_scale;
		$i++;
	}



	$mobile_visitors = round($total_visitors*0.2);//先做虚拟的
	$data = array(
			'stats'				=> $stats,
			'group'				=> $group,
			'total_visitors'	=> $total_visitors + $mobile_visitors,
			'visit_times'		=> $visit_times,
			'mobile_visitors'	=> $mobile_visitors,
			'web_visitors'		=> $total_visitors
	);
	return $data;
}

// end
