<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class staff_merchant_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => __('员工管理'), 'action_code' => 'staff_manage', 'relevance'   => ''),
        	array('action_name' => __('员工更新'), 'action_code' => 'staff_update', 'relevance'   => ''),
        	array('action_name' => __('员工删除'), 'action_code' => 'staff_delete', 'relevance'   => ''),
        	array('action_name' => __('员工权限分配'), 'action_code' => 'staff_allot', 'relevance'   => ''),
        		
        	array('action_name' => __('员工组管理'), 'action_code' => 'staff_group_manage', 'relevance'   => ''),
        	array('action_name' => __('员工组更新'), 'action_code' => 'staff_group_update', 'relevance'   => ''),
        	array('action_name' => __('员工组删除'), 'action_code' => 'staff_group_remove', 'relevance'   => ''),
        	
        	array('action_name' => __('员工操作日志'), 'action_code' => 'staff_log_manage', 'relevance'   => ''),
        );
        return $purviews;
    }
}

// end