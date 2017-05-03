<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class bonus_merchant_purview_api extends Component_Event_Api {

    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('红包类型管理'), 'action_code' => 'bonus_type_manage', 'relevance'   => ''),
            array('action_name' => RC_Lang::get('bonus::bonus.bonus_type_update'), 	'action_code' => 'bonus_type_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('bonus::bonus.bonus_type_delete'), 	'action_code' => 'bonus_type_delete', 	'relevance' => ''),
           
            array('action_name' => __('红包管理'), 'action_code' => 'bonus_manage', 	'relevance' => ''),
            array('action_name' => __('发送红包'), 'action_code' => 'bonus_send', 	'relevance' => ''),
            array('action_name' => __('删除红包'), 'action_code' => 'bonus_delete', 'relevance' => ''),
        );

        return $purviews;
    }
}

// end
