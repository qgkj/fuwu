<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile extends ecjia_front {

	public function __construct() {	
		parent::__construct();	
		
  		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('templates/front', __FILE__));
	}
	
	public function download() {
        $this->assign('page_title', ecjia::config('shop_name') . ' - 手机APP下载');

        $this->assign('shop_url', RC_Uri::url('touch/index/init'));
        $this->assign('shop_app_icon', ecjia::config('mobile_app_icon') ? RC_Upload::upload_url(ecjia::config('mobile_app_icon')) : RC_Uri::admin_url('statics/images/nopic.png'));
        $this->assign('shop_app_description', ecjia::config('mobile_app_description') ? ecjia::config('mobile_app_description') : '暂无手机应用描述');
        $this->assign('shop_android_download', ecjia::config('mobile_android_download'));
        $this->assign('shop_iphone_download', ecjia::config('mobile_iphone_download'));
        $this->assign('shop_ipad_download', ecjia::config('mobile_ipad_download'));
        
        $this->assign_lang();
        
        
        $this->display(
        	RC_Package::package('app::mobile')->loadTemplate('front/download.dwt', true)
        );

    }
	
}

// end