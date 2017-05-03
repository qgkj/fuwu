<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员统计
 * @author will.chen
 */
class user_user_stats_api extends Component_Event_Api {
    
    public function call(&$options) {
    	$cache_key = 'api_user_stats_'.md5($_SESSION['admin_id']);
        $stats = RC_Cache::app_cache_get($cache_key, 'user');
        if (!$stats) {
    	
			$db_user = RC_Model::model('user/users_model');
	        /* 获取会员总数*/
			$stats['total'] = $db_user->count();
			RC_Cache::app_cache_set($cache_key, $stats, 'user', 120);//2小时缓存
        }
		return $stats;
    }
}

// end