<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加会员帐号接口
 * @author royalwang
 */
class user_add_user_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['username']) || !isset($options['password']) || !isset($options['email'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        $username = $options['username'];
        
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
        $result = $user->add_user($username, $options['password'], $options['email']);
        if ($result) {
            $profile = $user->get_profile_by_name($username);
            return $profile;
        } else {
            return new ecjia_error('create_user_failed', '创建用户失败');
        }
    }
}

// end