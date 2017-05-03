<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 删除连接用户信息
 * @author royalwang
 */
class connect_connect_user_remove_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['user_id']) || empty($options['user_id'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        RC_Model::model('connect/connect_user_model')->in(array('user_id' => $options['user_id']))->where(array('is_admin' => $options['is_admin']))->delete();
        
        return true;
    }
}

// end