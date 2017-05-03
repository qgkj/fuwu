<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  商家订单列表类
 */
class merchant_order_list {
	
	public $db_order_info;
	
	public $filter;
	
	/**
	 * 构造函数
	 * @param array $file 上传后返回的文件信息
	 */
	public function __construct() {
		$this->db_order_info = RC_DB::table('order_info as o');
	}
	
	public function get_order_list() {
		$pagesize = 15;
		
		$this->db_order_info->leftJoin('users as u', RC_DB::raw('o.user_id'), '=', RC_DB::raw('u.user_id'))
		->leftJoin('store_franchisee as s', RC_DB::raw('o.store_id'), '=', RC_DB::raw('s.store_id'));
		
		/* 处理查询提交*/
		$this->order_filter_where();
		$count = $this->db_order_info->count();
		
		$page = new ecjia_merchant_page($count, 15, 3);
		
		$fields = "o.order_id, o.store_id, o.order_sn, o.add_time, o.order_status, o.shipping_status, o.order_amount, o.money_paid, o.pay_status, o.consignee, o.address, o.email, o.tel, o.mobile, o.extension_code, o.extension_id ,(" . $this->order_amount_field('o.') . ") AS total_fee, s.merchants_name, u.user_name";
		 
		$row = $this->db_order_info
			->leftJoin('order_goods as og', RC_DB::raw('o.order_id'), '=', RC_DB::raw('og.order_id'))
			->selectRaw($fields)
			->take($pagesize)
			->skip($page->start_id-1)
			->groupby(RC_DB::raw('o.order_id'))
			->get();

		$order = array();
		/* 格式话数据 */
		if (!empty($row)) {
			foreach ($row AS $key => $value) {
				$order[$key]['formated_order_amount']	= price_format($value['order_amount']);
				$order[$key]['formated_money_paid']		= price_format($value['money_paid']);
				$order[$key]['formated_total_fee']		= price_format($value['total_fee']);
				$order[$key]['short_order_time']		= RC_Time::local_date('Y-m-d H:i', $value['add_time']);
				$order[$key]['user_name']				= empty($value['user_name']) ? RC_Lang::get('orders.order.anonymous') : $value['user_name'];
				$order[$key]['order_id']				= $value['order_id'];
				$order[$key]['order_sn']				= $value['order_sn'];
				$order[$key]['add_time']				= $value['add_time'];
				$order[$key]['order_status']			= $value['order_status'];
				$order[$key]['shipping_status']			= $value['shipping_status'];
				$order[$key]['order_amount']			= $value['order_amount'];
				$order[$key]['money_paid']				= $value['money_paid'];
				$order[$key]['pay_status']				= $value['pay_status'];
				$order[$key]['consignee']				= $value['consignee'];
				$order[$key]['email']					= $value['email'];
				$order[$key]['tel']						= $value['tel'];
				$order[$key]['mobile']					= $value['mobile'];
				$order[$key]['extension_code']			= $value['extension_code'];
				$order[$key]['extension_id']			= $value['extension_id'];
				$order[$key]['total_fee']				= $value['total_fee'];
				$order[$key]['merchants_name']			= $value['merchants_name'];
				 
				if ($value['order_status'] == OS_INVALID || $value['order_status'] == OS_CANCELED) {
					/* 如果该订单为无效或取消则显示删除链接 */
					$order[$key]['can_remove'] = 1;
				} else {
					$order[$key]['can_remove'] = 0;
				}
			}
		}
		return array('orders' => $order, 'filter' => $this->filter, 'page' => $page->show(2), 'desc' => $page->page_desc(), 'count' => $count);
	}
	
