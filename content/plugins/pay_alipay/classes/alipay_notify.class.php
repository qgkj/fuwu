<?php
  
/**
 * 类名：alipay_notify
 * 功能：支付宝通知处理类
 * 详细：处理支付宝各接口通知返回
 */
abstract class alipay_notify {
    /**
     * HTTPS形式消息验证地址
     */
    protected $https_verify_url = 'https://mapi.alipay.com/gateway.do?service=notify_verify&';
    /**
     * HTTP形式消息验证地址
     */
    protected $http_verify_url = 'http://notify.alipay.com/trade/notify_query.do?';
    protected $alipay_config = array();
    
    protected $sign_md5;
    protected $sign_rsa;
    
    public function __construct($alipay_config) {
        $this->alipay_config = array_merge($this->alipay_config, $alipay_config);
        $this->sign_md5 = new alipay_sign_md5();
        $this->sign_rsa = new alipay_sign_rsa();
    }

    /**
     * 针对notify_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    abstract public function verify_notify();
    
    /**
     * 针对return_url验证消息是否是支付宝发出的合法消息
     * @return 验证结果
     */
    abstract public function verify_return();

    
    /**
     * 获取返回时notify_data数据
     * @param $notify_data  xml string
     * @return array
     */
    public function get_notify_data($notify_data) {
        $sign_type = strtoupper(trim($this->alipay_config['sign_type']));
        //解密（如果是RSA签名需要解密）
        if ($sign_type == 'RSA' || $sign_type == '0001') {
            $notify_data = $this->decrypt($notify_data);
        }

        $arr = RC_Xml::to_array($notify_data);
        foreach ($arr as $key => $value) {
            $arr[$key] = $value[0];
        }        
        return $arr;
    }
    
    /**
     * 获取返回时的签名验证结果
     * @param $para_temp 通知返回来的参数数组
     * @param $sign 返回的签名结果
     * @param $isSort 是否对待签名数组排序
     * @return 签名验证结果
     */
    protected function get_sign_veryfy($param_temp, $sign, $isSort) {
        //除去待签名参数数组中的空值和签名参数
        $param = alipay_core::param_filter($param_temp);
        
        //对待签名参数数组排序
        if ($isSort) {
            $param = alipay_core::arg_sort($param);
        } else {
            $param = alipay_core::notify_param_sort($param);
        }

        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = alipay_core::create_linkstring($param);
    
        $isSgin = false;
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
        	case "MD5" :
        	    $isSgin = $this->sign_md5->verify($prestr, $sign, $this->alipay_config['alipay_key']);
        	    break;
        	case "RSA" :
        	    $isSgin = $this->sign_rsa->verify($prestr, $sign, trim($this->alipay_config['alipay_publickey']));
        	    break;
        	case "0001" :
        	    $isSgin = $this->sign_rsa->verify($prestr, $sign, trim($this->alipay_config['alipay_publickey']));
        	    break;
        	default :
        	    $isSgin = false;
        }
    
        return $isSgin;
    }
    
    /**
     * 获取远程服务器ATN结果,验证返回URL
     * @param $notify_id 通知校验ID
     * @return 服务器ATN结果
     * 验证结果集：
     * invalid命令参数不对 出现这个错误，请检测返回处理中partner和key是否为空
     * true 返回正确信息
     * false 请检查防火墙或者是服务器阻止端口问题以及验证时间是否超过一分钟
     */
    protected function get_response($notify_id) {
        $transport = strtolower(trim($this->alipay_config['transport']));
        $partner = trim($this->alipay_config['alipay_partner']);
        $veryfy_url = '';
        if ($transport == 'https') {
            $veryfy_url = $this->https_verify_url;
        } else {
            $veryfy_url = $this->http_verify_url;
        }
        $veryfy_url = $veryfy_url . 'partner=' . $partner . '&notify_id=' . $notify_id;
        $responseTxt = alipay_core::getHttpResponseGET($veryfy_url, $this->alipay_config['cacert']);
    
        return $responseTxt;
    }
    
    
    /**
     * 解密
     * @param $input_para 要解密数据
     * @return 解密后结果
     */
    protected function decrypt($prestr) {
        return $this->sign_rsa->decrypt($prestr, trim($this->alipay_config['private_key']));
    }

}

// end