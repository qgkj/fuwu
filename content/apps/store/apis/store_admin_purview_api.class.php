<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class store_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	//入驻商权限	
            array('action_name' => RC_Lang::get('store::store.store_affiliate'), 'action_code' => 'store_affiliate_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('store::store.store_update'), 'action_code' => 'store_affiliate_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('store::store.store_lock'), 'action_code' => 'store_affiliate_lock', 	'relevance' => ''),

        	array('action_name' => '店铺设置', 		'action_code' => 'store_set_manage', 		'relevance' => ''),
            array('action_name' => '修改店铺设置', 	'action_code' => 'store_set_update', 		'relevance' => ''),
            array('action_name' => '资质认证', 		'action_code' => 'store_auth_manage', 		'relevance' => ''),
        	array('action_name' => '佣金设置', 		'action_code' => 'store_commission_update', 'relevance' => ''),
            array('action_name' => '查看员工', 		'action_code' => 'store_staff_manage', 		'relevance' => ''),
            array('action_name' => '配送方式', 		'action_code' => 'store_shipping_manage', 	'relevance' => ''),
            array('action_name' => '查看日志', 		'action_code' => 'store_log_manage', 		'relevance' => ''),
            array('action_name' => '删除日志', 		'action_code' => 'store_log_delete', 		'relevance' => ''),
        		
        	//待审核入驻商权限
        	array('action_name' => RC_Lang::get('store::store.store_preaudit'), 'action_code' => 'store_preaudit_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('store::store.store_update'), 'action_code' => 'store_preaudit_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('store::store.store_check'), 'action_code' => 'store_preaudit_check', 	'relevance' => ''),
            array('action_name' => '查看审核日志', 'action_code' => 'store_preaudit_check_log', 	'relevance' => ''),
        	
        	//店铺分类权限
        	array('action_name' => __('店铺分类管理'), 'action_code' => 'store_category_manage', 'relevance'   => ''),
        	array('action_name' => __('店铺分类删除'), 'action_code' => 'store_category_drop', 'relevance'   => ''),

        	//佣金比例权限
        	array('action_name' => __('佣金比例管理'), 'action_code' => 'store_percent_manage', 'relevance'   => ''),
        	array('action_name' => __('佣金比例添加'), 'action_code' => 'store_percent_add', 'relevance'   => ''),
        	array('action_name' => __('佣金比例更新'), 'action_code' => 'store_percent_update', 'relevance'   => ''),
        	array('action_name' => __('佣金比例删除'), 'action_code' => 'store_percent_delete', 'relevance'   => ''),
        		
        	array('action_name' => __('后台设置'), 'action_code' => 'store_config_manage', 'relevance'   => ''),
//         	array('action_name' => __('移动应用设置'), 'action_code' => 'store_mobileconfig_manage', 'relevance'   => ''),

        	//商家公告
        	array('action_name' => __('商家公告管理'), 'action_code' => 'store_notice_manage', 'relevance'   => ''),
        	array('action_name' => __('商家公告更新'), 'action_code' => 'store_notice_update', 'relevance'   => ''),
        	array('action_name' => __('商家公告删除'), 'action_code' => 'store_notice_delete', 'relevance'   => ''),
        );
        
        return $purviews;
    }
}

// end