	public function order_filter_where() {
		$filter = $_GET;
		$where = array();
		if ($filter['keywords']) {
			$this->db_order_info->whereRaw('(o.order_sn like "%'.mysql_like_quote($filter['keywords']).'%" or o.consignee like "%'.mysql_like_quote($filter['keywords']).'%")');
		} 
		
		if ($filter['order_sn']) {
			$this->db_order_info->where(RC_DB::raw('o.order_sn'), 'like', $filter['order_sn']);
		}
		
		if ($filter['consignee']) {
			$this->db_order_info->where(RC_DB::raw('o.consignee'), 'like', $filter['consignee']);
		}
		
		if ($filter['email']) {
			$this->db_order_info->where(RC_DB::raw('o.email'), 'like', $filter['email']);
		}
		
		if ($filter['address']) {
			$this->db_order_info->where(RC_DB::raw('o.address'), 'like', $filter['address']);
		}
		
		if ($filter['zipcode']) {
			$this->db_order_info->where(RC_DB::raw('o.zipcode'), 'like', $filter['zipcode']);
		}
		
		if ($filter['tel']) {
			$this->db_order_info->where(RC_DB::raw('o.tel'), 'like', $filter['tel']);
		}
		
		if ($filter['mobile']) {
			$this->db_order_info->where(RC_DB::raw('o.mobile'), 'like', $filter['mobile']);
		}
		if ($filter['country']) {
			$this->db_order_info->where(RC_DB::raw('o.country'), $filter['country']);
		}
		if ($filter['province']) {
			$this->db_order_info->where(RC_DB::raw('o.province'), $filter['province']);
		}
		if ($filter['city']) {
			$this->db_order_info->where(RC_DB::raw('o.city'), $filter['city']);
		}
		if ($filter['district']) {
			$this->db_order_info->where(RC_DB::raw('o.district'), $filter['district']);
		}
		if ($filter['shipping_id']) {
			$this->db_order_info->where(RC_DB::raw('o.shipping_id'), $filter['shipping_id']);
		}
		if ($filter['pay_id']) {
			$this->db_order_info->where(RC_DB::raw('o.pay_id'), $filter['pay_id']);
		}
		if (isset($filter['status']) && $filter['status'] != -1) {
			$this->db_order_info->whereRaw('(o.order_status = '.$filter['status'].' or o.shipping_status  = '. $filter['status'] .' or o.pay_status  = '. $filter['status'] .')');
		}
		if (isset($filter['order_status']) && $filter['order_status'] != -1) {
			$this->db_order_info->where(RC_DB::raw('o.order_status'), $filter['order_status']);
		}
		if (isset($filter['shipping_status']) && $filter['shipping_status'] != -1) {
			$this->db_order_info->where(RC_DB::raw('o.shipping_status'), $filter['shipping_status']);
		}
		if (isset($filter['pay_status']) && $filter['pay_status'] != -1) {
			$this->db_order_info->where(RC_DB::raw('o.pay_status'), $filter['pay_status']);
		}
		if ($filter['user_id']) {
			$this->db_order_info->where(RC_DB::raw('o.user_id'), $filter['user_id']);
		}
		if ($filter['user_name']) {
			$this->db_order_info->where(RC_DB::raw('u.user_name'), 'like', $filter['user_name']);
		}
		if ($filter['start_time']) {
			$start_time = RC_Time::local_strtotime($filter['start_time']);
			$this->db_order_info->where(RC_DB::raw('o.add_time'), '>=', $start_time);
		}
		if ($filter['end_time']) {
			$end_time = RC_Time::local_strtotime($filter['end_time']);
			$this->db_order_info->where(RC_DB::raw('o.add_time'), '<=', $end_time);
		}
		$filter['sort_by'] 				= empty($filter['sort_by'])		? 'add_time'	: trim($filter['sort_by']);
		$filter['sort_order'] 			= empty($filter['sort_order'])	? 'DESC'		: trim($filter['sort_order']);
		$this->db_order_info->orderBy(RC_DB::raw('o.'.$filter['sort_by']), $filter['sort_order']);
	
 		isset($_SESSION['store_id']) ? $this->db_order_info->where(RC_DB::raw('o.store_id'), $_SESSION['store_id']) : '';
		
		/* 团购订单 */
		if ($filter['group_buy_id']) {
			$this->db_order_info->where(RC_DB::raw('o.extension_code'), 'group_buy');
			$this->db_order_info->where(RC_DB::raw('o.extension_id'), $filter['group_buy_id']);
		}
		
		//is_delete 为0的为没删除的
		$this->db_order_info->where(RC_DB::raw('o.is_delete'), 0);
		
		if (isset($filter['composite_status'])) {
			//综合状态
			switch($filter['composite_status']) {
				case CS_AWAIT_PAY :
					$this->order_await_pay();
					break;
			
				case CS_AWAIT_SHIP :
					$this->order_await_ship();
					break;
			
				case CS_FINISHED :
					$this->order_finished();
					break;
			
				case PS_PAYING :
					if ($filter['composite_status'] != -1) {
						$this->db_order_info->where(RC_DB::raw('o.pay_status'), $filter['composite_status']);
					}
					break;
				case OS_SHIPPED_PART :
					if ($filter['composite_status'] != -1) {
						$this->db_order_info->where(RC_DB::raw('o.shipping_status'), $filter['composite_status']-2);
					}
					break;
				default:
					if ($filter['composite_status'] != -1) {
						$this->db_order_info->where(RC_DB::raw('o.order_status'), $filter['composite_status']);
					}
			};
		}
		
		RC_Cookie::set('composite_status', $filter['composite_status']);
		$this->filter = $filter;
	}
	
