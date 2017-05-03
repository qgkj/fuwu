<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 满减满赠活动添加编辑处理
 * @author will
 */
class manage_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
			return new ecjia_error(100, 'Invalid session');
		}
		
		$priv = $this->admin_priv('goods_manage');
		if (is_ecjia_error($priv)) {
			return $priv;
		}
		
		RC_Loader::load_app_class('favourable', 'favourable', false);
		
		$act_id       = $this->requestData('act_id', 0);
		$user_rank    = $this->requestData('user_rank');
		$gift         = $this->requestData('gift', array());
		
		$favourable = array(
			'act_name'      => $this->requestData('act_name'),
			'start_time'    => RC_Time::local_strtotime($this->requestData('start_time')),
			'end_time'      => RC_Time::local_strtotime($this->requestData('end_time')),
			'user_rank'     => $user_rank,
			'act_range'     => $this->requestData('act_range', 0),
			'act_range_ext' => $this->requestData('act_range_ext'),
			'min_amount'    => $this->requestData('min_amount'),
			'max_amount'    => $this->requestData('max_amount'),
			'act_type'      => $this->requestData('act_type'),
			'act_type_ext'  => $this->requestData('act_type_ext'),
			'gift'          => serialize($gift),
		);
		/* 检查优惠活动时间 */
		if ($favourable['start_time'] >= $favourable['end_time']) {
			return new ecjia_error('time_error', __('优惠开始时间不能大于或等于结束时间'));
		}
		
		/* 检查享受优惠的会员等级 */
		if (!isset($favourable['user_rank'])) {
			return new ecjia_error('user_rank_error', __('请设置享受优惠的会员等级'));
		}
	
		if (!in_array($favourable['act_range'], array(0, 1, 2, 3))) {
		    return new ecjia_error('act_range_error', __('请设置活动类型'));
		}
		/* 检查优惠范围扩展信息 */
		if ($favourable['act_range'] > 0 && !isset($favourable['act_range_ext'])) {
			return new ecjia_error('act_range_error', __('请设置优惠范围'));
		}
		/* 检查金额上下限 */
		$min_amount = floatval($favourable['min_amount']) >= 0 ? floatval($favourable['min_amount']) : 0;
		$max_amount = floatval($favourable['max_amount']) >= 0 ? floatval($favourable['max_amount']) : 0;
		if ($max_amount > 0 && $min_amount > $max_amount) {
			return new ecjia_error('amount_error', __('金额下限不能大于金额上限'));
		}
		
		if ($act_id > 0) {
			$favourable['act_id'] = $act_id;
		}
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			$favourable['store_id'] = $_SESSION['store_id'];
		}
		
		if ($favourable['act_type'] == 0) {
			$act_type = '享受赠品（特惠品）';
		} elseif ($favourable['act_type'] == 1) {
			$act_type = '享受现金减免';
		} else {
			$act_type = '享受价格折扣';
		}
		RC_Model::model('favourable/favourable_activity_model')->favourable_manage($favourable);
		if ($act_id > 0 ) {
			$log_action = 'edit';
		} else {
			$log_action = 'add';
		}
		$log_text = $favourable['act_name'].'，'.'优惠活动方式是 '.$act_type;
		
		if ($_SESSION['store_id'] > 0) {
// 		    ecjia_merchant::admin_log($log_text, $log_text, 'favourable');
		    RC_Api::api('merchant', 'admin_log', array('text'=>$log_text, 'action'=>$log_text, 'object'=>'favourable'));
		} else {
		    ecjia_admin::admin_log($log_text, $log_action, 'favourable');
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