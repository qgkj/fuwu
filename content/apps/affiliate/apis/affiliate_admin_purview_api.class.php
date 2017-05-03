<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author wutifang
 */
class affiliate_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
        	array('action_name' => RC_Lang::get('affiliate::affiliate.affiliate_config'), 			'action_code' => 'affiliate_config', 			'relevance' => ''),
            array('action_name' => RC_Lang::get('affiliate::affiliate.affiliate_percent_manage'), 	'action_code' => 'affiliate_percent_manage', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('affiliate::affiliate.affiliate_percent_update'), 	'action_code' => 'affiliate_percent_update', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('affiliate::affiliate.affiliate_percent_drop'), 	'action_code' => 'affiliate_percent_drop', 		'relevance' => ''),

        	array('action_name' => RC_Lang::get('affiliate::affiliate.recommend_management'),	'action_code' => 'affiliate_ck_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('affiliate::affiliate.recommend_update'), 		'action_code' => 'affiliate_ck_update', 'relevance' => '')
        );
        return $purviews;
    }
}

// end