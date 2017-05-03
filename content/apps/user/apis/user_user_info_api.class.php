<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员信息
 * @author will.chen
 */
class user_user_info_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['user_id'])) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        return $this->user_info($options['user_id']);
    }
    
    /**
     * 取得用户信息
     * @param   int	 $user_id	用户id
     * @return  array   用户信息
     */
    private function user_info($user_id) {
    	$user = RC_Model::model('user/users_model')->find(array('user_id' => $user_id));
    
    	unset($user['question']);
    	unset($user['answer']);
    
    	/* 格式化帐户余额 */
    	if ($user) {
    		$user['formated_user_money']	= price_format($user['user_money'], false);
    		$user['formated_frozen_money']	= price_format($user['frozen_money'], false);
    	}
    	return $user;
    }
}

// end