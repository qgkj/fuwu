<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class shipping_admin_purview_api extends Component_Event_Api {
    
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('shipping::shipping.shipping_manage'), 	'action_code' => 'ship_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('shipping::shipping.edit_shipping'), 	'action_code' => 'ship_update', 'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('shipping::shipping_area.shiparea_manage'), 'action_code' => 'shiparea_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('shipping::shipping_area.new_area'), 		'action_code' => 'shiparea_add', 	'relevance' => ''),
        	array('action_name' => RC_Lang::get('shipping::shipping_area.edit_area'), 		'action_code' => 'shiparea_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('shipping::shipping_area.shiparea_delete'), 'action_code' => 'shiparea_delete', 'relevance' => ''),
        		
        	//配送列表
        	array('action_name' => RC_Lang::get('shipping::shipping.express_order_list'), 'action_code' => 'admin_express_order_manage', 'relevance' => ''),
        );
        
        return $purviews;
    }
}

// end