<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class bonus {	
    /**
     * 取得用户等级数组,按用户级别排序
     * @param   bool      $is_special      是否只显示特殊会员组
     * @return  array     rank_id=>rank_name
     */
    public static function get_rank_list($is_special = false) {
    	$db_user_rank = RC_DB::table('user_rank');
    	$db_user_rank->select('rank_id', 'rank_name', 'min_points');
    
    	if ($is_special) {
    		$db_user_rank->where('special_rank', 1);
    	}
    	$data = $db_user_rank->orderby('min_points', 'asc')->get();
    
    	$rank_list = array();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$rank_list[$row['rank_id']] = $row['rank_name'];
    		}
    	}
    	return $rank_list;
    }

    /**
     * 查询红包类型的商品列表 --bonus.func
     * @access public
     * @param integer $type_id
     * @return array
     */
    public static function get_bonus_goods($type_id) {
    	return RC_DB::table('goods')->select('goods_id', 'goods_name')->where('bonus_type_id', $type_id)->get();
    }
    
    /**
     * 取得红包类型数组（用于生成下拉列表）
     * @return  array       分类数组 bonus_typeid => bonus_type_name
     */
    public static function get_bonus_type() {
    	$db = RC_DB::table('bonus_type');
    	$bonus = array();
    
    	if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
    		$db->where(RC_DB::raw('store_id'), $_SESSION['store_id']);
    	}
    	$data = $db->selectRaw('type_id, type_name, type_money')
    			->where(RC_DB::raw('send_type'), 3)
    			->get();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			$bonus[$row['type_id']] = $row['type_name'].' [' .sprintf(ecjia::config('currency_format'), $row['type_money']).']';
    		}
    	}
    	return $bonus;
    }
    
    /**
     * 获取用户红包列表 --bonus.func
     * @access public
     * @param
     * $page_param
     * @return void
     */
    public static function get_bonus_list() {
    	RC_Lang::load('bonus');
    
    	/* 查询条件 */
    	$filter ['sort_by']    = empty($_REQUEST['sort_by']) 	? 'user_bonus.bonus_id'	: trim($_REQUEST['sort_by']);
    	$filter ['sort_order'] = empty($_REQUEST['sort_order'])	? 'DESC'				: trim($_REQUEST['sort_order']);
    	$filter ['bonus_type'] = empty($_REQUEST['bonus_type'])	? 0 					: intval($_REQUEST['bonus_type']);
    
    	$db_user_bonus = RC_DB::table('user_bonus');
    	if (!empty($filter['bonus_type'])) {
    		$db_user_bonus->where('user_bonus.bonus_type_id', '=', $filter['bonus_type']);
    	}
    
    	$count = $db_user_bonus->count();
    	$page = new ecjia_merchant_page ($count, 15, 5);
    
    	$row = $db_user_bonus
	    	->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id')
	    	->leftJoin('users', 'users.user_id', '=', 'user_bonus.user_id')
	    	->leftJoin('order_info', 'order_info.order_id', '=', 'user_bonus.order_id')
	    	->select('user_bonus.*', 'users.user_name', 'users.email', 'order_info.order_sn', 'bonus_type.type_name')
	    	->orderby($filter['sort_by'], $filter['sort_order'])
	    	->take(15)
	    	->skip($page->start_id-1)
	    	->get();
    
    	if (!empty($row)) {
    		foreach($row as $key => $val) {
    			$row[$key]['used_time'] = $val['used_time'] == 0 ? RC_Lang::get('bonus::bonus.no_use') : RC_Time::local_date(ecjia::config('date_format'), $val['used_time']);
    			$row[$key]['emailed']   = RC_Lang::get('bonus::bonus.mail_status.'.$row[$key]['emailed']);
    		}
    	}
    	$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show (2), 'desc' => $page->page_desc ());
    	return $arr;
    }
    
    /**
     * 插入邮件发送队列 --bonus.func
     * @param unknown $username
     * @param unknown $email
     * @param unknown $subject
     * @param unknown $content
     * @param unknown $is_html
     * @return boolean
     */
    public static function add_to_maillist($username, $email, $subject, $content, $is_html) {
    	$time = time ();
    	$content = addslashes ( $content );
    	$template_id = RC_DB::table('mail_templates')->where('template_code', 'send_bonus')->pluck('template_id');
    
    	$data = array (
    		'email' 		=> $email,
    		'template_id' 	=> $template_id,
    		'email_content' => $content,
    		'pri' 			=> 1,
    		'last_send' 	=> $time
    	);
    	RC_DB::table('email_sendlist')->insert($data);
    	return true;
    }
    
    /**
     * 取得红包信息
     * @param   int	 $bonus_id   红包id
     * @param   string  $bonus_sn   红包序列号
     * @param   array   红包信息
     */
    public static function bonus_info($bonus_id, $bonus_sn = '') {
    	$db_view = RC_DB::table('user_bonus')->leftJoin('bonus_type', 'bonus_type.type_id', '=', 'user_bonus.bonus_type_id');
    	$db_view->select('user_bonus.*', 'bonus_type.*');
    
    	if ($bonus_id > 0) {
    		return $db_view->where('user_bonus.bonus_id', $bonus_id)->first();
    	} else {
    		return $db_view->where('user_bonus.bonus_sn', $bonus_sn)->first();
    	}
    }
}

// end