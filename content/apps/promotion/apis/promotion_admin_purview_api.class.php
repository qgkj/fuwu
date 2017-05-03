<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class promotion_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('promotion::promotion.promotion_goods_manage'), 'action_code' => 'promotion_manage',	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('promotion::promotion.edit_promotion'), 'action_code' => 'promotion_update', 	'relevance'   => ''),
        	array('action_name' => RC_Lang::get('promotion::promotion.promotion_delete'), 'action_code' => 'promotion_delete', 	'relevance'   => ''),
        );
        
        return $purviews;
    }
}

// end