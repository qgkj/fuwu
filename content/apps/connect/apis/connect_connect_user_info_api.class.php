<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取连接用户信息
 * @author royalwang
 */
class connect_connect_user_info_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['user_id'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        $user_id = $options['user_id'];
        $user = RC_DB::table('connect_user')->where('user_id', $user_id)->orderBy('id', 'desc')->first();
        if ($user) {
            $user['profile'] = unserialize($user['profile']);
        }
        return $user;
    }
}

// end