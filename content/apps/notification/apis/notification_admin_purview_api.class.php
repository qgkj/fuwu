<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author wutifang
 */
class notification_admin_purview_api extends Component_Event_Api {

    public function call(&$options) {
        $purviews = array(
            array('action_name' => '通知管理', 'action_code' => 'notification_manage', 'relevance' => ''),
            array('action_name' => '通知更新', 'action_code' => 'notification_update', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end
