<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class shipping_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('我的配送'), 'action_code' => 'ship_merchant_manage', 'relevance'   => ''),
            array('action_name' => __('配送编辑'), 'action_code' => 'ship_merchant_update', 'relevance'   => ''),
            array('action_name' => __('删除配送'), 'action_code' => 'ship_merchant_delete', 'relevance'   => ''),
        );
        
        return $purviews;
    }
}

// end