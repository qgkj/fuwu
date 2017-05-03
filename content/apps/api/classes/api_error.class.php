<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * API错误返回类
 * @package ecjia-api
 * @since 1.5
 */
class api_error {
    private $code;
    private $message;

    public function __construct($code, $message) {
        $this->code = $code;
        $this->message = htmlspecialchars($message);
    }
    
    public function getData() {
        $data = array(
            'status' => array(
                'succeed' => 0,
                'error_code' => $this->code,
                'error_desc' => $this->message,
            )
        );
        return $data;
    }

    public function getJson() {
        $data = $this->getData();
        
        return json_encode($data);
    }
    
    public function getCode() {
        return $this->code;
    }
    
    public function getMessage() {
        return $this->message;
    }
}

// end