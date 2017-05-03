<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送基本信息
 * @author will.chen
 */
class basicinfo_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
    	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		
        $express_order_db       = RC_Model::model('express/express_order_model');
        $where                  = array('store_id' => $_SESSION['store_id'], 'staff_id' => 0, 'status' => 0);
        $sum_express_grab       = $express_order_db->where($where)->count();
        $sum_express_wait_pick  = $express_order_db->where(array('store_id' => $_SESSION['store_id'], 'staff_id' => $_SESSION['staff_id'], 'status' => 1))->count();
        $sum_express_shipping   = $express_order_db->where(array('store_id' => $_SESSION['store_id'], 'staff_id' => $_SESSION['staff_id'], 'status' => 2))->count();
		
		return array(
			'sum_express_grab'		=> $sum_express_grab,
			'sum_express_wait_pick'	=> $sum_express_wait_pick,
			'sum_express_shipping'	=> $sum_express_shipping,
		);
	 }	
}

// end