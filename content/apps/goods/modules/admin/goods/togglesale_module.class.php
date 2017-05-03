<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 上下架商品
 * @author will
 */
class togglesale_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_manage')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
		}

		RC_Loader::load_app_func('global', 'goods');
		$id = $this->requestData('id');
		$type = $this->requestData('type');//online 上架;offline下架
		if (empty($id) || empty($type)) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		$on_sale = $type == 'online' ? 1 : 0;

		$data = array(
			'is_on_sale' => $on_sale,
			'last_update' => RC_Time::gmtime()
		);
		$db_goods = RC_Model::model('goods/goods_model');

		$where = array('goods_id' => $id);
		if ($_SESSION['ru_id'] > 0) {
			$where = array_merge($where, array('user_id' => $_SESSION['ru_id']));
		}
		$db_goods->where($where)->update($data);

		$goods_name = $db_goods->where(array('goods_id' => $id))->get_field('goods_name');
		if ($on_sale == '1') {
			$log_text = '上架商品';
		} else {
			$log_text = '下架商品';
		}
		$log_text .= '，' . $goods_name .'【来源掌柜】';
		
		if ($_SESSION['store_id'] > 0) {
		    RC_Api::api('merchant', 'admin_log', array('text'=>$log_text, 'action'=>'setup', 'object'=>'goods'));
		} else {
		    ecjia_admin::admin_log($log_text, 'setup', 'goods');
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
