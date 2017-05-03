<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class cycleimage_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('cycleimage::flashplay.flash_manage'), 	'action_code' => 'flash_manage',	'relevance' => ''),
        	array('action_name' => RC_Lang::get('cycleimage::flashplay.flash_update'), 	'action_code' => 'flash_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('cycleimage::flashplay.flash_delete'), 	'action_code' => 'flash_delete', 	'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end