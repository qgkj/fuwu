<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取商家活动
 * @author zrl
 * 购物车有调用 by hyy
 */
class favourable_favourable_list_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	
    	$favourable_activity_dbview = RC_DB::table('favourable_activity as fa');
    	
    	/* 判断是否有store应用*/
    	$result = ecjia_app::validate_application('store');
    	if (!is_ecjia_error($result)) {
    		$favourable_activity_dbview->leftJoin('store_franchisee as s', RC_DB::raw('fa.store_id'), '=', RC_DB::raw('s.store_id'))->selectRaw('fa.*, s.merchants_name');
    	}
    	
    	if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
    	    $favourable_activity_dbview->where(RC_DB::raw('fa.store_id'), $_SESSION['store_id']);
    	}
    	
    	if (isset($options['keyword']) && !empty($options['keyword'])) {
    		$favourable_activity_dbview->where('act_name', 'like', '%' . $options['keyword'] . '%');
    	}
    	
    	if (isset($options['merchant_name']) && !empty($options['merchant_name'])) {
    		$favourable_activity_dbview->where('merchants_name', 'like', '%' . $options['merchant_name'] . '%');
    	}
    	
    	if (isset($options['type']) && $options['type'] == 'on_going') {
    		$time = RC_Time::gmtime();
    		$favourable_activity_dbview->where('start_time', '<=', $time)->where('end_time', '>=', $time);
    	} elseif (isset($options['type']) && $options['type'] == 'merchants') {
    		$favourable_activity_dbview->where(RC_DB::raw('fa.store_id'), '>', 0);
    	} elseif (isset($options['type']) && $options['type'] == 'self') {
    		$favourable_activity_dbview->where(RC_DB::raw('s.manage_mode'), 'self');
    	}
    	
    	if (isset($options['store_id']) && !empty($options['store_id'])) {
    	    if (is_array($options['store_id'])) {
    	        $favourable_activity_dbview->whereIn(RC_DB::raw('fa.store_id'), $options['store_id']);
    	    } else {
    	        $favourable_activity_dbview->where(RC_DB::raw('fa.store_id'), $options['store_id']);
    	    }
    	}
    	if ($options['sort_by'] && $options['sort_order']) {
    	    $favourable_activity_dbview->orderby($options['sort_by'], $options['sort_order']);
    	}
    	if ($options['limit']) {
    	    $favourable_activity_dbview->take($options['limit']);
    	}
    	if ($options['skip']) {
    	    $favourable_activity_dbview->skip($options['skip']);
    	}
	    	
	    $res = $favourable_activity_dbview->get();
    	return $res;
    }
  
}

// end