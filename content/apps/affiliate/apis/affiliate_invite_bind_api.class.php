<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推荐注册绑定
 * @author will.chen
 */
class affiliate_invite_bind_api extends Component_Event_Api {
	
    /**
     * @param  $options['invite_code'] 受邀码
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || (!isset($options['invite_code']))) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
	    }
	    /* 统一转为大写*/
	    $options['invite_code'] = strtoupper($options['invite_code']);
	    /* 推荐处理 */
	    $affiliate = unserialize(ecjia::config('affiliate'));
	    if (isset($affiliate['on']) && $affiliate['on'] == 1) {
	    	if (!empty($options['mobile'])) {
	    		$invite_info = RC_Model::model('affiliate/invitee_record_model')->where(array('invitee_phone' => $options['mobile'], 'expire_time' => array('gt' => RC_Time::gmtime())))->order(array('id' => 'asc'))->find();
	    		$invite_id = isset($invite_info['invite_id']) ? intval($invite_info['invite_id']) : 0;
	    	} 
	    	/* 如果手机推荐人不存在，关联邀请码推荐人*/
	    	if ($invite_id == 0 && !empty($options['invite_code'])) {
	    		$invite_code_data = array(
    				'object_type'	=> 'ecjia.affiliate',
    				'object_group'	=> 'user_invite_code',
    				'meta_key'		=> 'invite_code',
    				'meta_value'	=> $options['invite_code']
	    		);
	    		$invite_id = RC_Model::model('term_meta_model')->where($invite_code_data)->get_field('object_id');
	    	}
    		
    		$invite_id = $invite_id > 0 ? intval($invite_id) : 0;
    		
	    	RC_Model::model('affiliate/affiliate_users_model')->where(array('user_id' => $_SESSION['user_id']))->update(array('parent_id' => $invite_id));
	    	
	    	if (!empty($options['mobile'])) {
	    		RC_Model::model('affiliate/invitee_record_model')->where(array('invitee_phone' => $options['mobile']))->delete();
	    	}
	    	
	    	RC_Api::api('affiliate', 'invite_reward', array('user_id' => $_SESSION['user_id'], 'invite_type' => 'signup'));
	    }
	    return true;
	}
}

// end