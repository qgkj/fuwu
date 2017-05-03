<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author songqian
 */
class adsense_admin_purview_api extends Component_Event_Api {
	public function call(&$options) {
		$purviews = array(
			array('action_name' => RC_Lang::get('adsense::adsense.ads_manage'), 'action_code' => 'adsense_manage', 'relevance' => ''),
			array('action_name' => RC_Lang::get('adsense::adsense.ads_edit'), 'action_code' => 'adsense_update', 'relevance' => ''),
			array('action_name' => RC_Lang::get('adsense::adsense.drop_ads'), 'action_code' => 'adsense_delete', 'relevance' => ''),
				
			array('action_name' => RC_Lang::get('adsense::adsense.ads_position_manage'), 'action_code' => 'ad_position_manage', 'relevance' => ''),
			array('action_name' => RC_Lang::get('adsense::adsense.edit_ads_position'), 'action_code' => 'ad_position_update', 'relevance' => ''),
			array('action_name' => RC_Lang::get('adsense::adsense.drop_ads_position'), 'action_code' => 'ad_position_delete', 'relevance' => '') 
		);
		return $purviews;
	}
}

// end