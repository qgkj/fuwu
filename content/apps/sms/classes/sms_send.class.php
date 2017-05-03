<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 短信模块 之 模型（类库）
 */
class sms_send {
    private $db;
    
    public static function make() {
        return new static();
    }
    
    /**
     * 构造函数
     *
     * @access  public
     * @return  void
     */
    public function __construct() {
        $this->db = RC_Model::model('sms/sms_sendlist_model');
    }
   
     /** 发送短消息
      *
      * @access  public
      * @param   string  $mobile         要发送到手机号码，传的值是一个正常的手机号
      * @param   string  $msg            发送的消息内容
      * @param   integer $template       短信模板ID
      * @param   integer $priority       1 优先级高，立即发送， 0 优先级低的异步发送
      */
    public function send($mobile, $msg, $template, $priority = 1) {
        $reponse = ecjia_sms::make()->setMessage($msg)->setNumber($mobile)->send();
        
        //插入数据库记录
        //手机号码、短信模板ID，短信内容，是否出错（0，1），优先级高低（0，1），最后发送时间
        $data = array(
        	'mobile'        => $mobile,
            'template_id'   => $template,
            'sms_content'   => $msg,
            'pri'           => $priority,
            'error'         => 0,
            'last_send'     => RC_Time::gmtime(),
        );
        
        if ($reponse['code'] == 2) {
            $result = true;
        } else {
            $data['error']  = 1;
            $result         = new ecjia_error('sms_send_error', $reponse['description']);
        }
        $this->db->insert($data);
        
        return $result;
    }
    
    /**
     * 当短信发送失败时，可重新发送此条短信
     */
    public function resend($smsid) {
        $row = $this->db->find(array('id' => $smsid));
        if (empty($row)) {
            return new ecjia_error('not_found_smsid', RC_Lang::get('sms::sms.not_found_smsid'));
        }
        
        $reponse = ecjia_sms::make()->setMessage($row['sms_content'])->setNumber($row['mobile'])->send();
        
        $data = array(
            'error'         => 0,
            'last_send'     => RC_Time::gmtime(),
        );
        
        if ($reponse['code'] == 2) {
            $result = true;
        } else {
            $data['error'] = $row['error'] + 1;
            $result        = new ecjia_error('sms_send_error', $reponse['description']);
        }
        
        $this->db->where(array('id' => $smsid))->update($data);
        
        return $result;
    }
    
    /**
     * 批量重新发送，需要传数组
     * @param array $smsids
     */
    public function batch_resend($smsids) {
        if (!is_array($smsids)) {
            return new ecjia_error('invalid_argument', RC_Lang::get('sms::sms.invalid_argument'));
        }
        
        $result = array();
        foreach ($smsids as $key => $smsid) {
            $result[$key] = $this->resend($smsid);
        }
        
        return $result;
    }
    

    /**
     * 检测启用短信服务需要的信息
     *
     * @access  private
     * @param   string      $account        帐号
     * @param   string      $password       密码
     * @return  boolean                     如果启用信息格式合法就返回true，否则返回false。
     */
    public function check_enable_info($account, $password) {
        if (empty($account) || empty($password)) {
            return false;
        }

        return true;
    }

    /**
     * 查询账户余额
     */
    public function check_balance() {
        $account  = ecjia::config('sms_user_name');
        $password = ecjia::config('sms_password');
        if (!$this->check_enable_info($account, $password)) {
            return new ecjia_error('invalid_account', RC_Lang::get('sms::sms.invalid_account'));
        }

        $reponse = ecjia_sms::make()->balance();
        if ($reponse['code'] == 2) {
            return $reponse['num'];
        } else {
            return new ecjia_error('sms_send_error', $reponse['description']);
        } 
    }
    
}

// end