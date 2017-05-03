<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class commission_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('账单列表'), 'action_code' => 'commission_manage', 'relevance'   => ''),
            array('action_name' => __('账单详情'), 'action_code' => 'commission_detail', 'relevance'   => ''),
            array('action_name' => __('订单分成'), 'action_code' => 'commission_order', 'relevance'   => ''),
            array('action_name' => __('结算统计'), 'action_code' => 'commission_count', 'relevance'   => ''),
        );
        return $purviews;
    }
}

// end