<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 新会员通知
 * @author will
 */
class user_remind_user_api extends Component_Event_Api {
	
	public function call(&$options) {
		
		$db_user = RC_Model::model('user/users_model');
		if (empty($_SESSION['last_check'])) {
			$_SESSION['last_check'] = RC_Time::gmtime();
			return array('new_user_count' => 0);
		}
		
		$new_user = $db_user->where(array('reg_time' => array('egt' => $_SESSION['last_check'])))->count();
		
		
		if ($new_user > 0 ) {
			return array('new_user_count' => $new_user);
		} else {
			return array('new_user_count' => 0);
		}
	}
}

// end