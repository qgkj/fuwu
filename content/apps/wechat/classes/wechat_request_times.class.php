<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class wechat_request_times {
    
    protected $wechat_id;
    
    public function __construct($wechat_id) {
        $this->wechat_id = $wechat_id;
    }
    
    public function record($api_name) {
        $db = RC_Loader::load_app_model('wechat_request_times_model', 'wechat');
        $day = RC_Time::local_date('Y-m-d', RC_Time::gmtime());
        $row = $db->where(array('wechat_id' => $this->wechat_id, 'day' => $day, 'api_name' => $api_name))->find();
        if (empty($row)) {
            $data = array(
                'wechat_id'     => $this->wechat_id,
                'day'           => $day,
                'api_name'      => $api_name,
                'times'         => 1,
                'last_time'     => RC_Time::gmtime(),
            );
            $db->insert($data);
        } else {
            $data = array(
                'times'         => $row['times'] + 1,
                'last_time'     => RC_Time::gmtime(),
            );
            $db->where(array('wechat_id' => $this->wechat_id, 'day' => $day, 'api_name' => $api_name))->update($data);
        }
    }
    
}

// end