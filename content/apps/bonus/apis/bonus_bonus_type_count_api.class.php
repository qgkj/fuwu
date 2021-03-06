<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取红包类型数
 * @author zrl
 */
class bonus_bonus_type_count_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	$bonus_type_db = RC_DB::table('bonus_type as bt');
    	$bonus_type_db->whereNotIn(RC_DB::raw('bt.send_type'),array(100, 101))->where(RC_DB::raw('bt.send_type'), '<>', 100);
    	
    	if (!empty($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
    		$bonus_type_db->where(RC_DB::raw('store_id'), '=', $_SESSION['store_id']);
    	}
    	 
    	if(!empty($options['bonustype_id']) || (isset($options['bonustype_id']) && trim($options['bonustype_id'])==='0' )){
    		$bonus_type_db->where(RC_DB::raw('send_type'), '=', $options['bonustype_id']);
    	}
    	return $bonus_type_db->count();
    }
}

// end