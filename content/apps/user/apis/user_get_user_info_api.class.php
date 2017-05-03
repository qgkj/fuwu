<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员信息
 * @author wutifang
 */
class user_get_user_info_api extends Component_Event_Api {
	
	public function call(&$options) {
		
		//为user_id时
		if (is_numeric($options)) {
			$db_users = RC_Model::model('user/users_model');
			
			$user = $db_users->find(array('user_id' => $options));
			
			unset($user['question']);
			unset($user['answer']);
			
			/* 格式化帐户余额 */
			if ($user) {
				$user['formated_user_money']	= price_format($user['user_money'], false);
				$user['formated_frozen_money']	= price_format($user['frozen_money'], false);
			}
		//自定义 字段 table where查询
		} else {
			$db_users_view = RC_Model::model('user/users_viewmodel');
			$table = isset($options['table']) ? $options['table'] : null;
			$field = isset($options['field']) ? $options['field'] : '*';
			
			$user = $db_users_view->join($table)->field($field)->find($options['where']);
		}

		return $user;
	}
}

// end