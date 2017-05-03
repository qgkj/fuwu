<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class mobile extends ecjia_front {
	public function __construct() {	
		parent::__construct();	
		$front_url = RC_App::apps_url('statics/front', __FILE__);
		$front_url = str_replace('sites/api/', '', $front_url);
  		/* js与css加载路径*/
  		$this->assign('front_url', $front_url);
  		$this->assign('title', ecjia::config('shop_name'). '邀请好友注册得奖励');
	}
	
	public function init() {
		
		$invite_code = isset($_GET['invite_code']) ? trim($_GET['invite_code']) : '';
		$urlscheme = ecjia::config('mobile_shop_urlscheme');
		if(preg_match('/ECJiaBrowse/', $_SERVER['HTTP_USER_AGENT'])) {
			header("location: ".$urlscheme."app?open_type=signup&invite_code=".$invite_code);
			exit();
		}
		$affiliate_note = "请输入您的电话并下载移动商城应用程序";
		
		/* 推荐处理 */
		$affiliate = unserialize(ecjia::config('affiliate'));
		if (isset($affiliate['on']) && $affiliate['on'] == 1 && $affiliate['intviee_reward']['intivee_reward_value'] > 0) {
			if ($affiliate['intviee_reward']['intivee_reward_type'] == 'bonus') {
				$reward_value = RC_Model::model('affiliate/affiliate_bonus_type_model')->where(array('type_id' => $affiliate['intviee_reward']['intivee_reward_value']))->get_field('type_money');
				$reward_value = price_format($reward_value);
				$reward_type = '红包';
			} elseif ($affiliate['intviee_reward']['intivee_reward_type'] == 'integral') {
				$reward_value = $affiliate['intviee_reward']['intivee_reward_value'];
				$reward_type = '积分';
			} elseif ($affiliate['intviee_reward']['intivee_reward_type'] == 'balance') {
				$reward_value = price_format($affiliate['intviee_reward']['intivee_reward_value']);
				$reward_type = '现金';
			}
			
			if ($affiliate['intviee_reward']['intivee_reward_by'] == 'signup') {
				$affiliate_note .= "，完成注册后，您将获得".$reward_value.$reward_type."奖励";
			} else {
				$affiliate_note .= "，完成注册首次下单后，您将获得".$reward_value.$reward_type."奖励";
			}
		}
		$data = array(
			'object_type'	=> 'ecjia.affiliate',
			'object_group'	=> 'user_invite_code',
			'meta_key'		=> 'invite_code',
			'meta_value'	=> $invite_code
		);
		$user_id = RC_Model::model('term_meta_model')->where($data)->get_field('object_id');
		if (!empty($user_id)) {
			$user_name = RC_Model::model('affiliate/affiliate_users_model')->where(array('user_id' => $user_id))->get_field('user_name');
			$note = $user_name."为您推荐[ ".ecjia::config('shop_name')." ]移动商城";
			$this->assign('note', $note);
		}
		
		$this->assign('invite_code', $invite_code);
		$this->assign('affiliate_note', $affiliate_note);
		
		$this->display('affiliate.dwt');
	}
	
	public function invite() {
		/* 推荐处理 */
		$affiliate = unserialize(ecjia::config('affiliate'));
		if (isset($affiliate['on']) && $affiliate['on'] == 1) {
			$invite_code = isset($_POST['invite_code']) ? trim($_POST['invite_code']) : '';
			$mobile_phone = isset($_POST['mobile_phone']) ? trim($_POST['mobile_phone']) : '';
			
			
			$count = RC_Model::model('affiliate/affiliate_users_model')->where(array('mobile_phone' => $mobile_phone))->count();
			
			if (!empty($invite_code) && !empty($mobile_phone) && $count <= 0) {
				$data = array(
					'object_type'	=> 'ecjia.affiliate',
					'object_group'	=> 'user_invite_code',
					'meta_key'		=> 'invite_code',
					'meta_value'	=> $invite_code,
				);
				$invite_id = RC_Model::model('term_meta_model')->where($data)->get_field('object_id');
				
				if (!empty($invite_id)) {
					if (!empty($affiliate['config']['expire'])) {
						if($affiliate['config']['expire_unit'] == 'hour') {
							$c = $affiliate['config']['expire'] * 1;
						} elseif($affiliate['config']['expire_unit'] == 'day') {
							$c = $affiliate['config']['expire'] * 24;
						} elseif($affiliate['config']['expire_unit'] == 'week') {
							$c = $affiliate['config']['expire'] * 24 * 7;
						} else {
							$c = 1;
						}
					} else {
						$c = 24; // 过期时间为 1 天
					}
					$time = RC_Time::gmtime() + $c*3600;
					
					/* 判断在有效期内是否已被邀请*/
					$is_invitee = RC_Model::model('affiliate/invitee_record_model')->where(array(
						'invitee_phone' => $mobile_phone,
						'invite_type'	=> 'signup',
						'expire_time'	=> array('gt' => RC_Time::gmtime())
					))->find();
					
					if (empty($is_invitee)) {
						RC_Model::model('affiliate/invitee_record_model')->insert(array(
								'invite_id'		=> $invite_id,
								'invitee_phone' => $mobile_phone,
								'invite_type'	=> 'signup',
								'is_registered' => 0,
								'expire_time'	=> $time,
								'add_time'		=> RC_Time::gmtime()
						));
					}
					
				}
			}
		}
	
		if (stripos($_SERVER['HTTP_USER_AGENT'], "iPhone")) {
			$url = ecjia::config('mobile_iphone_download');
		} elseif (stripos($_SERVER['HTTP_USER_AGENT'], "Android")) {
			$url = ecjia::config('mobile_android_download');
		}
		
		$urlscheme = ecjia::config('mobile_shop_urlscheme');
		$app_url = $urlscheme."app?open_type=signup&invite_code=".$invite_code;
			
		if ( $count > 0) {
			return ecjia_front::$controller->showmessage('该手机号已注册！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
		}
		
		if (isset($is_invitee) && !empty($is_invitee)) {
			return	ecjia_front::$controller->showmessage('您已被邀请过，请勿重复提交！', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
		}
		
		return ecjia_front::$controller->showmessage('提交成功！', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => $url, 'app' => $app_url));
	}
	
	public function qrcode_image() {
		$code = $_GET['invite_code'];
		$value = RC_Uri::site_url().'/index.php?m=affiliate&c=mobile&a=init&invite_code='. $code;
		
		// 二维码
		// 纠错级别：L、M、Q、H
		$errorCorrectionLevel = 'L';
		// 点的大小：1到10
		$matrixPointSize = 10;
		RC_Loader::load_app_class('QRcode', 'affiliate');
		$img = QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);

		echo $img;
	}
}

// end