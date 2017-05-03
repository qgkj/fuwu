<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class index extends ecjia_front {

    public function init() {

		$merchant_url     = RC_Uri::url('franchisee/merchant/init');
		$merchant_url     = str_replace('index.php', 'sites/merchant/index.php', $merchant_url);
        $merchant_login   = RC_Uri::url('staff/privilege/login');
        $merchant_login   = str_replace('index.php', 'sites/merchant/index.php', $merchant_login);
        $this->assign('merchant_url', $merchant_url);
		$this->assign('merchant_login',$merchant_login);
		// 应用预览图
		$mobile_app_preview_temp 	= ecjia::config('mobile_app_preview');
		$mobile_app_preview 		= unserialize($mobile_app_preview_temp);
		$mobile_app_preview1        = !empty($mobile_app_preview[0])? RC_Upload::upload_url().'/'.$mobile_app_preview[0] : '';
		$mobile_app_preview2        = !empty($mobile_app_preview[1])? RC_Upload::upload_url().'/'.$mobile_app_preview[1] : '';
		// 下载二维码
		$mobile_android_qrcode 		= ecjia::config('mobile_android_qrcode');
		$mobile_iphone_qrcode 		= ecjia::config('mobile_iphone_qrcode');
		$mobile_android_qrcode 		= !empty($mobile_android_qrcode)? RC_Upload::upload_url().'/'.$mobile_android_qrcode : '';
		$mobile_iphone_qrcode 		= !empty($mobile_iphone_qrcode)? RC_Upload::upload_url().'/'.$mobile_iphone_qrcode : '';
		$shop_logo 					= ecjia::config('shop_logo');
		$shop_wechat_qrcode 		= ecjia::config('shop_wechat_qrcode');
		$shop_logo 					= !empty($shop_logo)? RC_Upload::upload_url().'/'.$shop_logo : '';
		$shop_wechat_qrcode 		= !empty($shop_wechat_qrcode)? RC_Upload::upload_url().'/'.$shop_wechat_qrcode : '';
		$mobile_touch_qrcode    	= ecjia::config('mobile_touch_qrcode');
		$mobile_touch_qrcode        = !empty($mobile_touch_qrcode)? RC_Upload::upload_url($mobile_touch_qrcode) : '';

        $shop_info = RC_DB::table('article')->select('article_id', 'title')->where('cat_id', 0)->orderby('article_id', 'asc')->get();
        if(!empty($shop_info)){
            foreach($shop_info as $key => $val){
                $url                    = RC_Uri::url('merchant/merchant/shopinfo', array('id' => $val['article_id']));
                $shop_info[$key]['url'] = str_replace('index.php', 'sites/merchant/index.php', $url);
            }
        }

        $screenshots = RC_DB::table('mobile_screenshots')->where('app_code', '=', 'cityo2o')->orderBy('sort','asc')->take(10)->get();
        foreach($screenshots as $key => $val){
            $screenshots[$key]['img_url'] = !empty($val['img_url'])? RC_Upload::upload_url($val['img_url']) : '';
            if(empty($val['img_url'])) unset($screenshots[$key]);
        }
        
        $this->assign_title();

        $this->assign('screenshots',            $screenshots);
        $this->assign('shop_info',              $shop_info);
        $this->assign('company_name',           ecjia::config('company_name'));
        $this->assign('service_phone',          ecjia::config('service_phone'));
        $this->assign('shop_address',           ecjia::config('shop_address'));
		$this->assign('mobile_app_name', 		ecjia::config('mobile_app_name'));
		$this->assign('mobile_app_version', 	ecjia::config('mobile_app_version'));
		$this->assign('mobile_app_description', ecjia::config('mobile_app_description'));
		$this->assign('mobile_app_video', 		ecjia::config('mobile_app_video'));
		$this->assign('shop_weibo_url', 		ecjia::config('shop_weibo_url'));
        $this->assign('mobile_app_video',       ecjia::config('mobile_app_video'));
        
        $stats_code = ecjia::config('stats_code');
        $this->assign('stats_code', 			stripslashes($stats_code));
		$this->assign('mobile_app_privew1', 	$mobile_app_preview1);
		$this->assign('mobile_app_privew2', 	$mobile_app_preview2);
		$this->assign('mobile_app_screenshots', ecjia::config('mobile_app_screenshots'));
		$this->assign('mobile_iphone_download', ecjia::config('mobile_iphone_download'));
		$this->assign('mobile_android_download',ecjia::config('mobile_android_download'));
		$this->assign('mobile_iphone_qrcode', 	$mobile_iphone_qrcode);
		$this->assign('mobile_android_qrcode', 	$mobile_android_qrcode);
		$this->assign('mobile_touch_url',       ecjia::config('mobile_touch_url'));
		$this->assign('touch_qrcode', 	        $mobile_touch_qrcode);
		$this->assign('shop_logo', 				$shop_logo);
		$this->assign('shop_wechat_qrcode', 	$shop_wechat_qrcode);
		$this->assign('powered', 	'Powered&nbsp;by&nbsp;<a href="https:\/\/ecjia.com" target="_blank">ECJia</a>');
        $this->display('index.dwt');
    }
}

//end