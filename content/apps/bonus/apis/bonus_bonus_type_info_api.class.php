<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取红包类型信息
 * @author zrl
 */
class bonus_bonus_type_info_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	$bonus_type_db = RC_DB::table('bonus_type as bt');
    	
    	if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
    		$bonus_type_db->where(RC_DB::raw('store_id'), '=', $_SESSION['store_id']);
    	}
    	 
    	if(!empty($options['type_id'])  && $options['type_id'] > 0 ){

    		$bonus_type_db->where(RC_DB::raw('type_id'), '=', $options['type_id']);
    	}
    	return $bonus_type_db->first();
    }
}

// end