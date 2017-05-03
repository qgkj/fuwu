<?php
  
/**
 * 类名：alipay_request
 * 功能：支付宝各接口请求提交类
 * 详细：构造支付宝各接口表单HTML文本，获取远程HTTP数据
 */
abstract class alipay_request {
    var $alipay_config;
    /**
     *支付宝网关地址
     */
    protected $alipay_gateway_new;
    
    protected $sign_md5;
    protected $sign_rsa;
    
    public function __construct($alipay_config){
        $this->alipay_config = $alipay_config;
        
        $this->sign_md5 = new alipay_sign_md5();
        $this->sign_rsa = new alipay_sign_rsa();
    }
    
    /**
     * 生成签名结果
     * @param $para_sort 已排序要签名的数组
     * return 签名结果字符串
     */
    public function create_request_sign($param_sort) {
        //把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
        $prestr = alipay_core::create_linkstring($param_sort);
    
        $mysign = '';
        switch (strtoupper(trim($this->alipay_config['sign_type']))) {
        	case "MD5" :
        	    $mysign = $this->sign_md5->sign($prestr, $this->alipay_config['alipay_key']);
        	    break;
        	case "RSA" :
        	    $mysign = $this->sign_rsa->sign($prestr, $this->alipay_config['private_key']);
        	    break;
        	case "0001" :
        	    $mysign = $this->sign_rsa->sign($prestr, $this->alipay_config['private_key']);
        	    break;
        	default :
        	    $mysign = '';
        }
    
        return $mysign;
    }
    
    /**
     * 生成要请求给支付宝的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
    public function build_request_param($param_temp) {
        //除去待签名参数数组中的空值和签名参数
        $param_filter = alipay_core::param_filter($param_temp);
    
        //对待签名参数数组排序
        $param_sort = alipay_core::arg_sort($param_filter);
    
        //生成签名结果
        $mysign = $this->create_request_sign($param_sort);
    
        //签名结果与签名方式加入请求提交参数组中
        $param_sort['sign'] = $mysign;
        if ($param_sort['service'] != 'alipay.wap.trade.create.direct' && $param_sort['service'] != 'alipay.wap.auth.authAndExecute') {
            $param_sort['sign_type'] = strtoupper(trim($this->alipay_config['sign_type']));
        }
    
        return $param_sort;
    }
    
    /**
     * 生成要请求给支付宝的参数字符串
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param_toString($param_temp) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = alipay_core::create_linkstring_urlencode($param);
    
        return $request_data;
    }
    
    /**
     * 生成要请求给支付宝的参数带链接
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组字符串
     */
    public function build_request_param_toLink($param_temp) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        //把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
        $request_data = alipay_core::create_linkstring_urlencode($param);
    
        return $this->alipay_gateway_new . $request_data;
    }
    
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
    public function build_request_form($param_temp, $method, $button_name) {
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
    
        $sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='" . $this->alipay_gateway_new . "_input_charset=" . trim(strtolower($this->alipay_config['input_charset'])) . "' method='" . $method . "'>";
        while ((list($key, $val) = each($param)) != false) {
            $sHtml .= "<input type='hidden' name='" . $key . "' value='" . $val . "'/>";
        }
    
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml . "<input type='submit' value='" . $button_name . "'></form>";
    
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
    
        return $sHtml;
    }
    
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果
     * @param $para_temp 请求参数数组
     * @return 支付宝处理结果
     */
    public function build_request_http($param_temp) {
        $sResult = '';
        
        //待请求参数数组字符串
        $request_data = $this->build_request_param($param_temp);
//		TODO:获取不到，暂给空值
        $this->alipay_config['cacert'] = '';
        //远程获取数据
        $sResult = alipay_core::getHttpResponsePOST($this->alipay_gateway_new, $this->alipay_config['cacert'], $request_data);
    
        return $sResult;
    }
    
    /**
     * 建立请求，以模拟远程HTTP的POST请求方式构造并获取支付宝的处理结果，带文件上传功能
     * @param $para_temp 请求参数数组
     * @param $file_para_name 文件类型的参数名
     * @param $file_name 文件完整绝对路径
     * @return 支付宝返回处理结果
     */
    public function build_request_http_inFile($param_temp, $file_param_name, $file_name) {
    
        //待请求参数数组
        $param = $this->build_request_param($param_temp);
        $param[$file_param_name] = '@' . $file_name;
    
        //远程获取数据
        $sResult = alipay_core::getHttpResponsePOST($this->alipay_gateway_new . '_input_charset=' . trim(strtolower($this->alipay_config['input_charset'])), $this->alipay_config['cacert'], $param);
    
        return $sResult;
    }
    
    
    
    /**
     * 用于防钓鱼，调用接口query_timestamp来获取时间戳的处理函数
     * 注意：该功能PHP5环境及以上支持，因此必须服务器、本地电脑中装有支持DOMDocument、SSL的PHP配置环境。建议本地调试时使用PHP开发软件
     * return 时间戳字符串
     */
    public function query_timestamp() {
        $url = $this->alipay_gateway_new . 'service=query_timestamp&partner=' . trim(strtolower($this->alipay_config['alipay_partner'])) . '&_input_charset=' . trim(strtolower($this->alipay_config['input_charset']));
        $encrypt_key = '';
    
        $doc = new DOMDocument();
        $doc->load($url);
        $itemEncrypt_key = $doc->getElementsByTagName('encrypt_key');
        $encrypt_key = $itemEncrypt_key->item(0)->nodeValue;
    
        return $encrypt_key;
    }
}

// end