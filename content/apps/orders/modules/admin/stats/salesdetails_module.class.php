<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 收益明细
 * @author luchongchong
 */
class salesdetails_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id' ] <= 0 && $_SESSION['staff_id'] <= 0) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$result = $this->admin_priv('sale_order_stats');
		if (is_ecjia_error($result)) {
			return $result;
		}
		//传入参数
		$start_date = $this->requestData('start_date');
		$end_date = $this->requestData('end_date');
		if (empty($start_date) || empty($end_date)) {
			return new ecjia_error(101, '参数错误');
		}
		
		$db_orderinfo_view = RC_Model::model('orders/order_info_viewmodel');
		$db_orderinfo_view->view = array(
			'order_goods' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'og',
				'on'	=> 'oi.order_id = og.order_id'
			)
		);
	
		$type = $start_date == $end_date ? 'time' : 'day';
		$start_date = RC_Time::local_strtotime($start_date. ' 00:00:00');
		$end_date	= RC_Time::local_strtotime($end_date. ' 23:59:59');
		/* 判断是否是入驻商*/
		if ($_SESSION['store_id'] > 0 ) {
			$join = array('order_goods');
		}
		$where = array();
		$where[] = 'oi.pay_time >="' .$start_date. '" and oi.pay_time<="' .$end_date. '"';
		$where[] = 'oi.pay_status = 2';
		if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0) {
			/*入驻商*/
			$where['store_id'] = $_SESSION['store_id'];
		}
		$count = $db_orderinfo_view->join($join)->where($where)->count('oi.order_id');

		/* 查询总数为0时直接返回  */
		if ($count == 0) {
			$pager = array(
				'total' => 0,
				'count' => 0,
				'more'	=> 0,
			);
			return array('data' => array(), 'pager' => $pager);
		}
		/* 获取数量 */
		$pagination = $this->requestData('pagination');
		$size = $pagination['count'];
		$page = $pagination['page'];

		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$field = "oi.pay_time, oi.goods_amount - oi.discount + oi.tax + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee AS total_fee";
		
		$result = $db_orderinfo_view->field($field)
			->join($join)
			->where($where)
			->order('pay_time DESC')
			->limit($page_row->limit())
			->select();
		$stats = array();
		if (!empty($result)) {
			foreach ($result as $k => $v) {
				if($v['total_fee']!=0) {
					$stats[] = array(
						'time'				=> $v['pay_time'],
						'formatted_time'	=> RC_Time::local_date('Y-m-d H:i:s',$v['pay_time']),
						'amount'			=> $v['total_fee'],
						'value'				=> $v['total_fee']
					);
				}
			}
		}
		
		$pager = array(
			"total" => $page_row->total_records,
			"count" => $page_row->total_records,
			"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('data' => $stats, 'pager' => $pager);
	}
}

//end