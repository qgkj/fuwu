<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

abstract class EM_Api {
    public static $session = array();

    public static $pagination = array();

    public static $token = null;
    
    protected static $error = array(
        6 => '密码错误',
        8 => '处理失败',
        11 => '用户名或email已使用',
        13 => '不存在的信息',
        14 => '购买失败',
        100 => 'Invalid session',
        101 => '错误的参数提交',
        200 => '用户名不能为空',
        201 => '用户名含有敏感字符',
        202 => '用户名 已经存在',
        203 => 'email不能为空',
        204 => '不是合法的email地址',
        300 => '对不起，指定的商品不存在',
        301 => '对不起，您希望将该商品做为配件购买，可是购物车中还没有该商品的基本件。',
        302 => '对不起，该商品已经下架。',
        303 => '对不起，该商品不能单独销售。',
        501 => '没有pagination结构',
        502 => 'code错误',
        503 => '合同期终止',
        10001 => '您必须选定一个配送方式',
        10002 => '购物车中没有商品',
        10003 => '您的余额不足以支付整个订单，请选择其他支付方式。',
        10005 => '您选择的超值礼包数量已经超出库存。请您减少购买量或联系商家。',
        10006 => '如果是团购，且保证金大于0，不能使用货到付款',
        10007 => '您已收藏过此商品',
        10008 => '库存不足',
        10009 => '订单无发货信息',
        10010 => '该订单已经支付，请勿重复支付。',
        99999 => '该网店暂停注册'
    );

    public static function init() {
        if (! empty($_POST['json'])) {
            $_POST['json'] = stripslashes($_POST['json']);
            $_POST = json_decode($_POST['json'], true);
        }
        self::$session = _POST('session', array());
        
        self::$token = _POST('token');
        
        self::$pagination = _POST('pagination', array(
            'page' => 1,
            'count' => 10
        ));
    }

    /**
     * 登录授权验证
     */
    public static function authSession($validate = true) {
    	if (isset(self::$token) && !empty(self::$token)) {
    		if (RC_Session::session_id() != self::$token) {
    			RC_Session::destroy();
    			RC_Session::init(null, self::$token);
    		}
    		
    		define('SESS_ID', RC_Session::session()->get_session_id());
    		
    		if (empty($_SESSION['user_id']) && empty($_SESSION['admin_id']) && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    	} else {
    		if ((!isset(self::$session['uid']) || !isset(self::$session['sid'])) && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    		
    		if (isset(self::$session['sid']) && !empty(self::$session['sid']) && RC_Session::session_id() != self::$session['sid']) {
    			RC_Session::destroy();
    			RC_Session::init(null, self::$session['sid']);
    		}
    		
    		define('SESS_ID', RC_Session::session()->get_session_id());
    		
    		if (empty($_SESSION['user_id']) && empty($_SESSION['admin_id'])  && $validate) {
    			self::outPut(100);
//     			return new ecjia_error('invalid_session', 'Invalid session');
    		}
    	}
        
    }

//     public static function outPut($data, $pager = NULL, $privilege = NULL)
    public static function outPut($data) {
        if (is_ecjia_error($data)) {
            $status = array(
                'status' => array(
                    'succeed' => 0,
                    'error_code' => $data->get_error_code(),
                    'error_desc' => $data->get_error_message(),
                )
            );
            die(json_encode($status));
        } elseif (is_int($data)) {
            $status = array(
                'status' => array(
                    'succeed' => 0,
                    'error_code' => $data,
                    'error_desc' => self::$error[$data]
                )
            );
            die(json_encode($status));
        }
        
        $response = array('data' => array(), 'status' => array('succeed' => 1));
        
        if (isset($data['data'])) {
            $response['data'] = $data['data'];
        } else {
        	$response['data'] = $data;
        }
        
        if (isset($data['pager'])) {
        	$response['paginated'] = $data['pager'];
        }
        
//         /* 后台新增*/
//         if (!empty($privilege)) {
//         	$data = array_merge($data, array(
//         			'privilege' => $privilege
//         	));
//         }
        
        header("Content-type: application/json; charset=UTF-8");
        die(json_encode($response));
    }

    public static function device_record() {
    	$result = ecjia_app::validate_application('mobile');
    	if (!is_ecjia_error($result)) {
    		$device = _POST('device', array());
    		if (!empty($device['udid']) && !empty($device['client']) && !empty($device['code'])) {
    			$db_mobile_device = RC_Loader::load_app_model('mobile_device_model', 'mobile');
    			$device_data = array(
    					'device_udid'	=> $device['udid'],
    					'device_client'	=> $device['client'],
    					'device_code'	=> $device['code']
    			);
    			$row = $db_mobile_device->find($device_data);
    			if(empty($row)) {
    				$device_data['add_time'] = RC_Time::gmtime();
    				$db_mobile_device->insert($device_data);
    			}
    		}
    	}
    }
    
    public static function stats($api_name) {
    	self::authSession(false);
    	$db_stats = RC_Loader::load_app_model('stats_model', 'stats');
    	$time = RC_Time::gmtime();
    	/* 检查客户端是否存在访问统计的cookie */
    	$expire = $_SESSION['stats_expire'];
		if (empty($expire) || ($expire < $time) ) {
			$access_url	= $api_name;
			$ip_address	= RC_Ip::client_ip();
			$area		= RC_Ip::area($ip_address);
			$device		= _POST('device', array());
			$system		= isset($device['client']) ? $device['client'] : '';
			$browser	= isset($device['code']) ? $device['code'] : '';
			$stats_data = array(
				'visit_times'=> 1,
				'access_time'=> $time,
				'ip_address' => $ip_address,
				'system'     => $system,
				'browser'	 => $browser,
				'area'		 => $area,
				'access_url' => $access_url,
			); 
			$db_stats->insert($stats_data);
			$_SESSION['stats_expire'] = $time + 10800;
		}
    }
}

//end