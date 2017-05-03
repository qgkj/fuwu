<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取配送列表信息
 * @author chenzhejun@ecmoban.com 
 */
class express_express_order_list_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options)) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
    	}
    	
    	$db    = RC_DB::table('express_order');
    	$where = array();
    	
    	if (isset($_SESSION['store_id']) && $_SESSION['store_id']) {
    		$db->where('store_id', $_SESSION['store_id']);
    	}
    	
    	if ($options['sort_by'] && $options['sort_order']) {
    	    $db->orderby($options['sort_by'], $options['sort_order']);
    	} else {
    		$db->orderby('express_id', 'desc');
    	}
    	if ($options['limit']) {
    	    $db->take($options['limit']);
    	}
    	if ($options['skip']) {
    	    $db->skip($options['skip']);
    	}
	    	
	    $res = $db->get();
    	return $res;
    }
  
}

// end