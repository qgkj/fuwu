<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员帐号资金变动日志记录接口
 * @author royalwang
 */
class user_account_change_log_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['user_id'])) {
            return new ecjia_error('invalid_parameter', RC_Lang::get('users.users.invalid_parameter'));
        }
        
        $user_id 		= $options['user_id'];
        $user_money 	= isset($options['user_money']) 	? $options['user_money'] 	: 0;
        $frozen_money 	= isset($options['frozen_money']) 	? $options['frozen_money'] 	: 0;
        $rank_points 	= isset($options['rank_points']) 	? $options['rank_points'] 	: 0;
        $pay_points 	= isset($options['pay_points']) 	? $options['pay_points'] 	: 0;
        $change_desc 	= isset($options['change_desc']) 	? $options['change_desc'] 	: '';
        $change_type 	= isset($options['change_type']) 	? $options['change_type'] 	: ACT_OTHER;
        
        return $this->log_account_change($user_id, $user_money, $frozen_money, $rank_points, $pay_points, $change_desc, $change_type);
    }
    
    
    /**
     * 记录帐户变动
     *
     * @param int $user_id
     *        	用户id
     * @param float $user_money
     *        	可用余额变动
     * @param float $frozen_money
     *        	冻结余额变动
     * @param int $rank_points
     *        	等级积分变动
     * @param int $pay_points
     *        	消费积分变动
     * @param string $change_desc
     *        	变动说明
     * @param int $change_type
     *        	变动类型：参见常量文件
     * @return void
     */
    private function log_account_change($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = ACT_OTHER) {

        /* 插入帐户变动记录 */
        $account_log = array (
            'user_id'		=> $user_id,
            'user_money'	=> $user_money,
            'frozen_money'	=> $frozen_money,
            'rank_points'	=> $rank_points,
            'pay_points'	=> $pay_points,
            'change_time'	=> RC_Time::gmtime(),
            'change_desc'	=> $change_desc,
            'change_type'	=> $change_type
        );
        RC_DB::table('account_log')->insert($account_log);
    
        /* 更新用户信息 */
        // 	TODO: 暂时先恢复之前的写法
    
        $step = $user_money.", frozen_money = frozen_money + ('$frozen_money')," .
        " rank_points = rank_points + ('$rank_points')," .
        " pay_points = pay_points + ('$pay_points')";
    
        RC_DB::table('users')->where('user_id', $user_id)->increment('user_money', $step);
    }
}

// end