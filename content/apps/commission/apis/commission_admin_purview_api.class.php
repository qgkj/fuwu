<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class commission_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            
            //结算权限
            array('action_name' => __('结算账单'), 'action_code' => 'commission_manage', 'relevance'   => ''),
            array('action_name' => __('账单详情'), 'action_code' => 'commission_detail', 'relevance'   => ''),
            array('action_name' => __('打款'), 'action_code' => 'commission_pay', 'relevance'   => ''),
            array('action_name' => __('打款流水'), 'action_code' => 'commission_paylog', 'relevance'   => ''),
            array('action_name' => __('订单分成'), 'action_code' => 'commission_order', 'relevance'   => ''),
        );
        return $purviews;
    }
}

// end