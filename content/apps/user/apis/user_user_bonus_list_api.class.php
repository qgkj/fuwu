<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取会员红包列表
 * @author will.chen
 */
class user_user_bonus_list_api extends Component_Event_Api {
    
    public function call(&$options) {
    	
    	$db = RC_Model::model('user/user_bonus_type_viewmodel');
    	
    	$cur_date = RC_Time::gmtime();
    	
    	$where = array();
    	$where['ub.user_id'] = $_SESSION['user_id'];
    	if ($options['bonus_type'] == 'allow_use') {
    		$where['bt.use_end_date']	= array('gt' => $cur_date);
    		$where['ub.order_id'] = 0;
    	} elseif ($options['bonus_type'] == 'expired') {
    		$where['bt.use_end_date'] = array('lt' => $cur_date);
    	} elseif ($options['bonus_type'] == 'is_used') {
    		$where['ub.order_id'] = array('gt' => 0);
    	}
    	
    	
    	$count = $db->join(array('bonus_type', 'store_franchisee'))->where($where)->count();
    	$page_row = new ecjia_page($count, $options['size'], 6, '', $options['page']);
    	
    	$rows = $db->join(array('bonus_type', 'store_franchisee'))
                	->field('ub.bonus_id, ub.order_id, bt.type_name, bt.type_money, bt.min_goods_amount, bt.use_start_date, bt.use_end_date, s.store_id, s.manage_mode, s.merchants_name')
                	->where($where)
                	->limit($page_row->limit())
                	->select();
    
    	$bonus_list = array();
    	
    	if (!empty($rows)) {
    		foreach ($rows as $key => $row) {
    			$bonus_list[$key] = array(
    					'seller_id'		               => $row['store_id'],
    					'seller_name'	               => $row['merchants_name'],
    					'manage_mode'	               => $row['manage_mode'],
    					'bonus_id'		               => $row['bonus_id'],
    					'bonus_name'	               => $row['type_name'],
    					'bonus_amount'	               => $row['type_money'],
    					'formatted_bonus_amount'       => price_format($row['type_money']),
    					'request_amount'	           => $row['min_goods_amount'],
    					'formatted_request_amount'	   => price_format($row['min_goods_amount']),
    					'start_date'	               => $row['use_start_date'],
    					'end_date'		               => $row['use_end_date'],
    					'formatted_start_date'	       => RC_Time::local_date(ecjia::config('date_format'), $row['use_start_date']),
    					'formatted_end_date'	       => RC_Time::local_date(ecjia::config('date_format'), $row['use_end_date']),
    			);
    			
    			/* 先判断是否被使用，然后判断是否开始或过期 */
    			if (empty($row['order_id'])) {
    				/* 没有被使用 */
    				if ($row['use_start_date'] > $cur_date) {
    					$bonus_list[$key]['status']       = 'unstarted';
    					$bonus_list[$key]['label_status'] = '未开始';
    					
    				} else if ($row['use_end_date'] < $cur_date) {
    					$bonus_list[$key]['status']       = 'expired';
    					$bonus_list[$key]['label_status'] = '已过期';
    				} else {
    					$bonus_list[$key]['status']       = 'allow_use';
    					$bonus_list[$key]['label_status'] = '可使用';
    				}
    			} else {
    				$bonus_list[$key]['status']       = 'is_used';
    				$bonus_list[$key]['label_status'] = '已使用';
    			}
    		}
    	}
    	
    	return array('bonus_list'=> $bonus_list, 'filter' => $options, 'page' => $page_row);
    }
}

// end