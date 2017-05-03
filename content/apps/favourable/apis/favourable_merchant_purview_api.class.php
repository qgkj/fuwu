<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class favourable_merchant_purview_api extends Component_Event_Api {

    public function call(&$options) {
        $purviews = array(
            array('action_name' => __('优惠活动'), 'action_code' => 'favourable_manage', 'relevance'   => ''),
            array('action_name' => RC_Lang::get('favourable::favourable.favourable_update'), 	'action_code' => 'favourable_update', 	'relevance' => ''),
			array('action_name' => RC_Lang::get('favourable::favourable.favourable_delete'), 	'action_code' => 'favourable_delete', 	'relevance' => ''),
        );

        return $purviews;
    }
}

// end
