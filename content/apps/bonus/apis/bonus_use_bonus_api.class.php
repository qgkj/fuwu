<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 红包使用
 * @author will.chen
 */
class bonus_use_bonus_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['bonus_id']) || !isset($options['order_id'])) {
            return new ecjia_error('invalid_parameter', RC_Lang::get('bonus::bonus.invalid_parameter'));
        }
        return $this->use_bonus($options['bonus_id'], $options['order_id']);
    }
    
    /**
	* 设置红包为已使用
	* @param   int	 $bonus_id   红包id
	* @param   int	 $order_id   订单id
	* @return  bool
	*/
	private function use_bonus($bonus_id, $order_id) {
		$db = RC_DB::table('user_bonus');
		$data = array(
			'order_id'	=> $order_id,
			'used_time' => RC_Time::gmtime()
		);
		return $db->where('bonus_id', $bonus_id)->update($data);
	}
}

// end