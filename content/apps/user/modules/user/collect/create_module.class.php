<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户收藏商品
 * @author royalwang
 */
class create_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
        $this->authSession();
        $user_id = $_SESSION['user_id'];
    	if ($user_id <= 0) {
    		return new ecjia_error(100, 'Invalid session');
    	}
		$goods_id = $this->requestData('goods_id', 0);
		if (!$goods_id) {
			return new ecjia_error(101, '参数错误');
		}
		
		RC_Loader::load_app_func('admin_goods', 'goods');
		$goods = get_goods_info($goods_id);

		if (!$goods) {
			return new ecjia_error(13, '不存在的信息');
		}
		/* 检查是否已经存在于用户的收藏夹 */
		
		$db_collect_goods = RC_Model::model('goods/collect_goods_model');
        $count = $db_collect_goods->where(array('user_id' => $user_id, 'goods_id' => $goods_id))->count();

		if ($count > 0) {
			return new ecjia_error(10007, '您已收藏过此商品');
		} else {
			$time = RC_Time::gmtime();
			$data = $db_collect_goods->insert(array('user_id' => $user_id, 'goods_id' => $goods_id, 'add_time' => $time));
			if ($data === false) {
				return new ecjia_error(8, 'fail');
			} else {
				return array();
			}
		}	
	}
}

// end