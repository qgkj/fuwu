<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  支付响应页面
 */
class respond extends ecjia_front {

	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('admin_order', 'orders');
	}
	
	public function init() {
	    
	}
	
	public function response() {
	    RC_Logger::getLogger('pay')->debug('GET: ' . json_encode($_GET));
	    
		/* 支付方式代码 */
		$pay_code = !empty($_GET['code']) ? trim($_GET['code']) : '';
		unset($_GET['code']);
		
		/* 参数是否为空 */
		if (empty($pay_code)) {
			$msg = RC_Lang::get('payment::payment.pay_not_exist');
		} else {
		    $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
		    
		    $payment_list = $payment_method->available_payment_list();

			/* 判断是否启用 */
			if (count($payment_list) == 0) {
				$msg = RC_Lang::get('payment::payment.pay_disabled');
			} else {
			    $payment = $payment_method->get_payment_instance($pay_code);
				/* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
				if (!$payment) {
				    $msg = RC_Lang::get('payment::payment.pay_not_exist');
				} 
				/* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
				elseif ($payment->response()) {
				    $msg = RC_Lang::get('payment::payment.pay_success');
				} else {
				    $msg = RC_Lang::get('payment::payment.pay_fail');
				}
			}

		}
		
		$touch_url = ecjia::config('mobile_touch_url');
		
        $respond =<<<RESPOND
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
        <head>
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
            <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
            <title>支付通知</title>
            
            <style type="text/css">
                body,html,div,p,h2,span{
                    margin:0px;
                    padding:0px;
                }
            </style>
            <script type="text/javascript">
            	function goback() {
            		var useragent = navigator.userAgent;
            		if (useragent.indexOf("ECJiaBrowse") >= 0) {
						var url="ecjiaopen://app?open_type=main";  
    					document.location = url;
					} else {
						window.history.go(-1);
					}  
            	}
            </script>
        </head>
        <body >
            <div style="width:100%;overflow: hidden;margin:0px;padding:0px 0px;text-align: center;">
				<h2 style="background:#18B0EF;line-height:2.5em;height:2.5em;color: #fff;">提示信息</h2>
				<p style="font-size:1.5em; line-height:25px;min-height:100px;padding-top:2em;">{$msg}</p>
				<div class="two-btn" style="margin:1em">
RESPOND;
        if (!empty($touch_url)) {
        	$respond .= '<a class="btn btn-info" href="'.$touch_url.'" style="display: inline-block;background:#4AB9EE;width: 48%;padding: 1em 0;border-radius: 6px;color: #fff;text-decoration: blink;margin-right: 2%;">去微商城购物</a>';
        }
		$respond.=<<<RESPOND
					
					<a class="btn btn-info" href="javascript:goback()" style="display: inline-block;background:#4AB9EE;width: 48%;padding: 1em 0;border-radius: 6px;color: #fff;text-decoration: blink;">返回APP</a>
				</div>
			</div>
        </body>
        </html>
RESPOND;
        
//         echo RC_Hook::apply_filters('payment_respond_template', $respond, $msg);

		$payment_info = $payment_method->payment_info_by_code($pay_code);
		$info = array(
		    'pay_name' => $payment_info['pay_name'],
		    'amount'   => '',
		    'order_id' => $pay_code == 'pay_alipay' ? $_GET['out_trade_no'] : '',
		);
		return $this->response_template($msg, $info);
	}
	
	
	
	public function notify() {
	    RC_Logger::getLogger('pay')->debug('POST: ' . json_encode($_POST));
	      
	    /* 支付方式代码 */
	    $pay_code = !empty($_GET['code']) ? trim($_GET['code']) : '';
	    unset($_GET['code']);
	    
	    /* 参数是否为空 */
	    if (empty($pay_code)) {
	        RC_Logger::getLogger('pay')->debug('paycode_not_exist');
	        die();
	    } else {
	        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
	    
	        $payment_list = $payment_method->available_payment_list();
	    
	        /* 判断是否启用 */
	        if (count($payment_list) == 0) {
	            RC_Logger::getLogger('pay')->debug('payment_disabled');
	            die();
	        } else {
	            $payment = $payment_method->get_payment_instance($pay_code);
	            /* 检查插件文件是否存在，如果存在则验证支付是否成功，否则则返回失败信息 */
	            if (!$payment) {
	                RC_Logger::getLogger('pay')->debug('payment_not_exist');
	                die();
	            }
	            /* 根据支付方式代码创建支付类的对象并调用其响应操作方法 */
	            $result = $payment->notify();
	            if (is_ecjia_error($result)) {
	                RC_Logger::getLogger('pay')->debug('pay_fail: ' . $result->get_error_message());
	                echo "fail";
	                die();
	            } else {
	                RC_Logger::getLogger('pay')->debug('pay_success');
	                echo "success";
	                die();
	            }
	        }
	    }

	}
	
	public function response_template($msg, $info) {
	    
	    $this->assign('msg', $msg);
	    $this->assign('info', $info);
	    $url['index'] = RC_Cookie::get('pay_response_index');
	    $url['order'] = RC_Cookie::get('pay_response_order');
	    $this->assign('url', $url);
	    
	    $this->display('response.dwt');
	}
	
}

// end