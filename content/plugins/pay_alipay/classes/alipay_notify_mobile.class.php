<?php
  

class alipay_notify_mobile extends alipay_notify {
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
        
        $this->alipay_config['alipay_publickey'] = file_get_contents(PAY_ALIPAY_PATH . 'key' . DS . 'alipay_publickey.pem');
        $this->alipay_config['cacert'] = file_get_contents(PAY_ALIPAY_PATH . 'key' . DS . 'cacert.pem');
    }

    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    public function verify_notify() {
        if(empty($_POST)) {//判断POST来的数组是否为空
            return false;
        } else {
            //生成签名结果
            $isSign = $this->get_sign_veryfy($_POST, $_POST["sign"], true);
            //获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
            $responseTxt = 'true';
            if (!empty($_POST["notify_id"])) {
                $response_text = $this->get_response($_POST["notify_id"]);
            }
            	
            //写日志记录
            if ($isSign) {
                $isSignStr = 'true';
            }
            else {
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
    public function verify_return(){
        return true;
    }
   
}

// end