<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 删除(回收站)/从回收站返回商品
 * @author will
 */
class trash_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		if (!$this->admin_priv('goods_update')) {
			return new ecjia_error('privilege_error', '对不起，您没有执行此项操作的权限！');
		}

		$id = $this->requestData('id');
		if (empty($id)) {
			return new ecjia_error('not_exists_info', '不存在的信息');
		}
		$data = array(
				'is_delete' => 1,
				'last_update' => RC_Time::gmtime()
		);
		$db_goods = RC_Model::model('goods/goods_model');

		$where = array('goods_id' => $id);
		if ($_SESSION['store_id'] > 0) {
			$where = array_merge($where, array('store_id' => $_SESSION['store_id']));
		}
		$db_goods->where($where)->update($data);

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
		$goods_name = $db_goods->where(array('goods_id' => $id))->get_field('goods_name');
		if ($_SESSION['store_id'] > 0) {
// 		    ecjia_merchant::admin_log(addslashes($goods_name).'【来源掌柜】', 'trash', 'goods'); // 记录日志
		    RC_Api::api('merchant', 'admin_log', array('text'=>$goods_name.'【来源掌柜】', 'action'=>'trash', 'object'=>'goods'));
		} else {
		    ecjia_admin::admin_log(addslashes($goods_name).'【来源掌柜】', 'trash', 'goods'); // 记录日志
		}
		
		return array();
	}
}

// end
