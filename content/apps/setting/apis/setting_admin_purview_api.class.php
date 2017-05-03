<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class setting_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('商店设置'), 	'action_code' => 'shop_config', 	'relevance' => ''),
        	array('action_name' => __('地区设置'), 	'action_code' => 'area_manage', 	'relevance' => ''),
        );
        return $purviews;
    }
}

// end