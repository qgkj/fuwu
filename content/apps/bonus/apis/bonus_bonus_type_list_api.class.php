<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取红包类型列表
 * @author will.chen
 */
class bonus_bonus_type_list_api extends Component_Event_Api {
	
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call(&$options) {
// 		if (!is_array($options) || !isset($options['type'])) {
// 			return new ecjia_error('invalid_parameter', RC_Lang::get('bonus::bonus.invalid_parameter'));
// 		}
		return $this->bonus_type_list($options);
	}
	
	/* 注册送红包*/
	private function bonus_type_list($options) {
		$db_bonus_type = RC_Loader::load_app_model('bonus_type_model', 'bonus');
		
		
		$where = array();
		/* 在发放时间范围内*/
		if ($options['type'] == 'allow_send') {
			$time	= RC_Time::gmtime();
			$where['send_start_date']	= array('elt' => $time);
			$where['send_end_date']	= array('egt' => $time);
		}
		$limit = null;
		if (isset($options['limit'])) {
			
		}
		return RC_Model::model('bonus/bonus_type_model')->where($where)->limit($limit)->select();
	}
}

// end