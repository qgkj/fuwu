<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取用户列表
 * @author wutifang
 */
class user_get_user_list_api extends Component_Event_Api {
	
    /**
     * @param  $options['keywords'] 关键字
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('user::users.invalid_parameter'));
	    }
	   	return $this->get_user_list($options);
	}
	
	/**
	 * 取得用户列表
	 * @param   object  $filters    过滤条件
	 */
	private function get_user_list($options) {
		$db_user = RC_Model::model('user/users_model');
		
		$filter['keywords']		= empty($options['keywords'])		? ''		: trim($options['keywords']);
		$filter['rank']			= empty($options['rank'])			? 0			: intval($options['rank']);
		$filter['sort_by']		= empty($options['sort_by'])		? 'user_id' : trim($options['sort_by']);
		$filter['sort_order']	= empty($options['sort_order'])		? 'DESC'	: trim($options['sort_order']);
		
		$where = array();
		if ($filter['keywords']) {
			$where[] = "(user_name LIKE '%" . mysql_like_quote($filter['keywords']) ."%' or email like '%".$filter['keywords'] ."%'or mobile_phone like '%".$filter['keywords'] ."%')"; 
		}
		if ($filter['rank']) {
			$db_user_rank = RC_Model::model('user/user_rank_model');
			$row = $db_user_rank->field(array('min_points', 'max_points', 'special_rank'))->where(array('rank_id' => $filter['rank']))->find();
			if ($row['special_rank'] > 0) {
				$where['user_rank'] = $filter['rank'];
			} else {
				$where[] = "rank_points >= " . intval($row['min_points']) . " AND rank_points < " . intval($row['max_points']);
			}
		}
	
		$count = $db_user->where($where)->count();
		$page = new ecjia_page($count, 15, 6);
		
		$limit = isset($options['is_page']) ? $page->limit() : null;
		$field = 'user_id, user_name, email, is_validated, user_money, frozen_money, rank_points, pay_points, reg_time';

		$data = $db_user->field($field)->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))->limit($limit)->select();
		$user_list = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['reg_time']	= RC_Time::local_date(ecjia::config('time_format') , $rows['reg_time']);
				$user_list[]		= $rows;
			}
		}
		
		if (isset($options['is_page'])) {
			return array('user_list' => $user_list , 'filter' => $filter , 'page' => $page->show(5) , 'desc' => $page->page_desc());
		} else {
			return $user_list;
		}
	}
}

// end