<?php
  

class alipay_request_wap extends alipay_request {
    protected $alipay_gateway_new = 'http://wappaygw.alipay.com/service/rest.htm?';
    
    public function __construct($alipay_config) {
        parent::__construct($alipay_config);
    }
    
    /**
     * 解析远程模拟提交后返回的信息
     * @param $str_text 要解析的字符串
     * @return 解析结果
     */
    function parse_response($str_text) {
        //以“&”字符切割字符串
        $param_split = explode('&', $str_text);
        //把切割后的字符串数组变成变量与数值组合的数组
        foreach ($param_split as $item) {
            //获得第一个=字符的位置
            $nPos = strpos($item, '=');
            //获得字符串长度
            $nLen = strlen($item);
            //获得变量名
            $key = substr($item, 0, $nPos);
            //获得数值
            $value = substr($item, $nPos+1, $nLen-$nPos-1);
            //放入数组中
            $param_text[$key] = $value;
        }

        if (!empty($param_text['res_data'])) {
            //解析加密部分字符串
            if ($this->alipay_config['sign_type'] == '0001') {
                $param_text['res_data'] = $this->sign_rsa->decrypt($param_text['res_data'], $this->alipay_config['private_key']);
            }
             
            //token从res_data中解析出来（也就是说res_data中已经包含token的内容）
            $doc = new DOMDocument();
            $doc->loadXML($param_text['res_data']);
            $param_text['request_token'] = $doc->getElementsByTagName('request_token')->item(0)->nodeValue;
        }
    
        return $param_text;
    }
}

// end