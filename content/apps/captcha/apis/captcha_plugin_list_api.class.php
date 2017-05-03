<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 轮播图插件列表API
 * @author royalwang
 */
class captcha_plugin_list_api extends Component_Event_Api {
	
	public function call(&$options) {
		$captcha = RC_Loader::load_app_class('captcha_method', 'captcha');
		
		$list = $captcha->captcha_list();

		return $list;
	}
}

// end