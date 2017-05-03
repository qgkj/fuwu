<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author wutifang
 */
class shopguide_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('shopguide::shopguide.shopguide_setup'), 'action_code' => 'shopguide_setup', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end