<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推荐奖励的记录
 * @author will.chen
 */
class record_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		$this->authSession();
		if ($_SESSION['user_id'] <= 0 ) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$date = $this->requestData('date');
		$size = $this->requestData('pagination.count', 15);
 		$page = $this->requestData('pagination.page', 1);
		
		if (empty($date)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$count = RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], "FROM_UNIXTIME(add_time, '%Y-%m')" => $date))->count();
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$list_result = RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], "FROM_UNIXTIME(add_time, '%Y-%m')" => $date))->limit($page_row->limit())->order(array('add_time' => 'desc'))->select();
		
		$list = array();
		foreach ($list_result as $val) {
			if ($val['reward_type'] == 'bonus') {
				$reward_type = '红包';
				$val['reward_value'] = RC_Model::model('affiliate/affiliate_bonus_type_model')->where(array('type_id' => $val['reward_value']))->get_field('type_name');
			} elseif ($val['reward_type'] == 'balance') {
				$reward_type = '现金';
				$val['reward_value'] = price_format($val['reward_value']);
			} else {
				$reward_type = '积分';
			}
			
			$list[] = array(
				'invitee_name'		=> $val['invitee_name'],
				'label_reward_type'	=> '邀请'.$val['invitee_name'].'成功，奖励'.$reward_type,
				'reward_type'		=> $val['reward_type'],
				'give_reward'		=> $val['reward_value'],
				'reward_time'		=> RC_Time::local_date(ecjia::config('time_format'), $val['add_time']),
			);
			
		}
		
		$pager = array(
			"total" => $page_row->total_records,
			"count" => $page_row->total_records,
			"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		return array('data' => $list, 'pager' => $pager);
	}
}

// end