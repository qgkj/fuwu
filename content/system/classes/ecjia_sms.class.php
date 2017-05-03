<?php
  
/**
 * ECJIA SMS
 */
defined('IN_ECJIA') or exit('No permission resources.');

/* 短信模块主类 */
class ecjia_sms {
    const HOST      = 'http://106.ihuyi.com/webservice/sms.php?';
    const SEND      = 'method=Submit';
    const BALANCE   = 'method=GetNum';
    const PASSWORD  = 'method=ChangePassword';
    
    private $_account;
    private $_password;
    private $_auth;
    private $_sender;
    private $_message;
    private $_type;
    private $_sms;
    
    protected $to = array();
    protected $response_code = array(
        '2000'  => 'SUCCESS - Message Sent.',
        '-1000' => 'UNKNOWN ERROR - Unknown error. Please contact the administrator.',
        '-1001' => 'AUTHENTICATION FAILED - Your username or password are incorrect.',
        '-1002' => 'ACCOUNT SUSPENDED / EXPIRED - Your account has been expired or suspended. Please contact the administrator.',
        '-1003' => 'IP NOT ALLOWED - Your IP is not allowed to send SMS. Please contact the administrator.',
        '-1004' => 'INSUFFICIENT CREDITS - You have run our of credits. Please reload your credits.',
        '-1005' => 'INVALID SMS TYPE - Your SMS type is not supported.',
        '-1006' => 'INVALID BODY LENGTH (1-900) - Your SMS body has exceed the length. Max = 900',
        '-1007' => 'INVALID HEX BODY - Your Hex body format is wrong.',
        '-1008' => 'MISSING PARAMETER - One or more required parameters are missing.'
    );
    
    /**
     * Create SMS instance
     *
     * @return  void
     */
    public static function make()
    {
        return new static();
    }

    public function __construct($account = null, $password = null) 
    {
        /* 直接赋值 */
        $this->_account  = $account ? $account : ecjia::config('sms_user_name');
        $this->_password = $password ? $password : ecjia::config('sms_password');
        $this->_type = 1;
        $this->_sender = '';
        $this->_auth = $this->getAuthParams();
    }
    
    public function setNumber($number) {
        $this->addAnNumber($number);
        return $this;
    }
    
    public function getNumber()
    {
        return $this->_to;
    }
    
    /**
     * 添加信息
     * 如果内容有url需要过滤，可以使用rawurlencode方法
     * @param unknown $msg
     * @return string
     */
    public function setMessage($msg)
    {
        $this->_message = $msg;
        return $this;
    }
    
    public function getMessage()
    {
        return $this->_message;
    }
    
    public function viewSMSParams()
    {
        return $this->getSMSParams();
    }
    
    public function normalize($number)
    {
        return $this->normalizeNumber($number);
    }
    
    public function send()
    {
        $response = array();
        
        $result = $this->sendSMS( is_array($this->_to) ? $this->formatNumber($this->_to) : $this->_to );
        $info = $this->getInfo($result);
        
        $response['raw'] = $result;
        $response['code'] = $info->code;
        $response['description'] = $info->msg;
        return $response;
    }
    
    private function sendSMS($mobile) {
        $url = self::HOST . self::SEND;
        $params = $this->_auth;
        $params['content']  = $this->_message;
        $params['mobile']   = $mobile;
        return $this->curl( $url, $params );
    }
    
    public function balance()
    {
        $response = array();
        
        $url = self::HOST . self::BALANCE;
        $params = $this->_auth;
        $result = $this->curl( $url, $params );
        $info = $this->getInfo($result);
        
        $response['num'] = $info->num;
        $response['code'] = $info->code;
        $response['description'] = $info->msg;
        
        return $response;
    }
    
    private function addAnNumber($number)
    {
        if (is_array($number)) {
            foreach ($number as $num)
            {
                $this->_to[] = $num;
            }
        } else {
            $this->_to[] = $number;
        }
    
    }
    
    private function normalizeNumber($number, $countryCode = 86)
    {
        if (isset($number)) {
            $number = trim($number);
            $number = str_replace("+", "", $number);
            preg_match( '/(0|\+?\d{2})(\d{8,9})/', $number, $matches);
            if ((int) $matches[1] === 0 ) {
                $number = $countryCode . $matches[2];
            }
        }
        return $number;
    }
    
    private function formatNumber($number)
    {
        $format = "";
        if (is_array($number)) {
            $format = implode(";", $number);
        }
        return $format;
    }
    
    private function getInfo($result)
    {
        $result_arr = RC_Xml::to_array($result);
        
        $info = new stdClass();
        $info->code     =  $result_arr['code'][0];
        $info->msg      = $result_arr['msg'][0];
        
        if (isset($result_arr['smsid'])) {
            $info->smsid = $result_arr['smsid'][0];
        }
        
        if (isset($result_arr['num'])) {
            $info->num   = $result_arr['num'][0];
        }
         
        return $info;
    }
    
    private function getAuthParams()
    {
        $params['account']  = $this->_account;
        $params['password'] = $this->_password;
        return $params;
    }
    
    private function getSMSParams()
    {
        $params['mobile']   = $this->formatNumber($this->_to);
        $params['content']  = $this->_message;
        return $params;
    }
    
    private function getAnswer( $code )
    {
        if ( isset( $this->response_code[$code] ) ) {
            return $this->response_code[$code];
        }
    }
    
    private function curl( $url, $params = array() )
    {
        // Use SSL: http://www.php.net/manual/en/function.curl-setopt-array.php#89850
        $ch = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER  => TRUE,
            CURLOPT_URL             => $url,
            CURLOPT_HEADER          => false,
            CURLOPT_ENCODING        => "",
            CURLOPT_POST            => 1,
            CURLOPT_POSTFIELDS      => $params,
            CURLOPT_SSL_VERIFYHOST  => 0,
            CURLOPT_SSL_VERIFYPEER  => false,
        );
        curl_setopt_array( $ch, $options );
        $result = curl_exec( $ch );
        curl_close( $ch );
    
        return $result;
    }
    
}

// end