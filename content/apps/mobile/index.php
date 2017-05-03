<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class index extends ecjia_front {

	public function __construct() {	
		parent::__construct();	
		
  		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('templates/front', __FILE__));
	}
	
	public function init()
	{
		$code = $_GET['qrcode'];
		$value = RC_Uri::url('mobile/index/login', array('qrcode' => $code));
		// 二维码
		// 纠错级别：L、M、Q、H
		$errorCorrectionLevel = 'L';
		// 点的大小：1到10
		$matrixPointSize = 10;
		RC_Loader::load_app_class('QRcode', 'touch');
		$img = QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);
		echo $img;
	}
	
	public function login()
	{
		/* js加载ecjia.js*/
		$this->assign('ecjia_js', RC_Uri::admin_url('statics/lib/ecjia-js/ecjia.js'));
		/* js与css加载路径*/
		$this->assign('front_url', RC_App::apps_url('templates/front', __FILE__));
		
		$qrcode = $_GET['qrcode'];
		$db = RC_Model::model('mobile/qrcode_validate_model');
		
		$info = $db->find(array('uuid' => $qrcode));
		//判断前后台
		if (!empty($info) && $info['is_admin']) {
			$urlscheme = ecjia::config('mobile_shopkeeper_urlscheme');
			$this->assign('upload_image', RC_App::apps_url('mobile/templates/front/image/icon.png'));
			$this->assign('android_upload_url', 'http://www.pgyer.com/ecjia-shopkeeper-android');
			$this->assign('iphone_upload_url', 'http://www.pgyer.com/ecjia-shopkeeper-iphone');
		} else {
			$urlscheme = ecjia::config('mobile_shop_urlscheme');
			$this->assign('upload_image', RC_App::apps_url('mobile/templates/front/image/icon1.png'));
			$this->assign('android_upload_url', ecjia::config('mobile_android_download'));
			$this->assign('iphone_upload_url', ecjia::config('mobile_iphone_download'));
		}
		
		/* 判断是否是ecjia设备扫描*/
// 		ECJiaBrowse/1.2.0
		if(!preg_match('/ECJiaBrowse/', $_SERVER['HTTP_USER_AGENT'])) {
			// 通过iframe的方式试图打开APP，如果能正常打开，会直接切换到APP，并自动阻止a标签的默认行为
			// 否则打开a标签的href链接
			$js = "<script>var ifr = document.createElement('iframe');
			ifr.src = '".trim($urlscheme)."app?open_type=qrlogin';
			ifr.style.display = 'none';
			document.body.appendChild(ifr);
			window.setTimeout(function(){
				document.body.removeChild(ifr);
			},3000);</script>";
			
			$this->assign('js', $js);
			$this->display('app_loading.dwt');exit();
	    }
	    
	    $where = array(
	    		'expires_in' => array('gt' => RC_Time::gmtime()),
	    		'status'	 => 0,
	    		'uuid'		 => $qrcode,
	    );
		
		$db->where($where)->update(array('status' => 1));
		
		header("location: ".$urlscheme."app?open_type=qrlogin");
	}
}

// end