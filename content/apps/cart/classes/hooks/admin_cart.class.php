<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class flow_hooks {
	/**
	 * 清除购物车中过期的数据
	 */
	public static function clear_cart() {
	    $lasttime = RC_Cache::app_cache_get('clean_cart_session', 'cart');
	    if (! $lasttime) {
	        $db_view = RC_Model::model('cart/cart_sessions_viewmodel');
	        $db = RC_Model::model('cart/cart_model');
	        /* 取得有效的session */
	        $valid_sess = $db_view->join('sessions')->select();
	        
	        if (!empty($valid_sess)) {
	            $sess_arr = array();
	            foreach ($valid_sess as $sess) {
	            	if (!empty($sess['session_id'])){
	            		$sess_arr[] = $sess['session_id'];
	            	}
	            }
	        
	            // 删除cart中无效的数据
	            if (!empty($sess_arr)) {
	            	$db->in(array('session_id' => $sess_arr), true)->delete();
	            }
	        }
	        RC_Cache::app_cache_set('clean_cart_session', 'clean_cart_session', 'cart', 1440);
	    }
	}
}

RC_Hook::add_action( 'ecjia_admin_finish_launching', array('flow_hooks', 'clear_cart') );

// end