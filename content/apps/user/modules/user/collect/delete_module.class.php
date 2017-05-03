<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户删除收藏商品
 * @author royalwang
 */
class delete_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		$collection_id = $this->requestData('rec_id');
		$goods_id = $this->requestData('goods_id', 0);
		if (empty($collection_id) && !goods_id) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		
		$db_collect_goods = RC_Model::model('goods/collect_goods_model');
		
		if ($goods_id > 0) {
			$db_collect_goods->where(array('goods_id' => $goods_id, 'user_id' => $user_id))->delete();
		} else {
			$collection_id = explode(',', $collection_id);
			$db_collect_goods->where(array('rec_id' => $collection_id, 'user_id' => $user_id))->delete();
		}
		return array();
	}
}

// end