<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 推荐奖励统计
 * @author will.chen
 */
class reward_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
		$this->authSession();
		if ($_SESSION['user_id'] <= 0 ) {
			return new ecjia_error(100, 'Invalid session');
		}
		$invite_count = RC_Model::model('affiliate/affiliate_users_model')->where(array('parent_id' => $_SESSION['user_id']))->count();
		
		$invite_bouns_reward = RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'bonus'))->count();
		$invite_integral_reward	= RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'integral'))->SUM('reward_value');
		$invite_balance_reward	= RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'balance'))->SUM('reward_value');
		
		$invite_reward['invite_total'] = array(
			'invite_count'				=> $invite_count,
			'invite_bouns_reward'		=> $invite_bouns_reward,
			'invite_integral_reward'	=> intval($invite_integral_reward),
			'invite_balance_reward'		=> empty($invite_balance_reward) ? '0.00' : number_format($invite_balance_reward, 2, '.', '')
		);
		/* 便利循环12个月的数据*/
		for ($i = 11; $i >= 0; $i--) {
			/*循环获取时间戳*/
			$time = RC_Time::local_strtotime("-".$i." month");
			$date = RC_Time::local_date('Y-m',$time);
			
			$invite_bouns_reward = RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'bonus', "FROM_UNIXTIME(add_time, '%Y-%m')" => $date))->count();
			$invite_integral_reward	= RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'integral', "FROM_UNIXTIME(add_time, '%Y-%m')" => $date))->SUM('reward_value');
			$invite_balance_reward	= RC_Model::model('affiliate/invite_reward_model')->where(array('invite_id' => $_SESSION['user_id'], 'reward_type' => 'balance', "FROM_UNIXTIME(add_time, '%Y-%m')" => $date))->SUM('reward_value');
			
			$invite_reward['invite_record'][] = array(
				'label_invite_data' => RC_Time::local_date('Y 年 m 月',$time),
				'invite_data'		=> $date,
				'invite_bouns_reward'		=> $invite_bouns_reward,
				'invite_integral_reward'	=> intval($invite_integral_reward),
				'invite_balance_reward'		=> empty($invite_balance_reward) ? '0.00' : number_format($invite_balance_reward, 2, '.', '')
			);
		}
		return $invite_reward;
	}
}

// end