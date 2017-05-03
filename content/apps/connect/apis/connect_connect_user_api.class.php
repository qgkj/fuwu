<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取连接用户信息
 * @author royalwang
 */
class connect_connect_user_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['connect_code']) || !isset($options['open_id'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        RC_Loader::load_app_class('connect_user', 'connect', false);
        
        $connect_code   = $options['connect_code'];
        $open_id        = $options['open_id'];
        $connect        = new connect_user($connect_code, $open_id);
        return $connect->get_openid();
    }
}

// end