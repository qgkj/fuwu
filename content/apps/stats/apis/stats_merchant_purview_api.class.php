<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author 
 */
class stats_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('搜索关键字'), 'action_code' => 'stats_search_keywords', 'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end