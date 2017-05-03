<?php
  
/**
 * ecjia cloud 业务处理类
 * @author royalwang
 *
 */
class ecjia_cloud {
    
    /**
     * 服务器地址
     * @var serverHost
     */
    const serverHost = 'https://cloud.ecjia.com/sites/api/?url=';
    
    private static $instance = null;
    
    /**
     * 需要发送的数据
     * @var $data
     */
    private $data   = array();
    /**
     * 接口
     * @var $api
     */
    private $api;
    /**
     * 错误信息
     * @var $error
     */
    private $errors;
    
    private $cache_time;
    
    private $status = false;
    
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return object
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * constructor
     */
    public function __construct()
    {
        $this->errors = new ecjia_error();
    }
    
    
    /**
     * 设置需要发送的数据
     * @param array $data
     * @return ecjia_cloud
     */
    public function data($data) {
        $this->data = $data;
        return $this;
    }
    
    
    /**
     * 设置API接口
     * @param string $api 例如 xx/xxx
     * @return ecjia_cloud
     */
    public function api($api) {
        $this->api = $api;
        return $this;
    }
    
    /**
     * 设置缓存的时间
     * @param unknown $time
     */
    public function cacheTime($time) {
        $this->cache_time = $time;
        return $this;
    }
    
    
    /**
     * 请求
     * @return boolean|Ambigous <multitype:, boolean, mixed>
     */
    public function run() {        
        $cache_key = 'api_request_'.md5($this->api);
        $data = RC_Cache::app_cache_get($cache_key, 'system');

        if (!$this->cache_time || 'error' == $data['status'] || SYS_TIME - $this->cache_time > $data['timestamp']) {
            $fields['body'] = array(
                'json' => json_encode($this->data),
            );
            $response = RC_Http::remote_post(self::serverHost . $this->api, $fields);
            if (RC_Error::is_error($response)) {
                $this->errors->add($response->get_error_code(), $response->get_error_message(), $response->get_error_data());
                return false;
            }
            $body = $this->returnResolve($response['body']);
            RC_Cache::app_cache_set($cache_key, array('body' => $body, 'status' => $this->status, 'timestamp' => SYS_TIME), 'system');
            
            return $body;
        } else {
            return $data['body'];
        }
    }
    
    /**
     * 获取错误对象
     * @return ecjia_error
     */
    public function getError() {
        return $this->errors;
    }
    
    /**
     * 获取请求状态
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * 解析服务器返回的数据
     * @param string $data
     * @return array
     */
    private function returnResolve($data) {
        if (empty($data)) {
            return array();
        }
        $data = json_decode($data, true);
        if (!is_array($data) || !isset($data['status'])) {
            $this->status = 'error';
            $this->errors->add('', __('服务器返回信息错误！'));
            return false;
        }
        if (!$data['status']['succeed']) {
            $this->status = 'error';
            $this->errors->add('', $data['error_desc']);
            return false;
        }
        $this->status = 'success';
        return $data['data'];
    }
    
}

// end