<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推荐人验证的记录
 * @author will.chen
 */
class validate_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		$this->authSession();
		$mobile = $this->requestData('mobile');
		$invite_info['invite_code'] = '';
		if (empty($mobile)) {
			return $invite_info;
		}
		/* 推荐处理 */
	    $affiliate = unserialize(ecjia::config('affiliate'));
	    
	    if (isset($affiliate['on']) && $affiliate['on'] == 1) {
	    	$invite_id = RC_Model::model('affiliate/invitee_record_model')->where(array('invitee_phone' => $mobile, 'is_registered' => 0, 'expire_time' => array('gt' => RC_Time::gmtime())))->get_field('invite_id');
	    	if (!empty($invite_id) && $invite_id > 0) {
	    		$invite_code_data = array(
    				'object_type'	=> 'ecjia.affiliate',
    				'object_group'	=> 'user_invite_code',
    				'object_id'		=> $invite_id,
    				'meta_key'		=> 'invite_code',
	    		);
	    		$user_invite_code = RC_Model::model('term_meta_model')->where($invite_code_data)->get_field('meta_value');
	    		$invite_info['invite_code'] = $user_invite_code;
	    	}
	    }
		return $invite_info;
	}
}

// end