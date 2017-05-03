<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台搜索商品返回商品列表
 * @author will.chen
 */
class goods_get_goods_list_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *         $options['cat_id'] 分类id
     *         $options['brand_id'] 品牌id
     *
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options) 
	        || ((isset($options['keyword']) && empty($options['keyword'])) 
	        && !isset($options['cat_id']) 
	        && !isset($options['brand_id']))) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }
	   	$row = $this->get_goods_list($options);
	    return $row;
	}
	
	/**
	 * 取得商品列表：用于把商品添加到组合、关联类、赠品类
	 * @param   object  $filters    过滤条件
	 */
	private function get_goods_list($filter) {
		$db = RC_Model::model('goods/goods_model');
		RC_Loader::load_app_func('admin_category', 'goods');
		$time = RC_Time::gmtime();

		$where = array();
		$where['is_delete'] = (isset($filter['is_delete']) && $filter['is_delete'] == '1') ? 1 : 0;
		if (!empty($filter['store_id'])) {
		    $where['store_id'] = $filter['store_id'];
		}
		if (isset($filter['real_goods']) && $filter['real_goods'] > -1) {
			$where['is_real'] = intval($filter['real_goods']);
		}
		if (isset($filter['cat_id']) && $filter['cat_id'] > 0) {
			$where['cat_id'] = array_unique(array_merge(array($filter['cat_id']), array_keys(cat_list($filter['cat_id'], 0, false ))));
		}
		if (isset($filter['brand_id']) && $filter['brand_id'] > 0) {
			$where['brand_id'] = $filter['brand_id'];
		}
		if (isset($filter['intro_type']) && $filter['intro_type'] != '0') {
			$where['intro_type'] = 1;
		}
		if (isset($filter['intro_type']) && $filter['intro_type'] == 'is_promote') {
			$where['promote_start_date'] = array('elt' => $time);
			$where['promote_end_date'] = array('egt' => $time);
		}
		if (isset($filter['keyword']) && trim($filter['keyword']) != '') {
			$where[] = "(goods_name LIKE '%" . $filter['keyword'] . "%' OR goods_sn LIKE '%" . $filter['keyword'] . "%' OR goods_id LIKE '%" . $filter['keyword'] . "%') ";
		}
		if (isset($filter['suppliers_id']) && trim($filter['suppliers_id']) != '') {
			$where['suppliers_id'] = $filter['suppliers_id'];
		}
		if (isset($filter['in_ids'])) {
			$where['goods_id'] = $filter['in_ids'];
		}
		if (isset($filter['exclude'])) {
			$where[] = 'goods_id ' . db_create_in($filter['exclude']);
		}
		if (isset($filter['stock_warning'])) {
			$where[] = 'goods_number <= warn_number';
		}
		
		/* 取得数据 */
		$row = $db->field('goods_id, goods_name, shop_price')->where($where)->limit(50)->select();
		return $row;
	}
}

// end