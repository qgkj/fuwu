<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author wutifang
 */
class cron_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('cron::cron.cron_manage'), 'action_code' => 'cron_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('cron::cron.cron_update'), 'action_code' => 'cron_update', 'relevance' => ''),
        	array('action_name' => __('执行'), 'action_code' => 'cron_run', 'relevance' => '')
        );
        return $purviews;
    }
}

// end