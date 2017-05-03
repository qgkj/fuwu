<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 微信用户类
 * @author royalwang
 *
 */
class wechat_user {
    
    protected $wechat_id;
    protected $openid;

    protected $user;
    protected $wechat_user_db;
    
    public function __construct($wechat_id, $openid) {
        $this->wechat_id    = $wechat_id;
        $this->open_id      = $openid;
        
        $this->wechat_user_db = RC_Loader::load_app_model('wechat_user_model', 'wechat');
        
        $this->user  = $this->getWechatUser();
    }
    
    public function getWechatUser() {
        $user = $this->wechat_user_db->where(array('wechat_id' => $this->wechat_id, 'openid' => $this->open_id))->find();
        return $user;
    }
    
    public function getUnionid() {
        return $this->user['unionid'];
    }
    
    
    public function getNickname() {
        return $this->user['nickname'];
    }
    
    public function sex() {
    	return $this->user['sex'];
    }
    
    /**
     * 获取ecajia用户id
     */
    public function getUserId() {
        return $this->user['ect_uid'];
    }
    
    /**
     * 设置与微信关联的ecjia用户id
     * @param integer $userid
     */
    public function setUserId($userid) {
        return $this->wechat_user_db->where(array('wechat_id' => $this->wechat_id, 'openid' => $this->open_id))->update(array('ect_uid' => $userid));
    }
    
    /**
     * 生成用户名
     * @return string
     */
    public static function generate_username() {
        /* 不是用户注册，则创建随机用户名*/
        return 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
    }
    
    /**
     * 生成用户名
     * @return string
     */
    public static function generate_password() {
        /* 不是用户注册，则创建随机用户名*/
        return md5(rc_random(13, 'abcdefghijklmnopqrstuvwxyz0123456789'));
    }
    
    /**
     * 生成邮箱
     * @return string
     */
    public static function generate_email() {
        /* 不是用户注册，则创建随机用户名*/
        $string = 'a' . rc_random(10, 'abcdefghijklmnopqrstuvwxyz0123456789');
        $email = $string.'@163.com';
        return $email;
    }
    
}

// end