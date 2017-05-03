<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商店设置
 * @author weidong
 */
class merchant_merchant_purview_api extends Component_Event_Api {
    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('店铺设置'), 'action_code' => 'merchant_manage', 'relevance'   => ''),
        		
            array('action_name' => __('店铺入驻信息'), 'action_code' => 'franchisee_manage', 'relevance'   => ''),
        	array('action_name' => __('店铺入驻信息'), 'action_code' => 'franchisee_request', 'relevance'   => ''),
        	array('action_name' => __('收款账号'), 'action_code' => 'franchisee_bank', 'relevance'   => ''),
            array('action_name' => __('店铺上下线'), 'action_code' => 'merchant_switch', 'relevance'   => ''),
        );
        return $purviews;
    }
}

// end
