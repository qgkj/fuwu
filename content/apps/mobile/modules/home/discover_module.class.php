<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * discover
 * @author will.chen
 */
class discover_module extends api_front implements api_interface {

	    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	$this->authSession();
		//检测是否有用户登陆状态
		
		$mobile = RC_Loader::load_app_class('mobile_method','mobile');
		$discover_data = array();
		$mobile_menu   = array_merge($mobile->discover_data(true));
		if (!empty($mobile_menu)) {
			foreach ($mobile_menu as $val) {
				if ($val['display'] == '1') {
					$discover_data[] = array(
						'image'	=> $val['src'],
						'text'	=> $val['text'],
						'url'	=> $val['url']
					);
				}
			}
		}
		
		return $discover_data;		
	}
}

// end