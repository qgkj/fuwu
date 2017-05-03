<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 发放推荐注册绑定
 * @author will.chen
 */
class affiliate_invite_reward_api extends Component_Event_Api {
	
    /**
     * @param  $options['invite_code'] 受邀码
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || !isset($options['invite_type'])
	    	|| !isset($options['user_id'])
	    	) {
	        return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
	    }

	    $user_info = RC_Model::model('affiliate/affiliate_users_model')->field('user_name, parent_id')->where(array('user_id' => $options['user_id']))->find();
	    $invite_id = $user_info['parent_id'];
	    $invitee_name = $user_info['user_name'];
	    /* 推荐处理 */
	    $affiliate = unserialize(ecjia::config('affiliate'));
	    if (isset($affiliate['on']) && $affiliate['on'] == 1 && $invite_id > 0) {
	    	/* 是否允许奖励*/
	    	$is_reward = true;
	    	if ($options['invite_type'] == 'orderpay') {
	    		$reward_record = RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $invite_id, 'invitee_id' => $options['user_id']))->find();
	    		if (!empty($reward_record)) {
	    			$is_reward = false;
	    		}
	    	}
		    /* 邀请人奖励处理*/
		    if ($affiliate['intvie_reward']['intive_reward_by'] == $options['invite_type'] && $is_reward && $affiliate['intvie_reward']['intive_reward_value'] > 0) {
		    	if ($affiliate['intvie_reward']['intive_reward_type'] == 'bonus') {
		    		RC_Model::model('affiliate/affiliate_user_bonus_model')->insert(array('bonus_type_id' => $affiliate['intvie_reward']['intive_reward_value'], 'user_id' => $invite_id));
		    		$reward_type = 'bonus';
		    	} elseif ($affiliate['intvie_reward']['intive_reward_type'] == 'integral') {
		    		$option = array(
	    				'user_id'		=> $invite_id,
	    				'pay_points'	=> $affiliate['intvie_reward']['intive_reward_value'],
	    				'change_desc'	=> '邀请送积分'
		    		);
		    		$result = RC_Api::api('user', 'account_change_log', $option);
		    		$reward_type = 'integral';
		    	} elseif ($affiliate['intvie_reward']['intive_reward_type'] == 'balance') {
		    		$option = array(
	    				'user_id'		=> $invite_id,
	    				'user_money'	=> $affiliate['intvie_reward']['intive_reward_value'],
	    				'change_desc'	=> '邀请送余额'
		    		);
		    		$result = RC_Api::api('user', 'account_change_log', $option);
		    		$reward_type = 'balance';
		    	}
		    	 
		    	if ($affiliate['intvie_reward']['intive_reward_value'] > 0) {
		    		RC_Model::model('affiliate/invite_reward_model')->insert(array(
			    		'invite_id'		=> $invite_id,
			    		'invitee_id'	=> $options['user_id'],
			    		'invitee_name'	=> $invitee_name,
			    		'reward_type'	=> $reward_type,
			    		'reward_value'	=> $affiliate['intvie_reward']['intive_reward_value'],
			    		'add_time'		=> RC_Time::gmtime(),
		    		));
		    	}
		    }
		    
		    /* 是否允许奖励*/
		    $invitee_is_reward = true;
		    if ($options['invite_type'] == 'orderpay') {
		    	$order_count = RC_Model::model('orders/order_info_model')->where(array('user_id' => $options['user_id'], 'pay_status' => PS_PAYED))->count();
		    	if ($order_count > 1) {
		    		$invitee_is_reward = false;
		    	}
		    }
		    /* 受邀人奖励处理*/
		    if ($affiliate['intviee_reward']['intivee_reward_by'] == $options['invite_type'] && $invitee_is_reward && $affiliate['intviee_reward']['intivee_reward_value'] > 0) {
		    	if ($affiliate['intviee_reward']['intivee_reward_type'] == 'bonus') {
		    		RC_Model::model('affiliate/affiliate_user_bonus_model')->insert(array('bonus_type_id' => $affiliate['intviee_reward']['intivee_reward_value'], 'user_id' => $options['user_id']));
		    	} elseif ($affiliate['intviee_reward']['intivee_reward_type'] == 'integral') {
		    		$option = array(
	    				'user_id'		=> $options['user_id'],
	    				'pay_points'	=> $affiliate['intviee_reward']['intivee_reward_value'],
	    				'change_desc'	=> '邀请送积分'
		    		);
		    		$result = RC_Api::api('user', 'account_change_log', $option);
		    	} else {
		    		$option = array(
	    				'user_id'		=> $options['user_id'],
	    				'user_money'	=> $affiliate['intviee_reward']['intivee_reward_value'],
	    				'change_desc'	=> '邀请送余额'
		    		);
		    		$result = RC_Api::api('user', 'account_change_log', $option);
		    	}
		    }
	    }
	    return true;
	}
}

// end