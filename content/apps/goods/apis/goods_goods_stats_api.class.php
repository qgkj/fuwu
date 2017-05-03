<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品统计
 * @author will.chen
 */
class goods_goods_stats_api extends Component_Event_Api {
	public function call(&$options) {
		$cache_key = 'api_goods_stats_'.md5($_SESSION['admin_id']);
        $stats = RC_Cache::app_cache_get($cache_key, 'goods');
        if (!$stats) {
        	$db_goods = RC_Model::model('goods/goods_model');
			/* 获取在售的商品总数*/
			$stats['total'] = $db_goods->where(array('is_delete' => 0, 'is_alone_sale' => 1, 'is_real' => 1))->count();
			RC_Cache::app_cache_set($cache_key, $stats, 'goods', 120);//2小时缓存
        }
	    return $stats;
	}
}

// end