	/* 已完成订单 */
	public function order_finished($alias = '') {
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_CONFIRMED, OS_SPLITED));
		$this->db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_SHIPPED, SS_RECEIVED));
		$this->db_order_info->whereIn(RC_DB::raw($alias.'pay_status'), array(PS_PAYED, PS_PAYING));
	}
	
	/* 待付款订单 */
	public function order_await_pay($alias = '') {
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(false);
		$payment_id = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;
		
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED));
		$this->db_order_info->where(RC_DB::raw($alias.'pay_status'), PS_UNPAYED);
		$this->db_order_info->whereRaw("( {$alias}shipping_status in (". SS_SHIPPED .",". SS_RECEIVED .") OR {$alias}pay_id in (" . $payment_id . ") )");
	}
	
	/* 待发货订单 */
	public function order_await_ship($alias = '') {
		$payment_method = RC_Loader::load_app_class('payment_method','payment');
		$payment_id_row = $payment_method->payment_id_list(true);
		$payment_id = "";
		foreach ($payment_id_row as $v) {
			$payment_id .= empty($payment_id) ? $v : ','.$v ;
		}
		$payment_id = empty($payment_id) ? "''" : $payment_id;
		
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART));
		$this->db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING));
		$this->db_order_info->whereRaw("( {$alias}pay_status in (" . PS_PAYED .",". PS_PAYING.") OR {$alias}pay_id in (" . $payment_id . "))");
		
		return $where;
	}
	
	/* 未确认订单 */
	public function order_unconfirmed($alias = '') {
		$this->db_order_info->where(RC_DB::raw($alias.'order_status'), OS_UNCONFIRMED);
	}
	
	/* 未处理订单：用户可操作 */
	public function order_unprocessed($alias = '') {
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED));
		$this->db_order_info->where(RC_DB::raw($alias.'shipping_status'), SS_UNSHIPPED);
		$this->db_order_info->where(RC_DB::raw($alias.'pay_status'), PS_UNPAYED);
	}
	
	/* 未付款未发货订单：管理员可操作 */
	public function order_unpay_unship($alias = '') {
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_UNCONFIRMED, OS_CONFIRMED));
		$this->db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_UNSHIPPED, SS_PREPARING));
		$this->db_order_info->where(RC_DB::raw($alias.'pay_status'), PS_UNPAYED);
	}
	
	/* 已发货订单：不论是否付款 */
	public function order_shipped($alias = '') {
		$this->db_order_info->whereIn(RC_DB::raw($alias.'order_status'), array(OS_CONFIRMED, OS_SPLITED));
		$this->db_order_info->whereIn(RC_DB::raw($alias.'shipping_status'), array(SS_SHIPPED));
	}
	
	/* 退货*/
	public function order_refund($alias = '') {
		$this->db_order_info->where(RC_DB::raw($alias.'order_status'), OS_RETURNED);
	}
	
	/* 无效*/
	public function order_invalid($alias = '') {
		$this->db_order_info->where(RC_DB::raw($alias.'order_status'), OS_INVALID);
	}
	
	/* 取消*/
	public function order_canceled($alias = '') {
		$this->db_order_info->where(RC_DB::raw($alias.'order_status'), OS_CANCELED);
	}
	
	/**
	 * 生成查询订单总金额的字段
	 * @param   string  $alias  order表的别名（包括.例如 o.）
	 * @return  string
	 */
	public function order_amount_field($alias = '') {
		return "   {$alias}goods_amount + {$alias}tax + {$alias}shipping_fee" .
		" + {$alias}insure_fee + {$alias}pay_fee + {$alias}pack_fee" .
		" + {$alias}card_fee ";
	}
}

// end