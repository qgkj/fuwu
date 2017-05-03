<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods';
		parent::__construct();
	}

	/**
	 * 取得促销商品列表
	 * @param array $filter
	 * @return  array
	 */
	public function promotion_list($filter) {
		/* 过滤条件 */
		$filter['keywords'] = empty($filter['keywords']) ? '' : trim($filter['keywords']);
		$where = array();
		$where = array('is_promote' => 1);
		$where['is_delete'] = array('neq' => 1);
		/* 多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
			$where['store_id'] = $_SESSION['store_id'];
		}

		if (!empty($filter['keywords'])) {
			$where['goods_name'] = array('like' => '%'.$filter['keywords'].'%');
		}

		$time = RC_Time::gmtime();
		if ($filter['status'] == 'going') {
			$where['promote_start_date'] = array('elt' => $time);
			$where['promote_end_date'] = array('egt' => $time);
		}

		if ($filter['status'] == 'coming') {
			$where['promote_start_date'] = array('egt' => $time);
		}

		if ($filter['status'] == 'finished') {
			$where['promote_end_date'] = array('elt' => $time);
		}

		$filter['record_count'] = $this->where($where)->count();
		$field = 'goods_id, goods_name, shop_price, market_price, promote_price, promote_start_date, promote_end_date, goods_thumb, original_img, goods_img';
		//实例化分页
		$page_row = new ecjia_page($filter['record_count'], $filter['size'], 6, '', $filter['page']);

		$res = $this->field($field)->where($where)->order('sort_order asc')->limit($page_row->limit())->select();

		$list = array();
		if (!empty($res)) {
			foreach ($res as $row) {
				$row['promote_start_date']  = RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']);
				$row['promote_end_date']    = RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']);
				$row['goods_thumb']			= !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png');
				$row['original_img']		= !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : RC_Uri::admin_url('statics/images/nopic.png');
				$row['goods_img']			= !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png');
				$list[] = $row;
			}
		}
		return array('item' => $list, 'filter' => $filter, 'page' => $page_row);
	}

	/**
	 * 促销的商品信息
	 * @param int $goods_id
	 * @return array
	 */
	function promote_goods_info($goods_id) {
		$where = array();
		$where['goods_id'] = $goods_id;
		/*多商户处理*/
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 ) {
			$where['store_id'] = $_SESSION['store_id'];
		}
		$field = 'goods_id, store_id, goods_name, shop_price, market_price, promote_price, promote_start_date, promote_end_date, goods_thumb, original_img, goods_img';
		$row = $this->field($field)->where($where)->find();

		if (! empty ( $row )) {
			$row['formatted_shop_price']		        = price_format($row['shop_price']);
			$row['formatted_market_price']		        = price_format($row['market_price']);
			$row['formatted_promote_price']		        = price_format($row['promote_price']);
			$row['promote_start_date']			        =  $row['promote_start_date'];
			$row['promote_end_date']  			        =  $row['promote_end_date'];
			$row['formatted_promote_start_date']  		= RC_Time::local_date('Y-m-d H:i:s', $row['promote_start_date']);
			$row['formatted_promote_end_date']    		= RC_Time::local_date('Y-m-d H:i:s', $row['promote_end_date']);
			$row['img']							        = array(
				'goods_thumb'  => !empty($row['goods_thumb']) ? RC_Upload::upload_url($row['goods_thumb']) : RC_Uri::admin_url('statics/images/nopic.png'),
				'original_img' => !empty($row['original_img']) ? RC_Upload::upload_url($row['original_img']) : RC_Uri::admin_url('statics/images/nopic.png'),
				'goods_img'    => !empty($row['goods_img']) ? RC_Upload::upload_url($row['goods_img']) : RC_Uri::admin_url('statics/images/nopic.png')
			);
		}
		unset($row['goods_thumb']);
		unset($row['original_img']);
		unset($row['goods_img']);
		return $row;
	}

	/**
	 * 取消商品的促销活动
	 * @param int $act_id
	 * @return boolean
	 */
	public function promotion_remove($goods_id) {
		$this->where(array('goods_id' => $goods_id))->update(array('is_promote' => 0, 'promote_price' => 0, 'promote_start_date' => 0, 'promote_end_date' => 0));
		return true;
	}


	/**
	 * 促销商品管理
	 * @param array $parameter
	 * @return int goods_id
	 */
	public function promotion_manage($parameter) {
		if (isset($parameter['goods_id']) && $parameter['goods_id'] > 0) {
			$act_id = $this->where(array('goods_id' => $parameter['goods_id']))->update($parameter);
		}
		return $act_id;
	}

	/* 查询字段信息 */
	public function goods_field($where, $field, $bool=false) {
	    return $this->where($where)->get_field($field, $bool);
	}

    public function is_only($where) {
    	return $this->where($where)->count();
    }

    /*搜索商品*/
    public function goods_select($where, $in=false, $field='*') {
        if ($in) {
            return $this->field($field)->in($where)->select();
        }
        return $this->field($field)->where($where)->select();
    }

    public function goods_find($where = array(), $field='*') {
        return $this->field($field)->where($where)->find();
    }

    public function goods_update($where, $data) {
    	return $this->where($where)->update($data);
    }

    public function goods_inc($field, $where, $num) {
    	return $this->inc($field, $where, $num);
    }
}

// end
