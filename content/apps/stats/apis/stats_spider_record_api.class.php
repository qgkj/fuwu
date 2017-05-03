<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台菜单API
 * @author wutifang
 */
class stats_spider_record_api extends Component_Event_Api {
	
	public function call(&$options) {
        $db = RC_Model::model('stats/searchengine_model');
	    
        $spider = $options['searchengine'];
        
        if ($spider) {
            $insert_data = array(
                'date' 			=> RC_Time::local_date('Y-m-d'),
                'searchengine' 	=> $spider,
                'count' 		=> 1
            );
            $update_data = array(
                'count'         => `count` + 1
            );
            $db->auto_replace($insert_data, $update_data);
            return true;
        } else {
            return false;
        }
	}
}

// end