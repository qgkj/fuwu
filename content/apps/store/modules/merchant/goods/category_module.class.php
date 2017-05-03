<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商铺商品分类
 * @author will.chen
 */
class category_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
		$seller_id = $this->requestData('seller_id');
		if (empty($seller_id)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
        $cat_list = RC_DB::table('merchants_category')->selectRaw('cat_id, cat_name, parent_id')
        												->where('parent_id', 0)
        												->where('store_id', $seller_id)
        												->where('is_show', 1)
        												->orderBy('sort_order', 'asc')
        												->get();
        
        $cat_arr = array();
        if (!empty($cat_list)) {
        	foreach($cat_list as $key => $val){
        		$cat_arr[] = array(
        				'id'	=> $val['cat_id'],
        				'name'	=> $val['cat_name'],
        				'children' => get_child_tree($val['cat_id']),
        		);
        	}
        }
        
        return $cat_arr;

		
	}
}


function get_child_tree($cat_id) {
    $cat_list = RC_DB::table('merchants_category')->selectRaw('cat_id, cat_name, parent_id')
        												->where('parent_id', $cat_id)
        												->where('is_show', 1)
        												->orderBy('sort_order', 'asc')
        												->get();
	$cat_arr = array();
	if (!empty($cat_list)) {
		foreach($cat_list as $key => $val){
			$cat_arr[] = array(
					'id'	=> $val['cat_id'],
					'name'	=> $val['cat_name'],
				);
        	}
	}												
    return $cat_arr;
}

// end
