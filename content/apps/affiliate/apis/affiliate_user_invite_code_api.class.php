<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取用户推荐码
 * @author will.chen
 */
class affiliate_user_invite_code_api extends Component_Event_Api {
	
    /**
     * @param  $options['invite_code'] 受邀码
     * @return array
     */
	public function call(&$options) {	
	    if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
	    }

	    $invite_code_data = array(
    		'object_type'	=> 'ecjia.affiliate',
    		'object_group'	=> 'user_invite_code',
    		'object_id'		=> $_SESSION['user_id'],
    		'meta_key'		=> 'invite_code',
	    );
	    $user_invite_code = RC_Model::model('term_meta_model')->where($invite_code_data)->get_field('meta_value');
	    /* 生成邀请码*/
	    if (empty($user_invite_code)) {
	    	$charset = 'ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
	    	$charset_len = strlen($charset)-1;
	    	while (true) {
	    		$code = '';
	    		for ($i = 0; $i < 6; $i++) {
	    			$code .= $charset[rand(1, $charset_len)];
	    		}
	    		$code_exists = array(
    				'object_type'	=> 'ecjia.affiliate',
    				'object_group'	=> 'user_invite_code',
    				'meta_key'		=> 'invite_code',
    				'meta_value'	=> $code,
	    		);
	    		/* 判断邀请码是否已存在*/
	    		$invite_result = RC_Model::model('term_meta_model')->find($code_exists);
	    		if (empty($invite_result)) {
	    			$invite_code_data['meta_value'] = $code;
	    			RC_Model::model('term_meta_model')->insert($invite_code_data);
	    			$user_invite_code = $code;
	    			break;
	    		}
	    	}
	    }
	    
	    return $user_invite_code;
	}
}

// end