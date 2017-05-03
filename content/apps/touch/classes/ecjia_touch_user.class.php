<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_touch_user extends RC_Object {
    
    const API_USER_COOKIE = 'ecjia_api_token';
    
    /**
     * 登录
     */
    public function signin($username, $password) {
        $data = array(
        	'name' => $username,
            'password' => $password,
        );
        $api = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNIN)->data($data);
        $res = $api->run();
        if ( ! $res) {
            return $api->getError();
        }
        
        $this->setUserinfo($res);
        
        return array_get($res, 'user');
    }
    public function setUserinfo($res) {
        $sid = array_get($res, 'session.sid');
        
        $response = royalcms('response');
        $response->withCookie(RC_Cookie::forever(self::API_USER_COOKIE, $sid));
        
        $this->cacheUserinfo($sid, array_get($res, 'user'));
    }
    
    protected function cacheUserinfo($cookieid, $user) {
        $cache_key = 'api_request_user_info::' . $cookieid;
        
        RC_Cache::app_cache_set($cache_key, $user, 'touch', 60*24*7);
    }
    
    protected function getCacheUserinfo() {
        $cache_key = 'api_request_user_info::' . RC_Cookie::get(self::API_USER_COOKIE);
        
        $data = RC_Cache::app_cache_get($cache_key, 'touch');
        
        return $data ?: array();
    }
    
    protected function removeCacheUserinfo() {
        $cache_key = 'api_request_user_info::' . RC_Cookie::get(self::API_USER_COOKIE);
        
        RC_Cache::app_cache_delete($cache_key, 'touch');
    }
    
    /**
     * 检查是否登录
     */
    public function isSignin() {
        $user = $this->getCacheUserinfo();
        if (array_get($user, 'id') > 0 && array_get($user, 'name')) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 退出
     */
    public function signout() {
        $data = array(
            'token' => $this->getToken(),
        );
        $api = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNIN)->data($data);
        $res = $api->run();
        
        $this->removeCacheUserinfo();
    }
    
    /**
     * 获取用户登录凭证
     */
    public function getToken() {
        return RC_Cookie::get(self::API_USER_COOKIE);
    }
    
    public function getUserinfo() {
        return $this->getCacheUserinfo();
    }
}

// end