<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class touch_admin_purview_api extends Component_Event_Api {

    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('H5应用设置'), 'action_code' => 'touch_shop_config', 'relevance'   => ''),
        );

        return $purviews;
    }
}

// end
