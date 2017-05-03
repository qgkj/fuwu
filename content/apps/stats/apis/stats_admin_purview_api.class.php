<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author wutifang
 */
class stats_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('stats::flow_stats.traffic_analysis'),	'action_code' => 'flow_stats',			'relevance' => ''),
        	array('action_name' => RC_Lang::get('stats::statistic.searchengine'),		'action_code' => 'searchengine_stats',	'relevance' => ''),
        	array('action_name' => RC_Lang::get('stats::statistic.search_keywords'),	'action_code' => 'keywords_stats',		'relevance' => '')
        );
        
        return $purviews;
    }
}

// end