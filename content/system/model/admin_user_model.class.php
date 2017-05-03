<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_user_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'admin_user';
		parent::__construct();
	}
	
	
	/**
	 * 获得管理员设置的菜单
	 * @param string $user_id
	 */
	public function get_nav_list($user_id = null) {
		if (empty($user_id)) {
			$user_id = $_SESSION['admin_id'];
		}
		
		$list = array();
		$nav = $this->where("`user_id` = '" . $user_id . "'")->get_field('nav_list');
		if (!empty($nav)) {
			$arr = explode(',', $nav);
			foreach ($arr AS $val) {
				$tmp = explode('|', $val);
				$list[$tmp[1]] = $tmp[0];
			}
		}
		
		return $list;
	}
	
	
	/**
	 * 设置管理员快捷菜单
	 * @param string $user_id
	 */
	public function save_nav_list($user_id, $nav_list) {
	    if (empty($user_id)) {
	        $user_id = $_SESSION['admin_id'];
	    }
	    
	    if (empty($nav_list)) {
	        return false;
	    }
	    
	    return $this->where("`user_id` = '" . $user_id . "'")->update(array('nav_list' => $nav_list));	    
	}
	
	
	/**
	 * 字段是否唯一
	 * @param string $where
	 */
	public function is_only($where = array()) {
		if (empty($where)) {
			return false;
		}
		
		$data = $this->where($where)->count();
		if($data){
			return false;
		}else{
			return true;
		}
	}
	
	
	/**
	 * 删除管理员
	 * @param string $id
	 */
	public function drop($id) {
		if (empty($id)) {
			return false;
		}
		
		return $this->where('user_id='.$id)->delete();
	}
	
	
	/* 获取管理员列表 */
	public function get_admin_userlist($where = array(),$filter = array()) {
		$record_count = $this->where($where)->count();
		$page = new ecjia_page($record_count, 15, 6);
		
		$list = $this->where($where)->field('user_id, user_name, email, add_time, last_login, action_list')->order(array($filter['sort_by'] => $filter['sort_order']))->limit($page->limit())->select();
		$list or $list = array();
		
		foreach ($list AS $key=>$val) {
			$list[$key]['add_time']     = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
			$list[$key]['last_login']   = RC_Time::local_date(ecjia::config('time_format'), $val['last_login']);
		}
		$lists = array('list' => $list, 'page' => $page->show(5));
	
		return $lists;
	}

	/**
	 * 根据会员id查找办事处id
	 * @param 管理员id $user_id
	 */
	public function get_admin_agency_id($user_id) {
		$agency_id = $this->where(array('user_id' => $user_id))->get_field('agency_id');
		return $agency_id;
	}
	
}

// end