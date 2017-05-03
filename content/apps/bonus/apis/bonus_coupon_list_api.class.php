<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取优惠红包
 * @author will.chen
 */
class bonus_coupon_list_api extends Component_Event_Api {
    
    public function call(&$options) {
    	if (!is_array($options) || empty($options['location'])) {
    		return new ecjia_error('invalid_parameter', RC_Lang::get('bonus::bonus.invalid_parameter'));
    	}
        return $this->coupon_list($options);
    }
    
    /**
	 * 取取优惠红包
	 * @param   array	 $options（包含经纬度，当前页码，每页显示页数，红包类型）
	 * @return  array   优惠红包数组
	 */
	private function coupon_list($options) {
		$res = RC_Model::Model('bonus/bonus_type_viewmodel')->seller_coupon_list($options);
		return $res;		
	}
}

// end