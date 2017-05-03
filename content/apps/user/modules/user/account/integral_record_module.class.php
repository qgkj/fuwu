<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 积分收支明细
 * @author zrl
 */
class integral_record_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['user_id'] <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
 		$size    = $this->requestData('pagination.count', 15);
        $page    = $this->requestData('pagination.page', 1);
 		$user_id = $_SESSION['user_id'];
 		$type    = $this->requestData('type', 'income');
 		
		$where = array();
		$where['user_id'] = $_SESSION['user_id'];
		
		if ($type == 'income') {
			$where['pay_points'] = array('gt' => 0);
		} elseif ($type == 'expenses') {
			$where['pay_points'] = array('lt' => 0);
		}
		$integral = array();
		$field = 'pay_points';
		$integral = RC_Model::model('user/users_model')->get_one_field(array('user_id' => $user_id), $field);
 		/*获取积分变动条数 */
		$db = RC_Model::model('user/account_log_model');
 		$record_count = $db->get_integral_count(array('where' => $where));
		//实例化分页
		$page_row = new ecjia_page($record_count, $size, 6, '', $page);
 		//获取积分变动记录
 		$integral_list = $db->get_integral_list(array('where' => $where, 'limit' => $page_row->limit()));
 		
 		$pager = array(
			"total" => $page_row->total_records,
			"count" => $page_row->total_records,
			"more"  => $page_row->total_pages <= $page ? 0 : 1,
 		);
 		$data = array();
 		$data['integral'] = intval($integral);
 		if (!empty($integral_list)) {
 			foreach ($integral_list as $key => $val) {
 				$data['list'][] = array(
 					'pay_points' 			=> $val['pay_points'],
 					'change_time' 			=> $val['change_time'],	
 					'formated_change_time'	=> RC_Time::local_date(ecjia::config('time_format'), $val['change_time']),
 					'change_desc'			=> $val['change_desc'],	
 				);
 			}
 			return array('data' => $data, 'pager' => $pager);
 		} else {
 			return array('data' => array(), 'pager' => $pager);
 		}
	}
}

// end