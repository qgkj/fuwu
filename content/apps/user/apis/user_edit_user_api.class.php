<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员帐号信息编辑包括修改密码
 * @author royalwang
 */
class user_edit_user_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['new_password']) || !isset($options['user_id'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        RC_Loader::load_app_class('integrate', 'user', false);
        $user = integrate::init_users();
        $user_info = $user->get_profile_by_id($options['user_id']);
        $result = $user->edit_user(array('password' => $options['new_password'],'username'=>$user_info['user_name']),1);
        if ($result) {
            return true;
        } else {
            return new ecjia_error('edit_user_failed', '设置密码失败');
        }
    }
}

// end