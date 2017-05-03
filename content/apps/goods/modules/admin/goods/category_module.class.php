<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺商品分类
 * @author zrl
 */
class category_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
        $keywords = $this->requestData('keywords');
    	$store_id = empty($_SESSION['store_id']) ? 0 : $_SESSION['store_id'];
    	$data = RC_Api::api('goods', 'seller_goods_category', array('type' => 'seller_goods_cat_list_api', 'store_id' => $store_id, 'keywords' => $keywords));
    	$outdata = array();
    	if (!empty($data)) {
    		foreach ($data as $key=>$value) {
    			$outdata[]=array(
    				'cat_id' 	=>$value['cat_id'],
    				'cat_name'	=>$value['cat_name'],
    				'parent_id'	=>$value['parent_id'],
    				'level'		=>$value['level']
    			);
    		}
    	}
    	return $outdata;
    }
}
