<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台权限API
 * @author royalwang
 */
class goods_admin_purview_api extends Component_Event_Api {
    public function call(&$options) {
        $purviews = array(
            array('action_name' => RC_Lang::get('goods::goods.goods_manage'), 'action_code' => 'goods_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.goods_update'), 'action_code' => 'goods_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.goods_delete'),'action_code' => 'goods_delete', 'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('goods::goods.category_manage'), 'action_code' => 'category_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.category_update'), 'action_code' => 'category_update', 'relevance' => ''),
            array('action_name' => RC_Lang::get('goods::goods.category_move'), 'action_code' => 'category_move', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.category_delete'), 'action_code' => 'category_delete', 'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('goods::goods.attr_manage'), 'action_code' => 'attr_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.attr_update'), 'action_code' => 'attr_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.attr_delete'), 'action_code' => 'attr_delete', 'relevance' => ''),
        		
        	array('action_name' => RC_Lang::get('goods::goods.brand_manage'), 'action_code' => 'brand_manage', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.brand_update'), 'action_code' => 'brand_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.brand_delete'), 'action_code' => 'brand_delete', 'relevance' => ''),
        		
            array('action_name' => RC_Lang::get('goods::goods.goods_type'), 'action_code' => 'goods_type', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.goods_type_update'), 'action_code' => 'goods_type_update', 'relevance' => ''),
        	array('action_name' => RC_Lang::get('goods::goods.goods_type_delete'), 'action_code' => 'goods_type_delete', 'relevance' => ''),
        );
        return $purviews;
    }
}

// end