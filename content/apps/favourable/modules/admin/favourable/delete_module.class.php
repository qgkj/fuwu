<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 满减满赠活动删除
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
		
		$id = $this->requestData('act_id', 0);
		if ($id <= 0) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		
		$favourable = RC_Model::model('favourable/favourable_activity_model')->favourable_info($id);
		if (empty($favourable)) {
			return new ecjia_error('not_exists_info', '不存在的信息');
		}
		/* 多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 && $favourable['store_id'] != $_SESSION['store_id']) {
			return new ecjia_error('not_exists_info', '不存在的信息');
		}
		
		$name = $favourable['act_name'];
		$act_type = $favourable['act_type'];
		
		if ($act_type == 0) {
			$act_type = '享受赠品（特惠品）';
		} elseif ($act_type == 1) {
			$act_type = '享受现金减免';
		} else {
			$act_type = '享受价格折扣';
		}
		
		$result = RC_Model::model('favourable/favourable_activity_model')->favourable_remove($id);
		if ($_SESSION['store_id'] > 0) {
// 		    ecjia_merchant::admin_log($name.'，'.'优惠活动方式是 '.$act_type.'【来源掌柜】', 'remove', 'favourable');
		    RC_Api::api('merchant', 'admin_log', array('text'=>$name.'，'.'优惠活动方式是 '.$act_type.'【来源掌柜】', 'action'=>'remove', 'object'=>'favourable'));
		} else {
		    ecjia_admin::admin_log($name.'，'.'优惠活动方式是 '.$act_type.'【来源掌柜】', 'remove', 'favourable');
		}
		
		/* 释放缓存*/
		$favourable_activity_db   = RC_Model::model('favourable/orm_favourable_activity_model');
		$cache_favourable_key     = 'favourable_list_store_'.$favourable['store_id'];
		$cache_id                 = sprintf('%X', crc32($cache_favourable_key));
		
		$favourable_activity_db->delete_cache_item($cache_id);
		return array();
	}
}

// end