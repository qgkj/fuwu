<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 促销商品删除(取消商品促销活动)
 * @author will
 */
class delete_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
		$priv = $this->admin_priv('goods_manage');
		if (is_ecjia_error($priv)) {
			return $priv;
		}
		$id = $this->requestData('goods_id', '0');
		if ($id <= 0) {
			return new ecjia_error(101, '参数错误');
		}

		$promotion_info = RC_Model::Model('goods/goods_model')->promote_goods_info($id);
		/* 多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 && $promotion_info['store_id'] != $_SESSION['store_id']) {
			return new ecjia_error(8, 'fail');
		}

		if (empty($promotion_info)) {
			return new ecjia_error(13, '不存在的信息');
		}

		$goods_name = $promotion_info['goods_name'];
		$result = RC_Model::Model('goods/goods_model')->promotion_remove($id);
		RC_Loader::load_app_func('global', 'promotion');
		assign_adminlog_content();
		if ($_SESSION['store_id'] > 0) {
// 		    ecjia_merchant::admin_log($goods_name.'【来源掌柜】', 'remove', 'promotion');
		    RC_Api::api('merchant', 'admin_log', array('text'=>$goods_name.'【来源掌柜】', 'action'=>'remove', 'object'=>'promotion'));
		} else {
		    ecjia_admin::admin_log($goods_name.'【来源掌柜】', 'remove', 'promotion');
		}
		
		$orm_goods_db = RC_Model::model('goods/orm_goods_model');
		/* 释放app缓存*/
		$goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
		if (!empty($goods_cache_array)) {
			foreach ($goods_cache_array as $val) {
				$orm_goods_db->delete_cache_item($val);
			}
			$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
		}
		/*释放商品基本信息缓存*/
		$cache_goods_basic_info_key = 'goods_basic_info_'.$id;
		$cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
		$orm_goods_db->delete_cache_item($cache_basic_info_id);
		return array();
	}
}

// end
