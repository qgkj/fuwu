<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 发放红包功能
 * @author will.chen
 */
class bonus_send_bonus_api extends Component_Event_Api {
	
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call(&$options) {
		if (!is_array($options) || !isset($options['type'])) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('bonus::bonus.invalid_parameter'));
		}
		
		return $this->send_coupon($options);
	}
	
	/* 发放优惠券*/
	private function send_coupon($options) {
		$db_user_bonus = RC_DB::table('user_bonus');
		$result = $db_user_bonus->where('bonus_type_id', '=', $options['bonus_type_id'])->where('user_id', '=', $_SESSION['user_id'])->first();
		if (empty($result)) {
			$data = array(
				'bonus_type_id' => $options['bonus_type_id'],
				'user_id'	   	=> $_SESSION['user_id'],
			);
			$db_user_bonus->insertGetId($data);
			return true;
		} 
	}
}

// end