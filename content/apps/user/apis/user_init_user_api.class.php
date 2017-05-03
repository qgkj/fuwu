<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取会员初始化对象
 * @author royalwang
 */
class user_init_user_api extends Component_Event_Api {
    
    public function call(&$options) {
        RC_Loader::load_app_class('integrate', 'user', false);
        return integrate::init_users();
    }
}

// end