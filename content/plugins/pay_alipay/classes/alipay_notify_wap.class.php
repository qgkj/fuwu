<?php
  

class alipay_notify_wap extends alipay_notify {
    /**
     * HTTPS形式消息验证地址
     */
    protected $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    /**
     * HTTP形式消息验证地址
     */
    protected $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    
    public function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }

    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    public function verify_notify() {
        //判断POST来的数组是否为空
        if (empty($_POST)) {
            return false;
        } else {
            //对notify_data解密
            $decrypt_post_param = $_POST;
            if ($this->alipay_config['sign_type'] == '0001') {
                $decrypt_post_param['notify_data'] = $this->decrypt($decrypt_post_param['notify_data']);
            }
             
            //notify_id从decrypt_post_param中解析出来（也就是说decrypt_post_param中已经包含notify_id的内容）
            $doc = new DOMDocument();
            $doc->loadXML($decrypt_post_param['notify_data']);
            $notify_id = $doc->getElementsByTagName('notify_id')->item(0)->nodeValue;
             
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $response_text = 'true';
            if (!empty($notify_id)) {
                $response_text = $this->get_response($notify_id);
            }
             
            //生成签名结果
            $isSign = $this->get_sign_veryfy($decrypt_post_param, $_POST['sign'], false);
             
            //写日志记录
            if ($isSign) {
                $isSignStr = 'true';
            } else {
                $isSignStr = 'false';
            }
            $log_text = "response_text=" . $response_text . "\n notify_url_log:isSign=" . $isSignStr . ",";
            $log_text = $log_text . alipay_core::create_linkString($_POST);
            RC_Logger::getLogger('pay')->info($log_text);
             
            //验证
            //$responsetTxt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if (preg_match("/true$/i", $response_text) && $isSign) {
                return true;
            } else {
                return false;
            }
        }
    }
    
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    public function verify_return() {
        //判断GET来的数组是否为空
        if (empty($_GET)) {
            return false;
        }
        else {
            //生成签名结果
            $isSign = $this->get_sign_veryfy($_GET, $_GET['sign'], true);
            	
            //写日志记录
            if ($isSign) {
            	$isSignStr = 'true';
            } else {
            	$isSignStr = 'false';
            }
            $log_text = "return_url_log:isSign=" . $isSignStr . ",";
            $log_text = $log_text . alipay_core::create_linkString($_GET);
            RC_Logger::getLogger('pay')->info($log_text);
                	
            //验证
            //$responset_text的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
            //isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
            if ($isSign) {
                return true;
            } else {
                return false;
            }
        }
    }

}

// end