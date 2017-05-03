<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class bonus_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('bonus::bonus.bonus_type_manage'), 	'action_code' => 'bonus_type_manage',	'relevance' => ''),
        	array('action_name' => RC_Lang::get('bonus::bonus.bonus_type_update'), 	'action_code' => 'bonus_type_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('bonus::bonus.bonus_type_delete'), 	'action_code' => 'bonus_type_delete', 	'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end