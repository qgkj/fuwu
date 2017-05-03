<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 消息应用
 */
class push_send {
    private $db;
    
    const CLIENT_ANDROID    = 'android';
    const CLIENT_IPHONE     = 'iphone';
    const CLIENT_IPAD       = 'ipad';
    
    protected $app_key;
    protected $app_secret;
    protected $client;
    protected $app_id;
    protected $custom_fields = array();
    
    public static function make($appid) {
        return new static($appid);
    }
    
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct($appid) {
        RC_Loader::load_app_class('push_notification', 'push', false);
        RC_Loader::load_app_class('mobile_manage', 'mobile', false);
        
        $app = mobile_manage::make($appid);
        
        $this->app_id       = $appid;
        $this->app_key      = $app->getAppKey();
        $this->app_secret   = $app->getAppSecret();
        $this->client       = $app->getClient();
        
        $this->db           = RC_Model::model('push/push_message_model');
    }
    
    /**
     * 设置客户端
     * @param string $client
     */
    public function set_client($client) {
        $this->client = $client;
//         if ($client == self::CLIENT_ANDROID) {
//             $this->app_key = ecjia::config('app_key_android');
//             $this->app_secret = ecjia::config('app_secret_android');
//         } elseif ($client == self::CLIENT_IPHONE) {
//             $this->app_key = ecjia::config('app_key_iphone');
//             $this->app_secret = ecjia::config('app_secret_iphone');
//         } elseif ($client == self::CLIENT_IPAD) {
//             $this->app_key = ecjia::config('app_key_ipad');
//             $this->app_secret = ecjia::config('app_secret_ipad');
//         }
        return $this;
    }
    
    public function set_field(array $field) {
        $this->custom_fields = $field;
        return $this;
    }
   
     /** 发送广播消息
      *
      * @access  public
      * @param   string  $msg            发送的消息内容
      * @param   string  $description    用于识别和查找信息使用
      * @param   integer $template       消息模板ID
      * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
      */
    public function broadcast_send($description, $msg, $template = 0, $priority = 1) {
        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($description, $msg);
        $notification->addField($this->custom_fields);
        if ($this->client == self::CLIENT_ANDROID) {
            $reponse = $notification->sendAndroidBroadcast();
        } else {
            $reponse = $notification->sendiOSBroadcast();
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }

        $reponse_data = json_decode($reponse, true);
        
        if ($this->custom_fields) {
            $extradata['extra_fields'] = $this->custom_fields;
        } else {
            $extradata = null;
        }
        
        //插入数据库记录
        //设备token、设备客户端，模板id，消息描述，消息内容，添加消息时间
        $data = array(
        	'device_token'      => 'broadcast',
        	'device_client'		=> $this->client,
            'app_id'            => $this->app_id,
            'template_id'       => $template,
            'title'             => $description,
            'content'           => $msg,
            'add_time'          => RC_Time::gmtime(),
            'extradata'         => serialize($extradata),
        );
        
        if ($priority) {
            $data['push_time'] = RC_Time::gmtime();
            $data['push_count'] = 1;
        }
        
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse_data['data']);
        }
        $this->db->insert($data);
        
        return $result;
    }
    
    
    /** 发送短消息
     *
     * @access  public
     * @param   string  $device_token   要发送到设备token，必须是由客户端采集上来的正确token
     * @param   string  $msg            发送的消息内容
     * @param   string  $description    用于识别和查找信息使用
     * @param   integer $template       消息模板ID
     * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
     */
    public function send($device_token, $description, $msg, $template, $priority = 1) {
        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($description, $msg);
        $notification->addDeviceToken($device_token);
        $notification->addField($this->custom_fields);
        if ($this->client == self::CLIENT_ANDROID) {
            $reponse = $notification->sendAndroidUnicast();
        } else {
            $reponse = $notification->sendiOSUnicast();
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }
    
        $reponse_data = json_decode($reponse, true);
    
        if ($this->custom_fields) {
            $extradata['extra_fields'] = $this->custom_fields;
        } else {
            $extradata = null;
        }
        
        //插入数据库记录
        //设备token、设备客户端，模板id，消息描述，消息内容，添加消息时间
        $data = array(
            'device_token'      => $device_token,
        	'device_client'		=> $this->client,
            'app_id'            => $this->app_id,
            'template_id'       => $template,
            'title'             => $description,
            'content'           => $msg,
            'add_time'          => RC_Time::gmtime(),
            'extradata'         => serialize($extradata),
        );
    
        if ($priority) {
            $data['push_time'] = RC_Time::gmtime();
            $data['push_count'] = 1;
        }
    
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse_data['data']);
        }
        $this->db->insert($data);
    
        return $result;
    }
    
    /**
     * 当短信发送失败时，可重新发送此条短信
     */
    public function resend($message_id) {
        $row = $this->db->find(array('message_id' => $message_id));
        if (empty($row)) {
            return new ecjia_error('not_found_message_id', __('没发找到此消息记录'));
        }
        if ($this->app_id != $row['app_id']) {
            return new ecjia_error('not_found_app_id', __('没发找到此消息记录'));
        }
        if ($row['extradata']) {
            $extradata = unserialize($row['extradata']);
        }

        $notification = new push_notification($this->app_key, $this->app_secret);
        $notification->addContent($row['title'], $row['content']);
        if ($extradata['extra_fields']) {
            $notification->addField($extradata['extra_fields']);
        }
        
        if ($this->client == self::CLIENT_ANDROID) {
            if ($row['device_token'] == 'broadcast') {
                $reponse = $notification->sendAndroidBroadcast();
            } else {
                $notification->addDeviceToken($row['device_token']);
                $reponse = $notification->sendAndroidUnicast();
            }
        } else {
            if ($row['device_token'] == 'broadcast') {
                $reponse = $notification->sendiOSBroadcast();
            } else {
                $notification->addDeviceToken($row['device_token']);
                $reponse = $notification->sendiOSUnicast();
            }
        }
        
        if (is_ecjia_error($reponse)) {
            return $reponse;
        }
        
        $reponse_data = json_decode($reponse, true);
        
        $data = array(
            'push_count'    => $row['push_count'] + 1,
            'push_time'     => RC_Time::gmtime(),
        );
        
        if ($reponse_data['ret'] == 'SUCCESS') {
            $data['in_status'] = 1;
            $result = true;
        } else {
            $data['in_status'] = 0;
            $result = new ecjia_error('push_send_error', $reponse['data']);
        }
        
        $this->db->where(array('message_id' => $message_id))->update($data);
        
        return $result;
    }
    
    /**
     * 批量重新发送，需要传数组
     * @param array $smsids
     */
    public function batch_resend($message_ids) {
        if (!is_array($message_ids)) {
            return new ecjia_error('invalid_argument', __('无效参数'));
        }
        
        $result = array();
        foreach ($message_ids as $key => $message_id) {
            $result[$key] = $this->resend($message_id);
        }
        
        return $result;
    }
}

// end