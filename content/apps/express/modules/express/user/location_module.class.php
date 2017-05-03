<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 时时更新配送员坐标
 * @author will.chen
 */
class location_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
		$location = $this->requestData('location', array());
		
		/*经纬度为空判断*/
		if (!is_array($location) || empty($location['longitude']) || empty($location['latitude'])) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
		}
		
		$express_model_db  = RC_Model::model('express/express_user_model');
		$express_user_info = $express_model_db->where(array('user_id' => $_SESSION['staff_id']))->find();
		if (empty($express_user_info)) {
			$express_model_db->insert(array('user_id' => $_SESSION['staff_id'], 'store_id' => $_SESSION['store_id'], 'longitude' => $location['longitude'], 'latitude' => $location['latitude'], 'delivery_count' => 0, 'delivery_distance' => 0));
		} else {
			$express_model_db->where(array('user_id' => $_SESSION['staff_id']))->update(array('longitude' => $location['longitude'], 'latitude' => $location['latitude']));
		}
		return array();
	 }	
}

// end