<?php
  
/**
 * 支付宝签名接口
 * @author royalwang
 *
 */
interface alipay_sign_interface {
    /**
     * 签名字符串
     * @param $prestr 需要签名的字符串
     * @param $key 私钥
     * return 签名结果
     */
    public function sign($prestr, $key);
    
    /**
     * 验证签名
     * @param $prestr 需要签名的字符串
     * @param $sign 签名结果
     * @param $key 私钥
     * return 签名结果
     */
    public function verify($prestr, $sign, $key);
    
}


// end
