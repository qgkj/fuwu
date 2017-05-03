<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class api_response {
    protected $sourceData = array();
    protected $responseData = array();
    
    public function __construct($data) {
        $this->sourceData = $data;
        
        if (is_ecjia_error($this->sourceData)) {
            $this->responseData = with(new api_error($this->sourceData->get_error_code(), $this->sourceData->get_error_message()))->getData();
        } else {
            $this->responseData = $this->makeSucceedStatus();
            
            if (isset($data['data'])) {
                $this->responseData['data'] = $data['data'];
            } else {
                $this->responseData['data'] = $data;
            }
            
            if (isset($data['pager'])) {
                $this->responseData['paginated'] = $data['pager'];
            }
            
            if (isset($data['privilege'])) {
            	$this->responseData['privilege'] = $data['privilege'];
            }
        }
    }
    
    public function responseData() {
        return $this->responseData;
    }
    
    public function send() {
        RC_Response::json($this->responseData)->send();
    }
    
    protected function makeSucceedStatus() {
        return array('data' => array(), 'status' => array('succeed' => 1));
    }
}

//end