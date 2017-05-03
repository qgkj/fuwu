<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取配送总数
 * @author chenzhejun@ecmoban.com
 * @param   array	 $options
 * @return  array   商家活动数组
 */
class express_express_order_count_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', '参数无效');
    	}
    	
    	$db    = RC_DB::table('express_order');
    	$where = array();
    	
    	if (isset($_SESSION['store_id']) && $_SESSION['store_id']) {
    		$db->where('store_id', $_SESSION['store_id']);
    	}
    	return $db->count();
    }
}

// end