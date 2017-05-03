<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 红包信息
 * @author will.chen
 */
class bonus_bonus_info_api extends Component_Event_Api {
    
    public function call(&$options) {
        if (!is_array($options) || !isset($options['bonus_id'])) {
            return new ecjia_error('invalid_parameter', RC_Lang::get('bonus::bonus.invalid_parameter'));
        }
        $options['bonus_sn'] = isset($options['bonus_sn']) ? $options['bonus_sn'] : '';
        return $this->bonus_info($options['bonus_id'], $options['bonus_sn'], $options['store_id']);
    }
    
    /**
	* 取得红包信息
	* @param   int	 $bonus_id   红包id
	* @param   string  $bonus_sn   红包序列号
	* @param   array   红包信息
	*/
	private function bonus_info($bonus_id, $bonus_sn = '', $store_id = null) {
		$dbview = RC_DB::table('user_bonus as ub')->leftJoin('bonus_type as bt', RC_DB::raw('ub.bonus_type_id'), '=', RC_DB::raw('bt.type_id'));
		
		if ($store_id !== null) {
			$dbview->where(RC_DB::raw('bt.bonus_id'), $store_id);
		}
		
		if ($bonus_id > 0) {
			return $dbview->where(RC_DB::raw('ub.bonus_id'), '=', $bonus_id)->first();
		} else {
			return $dbview->where(RC_DB::raw('ub.bonus_sn'), '=', $bonus_sn)->first(); 
		}
	}
}

// end