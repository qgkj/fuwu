<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 支付方法
 * @author royalwang
 */
class payment_method {
	private $db;
	private $dblog;
	
	public function __construct() {
		$this->db = RC_Model::model('payment/payment_model');
		RC_Loader::load_app_class('payment_factory', 'payment', false);
	}
	
	
	/**
	 * 取得可用的支付方式列表
	 * @param   bool    $support_cod        配送方式是否支持货到付款
	 * @param   int     $cod_fee            货到付款手续费（当配送方式支持货到付款时才传此参数）
	 * @param   int     $is_online          是否支持在线支付
	 * @return  array   配送方式数组
	 */
	public function available_payment_list($support_cod = true, $cod_fee = 0, $is_online = false) {
		$db_payment = RC_DB::table('payment');
        $where = array();
        if (!$support_cod) {
            // $where['is_cod'] = 0;
            $db_payment->where('is_cod', 0);
        }
        if ($is_online) {
            // $where['is_online'] = 1;
            $db_payment->where('is_online', 1);
        }
        
        //$where['enabled'] = 1;
        $db_payment->where('enabled', 1);
        $plugins = $this->available_payment_plugins();

        // $data = $this->db->field('pay_id, pay_code, pay_name, pay_fee, pay_desc, pay_config, is_cod, is_online')->where($where)->order(array('pay_order' => 'asc'))->select();
        $data = $db_payment->select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc', 'pay_config', 'is_cod', 'is_online')->orderby('pay_order', 'asc')->get();

        $pay_list = array();
         
        if (!empty($data)) {
            foreach ($data as $row) {
                if (isset($plugins[$row['pay_code']])) {
                    if ($row['is_cod'] == '1') {
                        $row['pay_fee'] = $cod_fee;
                    }
                    
                    $row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] : price_format($row['pay_fee'], false);
                    $pay_list[] = $row;
                }
            }
        }

        return $pay_list;
	}
	
	
	/**
	 * 激活的支付插件列表
	 */
	public function available_payment_plugins() {
	   return ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
	}
	
	/**
	 * 获取指定支付方式的实例
	 * @param string $pay_code
	 * @param array $config
	 * @return payment_factory
	 */
	public function get_payment_instance($pay_code, $config = array()) {
	    $payment_info = $this->payment_info_by_code($pay_code);
	    if (empty($config)) {
	        $config = $this->unserialize_config($payment_info['pay_config']);
	    }
	    $config['pay_code'] = $pay_code;
	    $config['pay_name'] = $payment_info['pay_name'];
	    $handler = new payment_factory($pay_code, $config);
	    return $handler;
	}
	
	
	/**
	 * 取得支付方式信息
	 * @param   int|string     $pay_id/$pay_code     支付方式id 或 支付方式code
	 * @return  array   支付方式信息
	 */
	public function payment_info($pay_id) {
	    return $this->payment_info_by_id($pay_id);
	}
	public function payment_info_by_id($pay_id) {
	    return $this->db->find(array('pay_id' => $pay_id , 'enabled' => 1));
	}
	public function payment_info_by_code($pay_code) {
	    return $this->db->find(array('pay_code' => $pay_code , 'enabled' => 1));
	}
	public function payment_info_by_name($pay_name) {
		return $this->db->where(array('pay_name' => $pay_name , 'enabled' => 1))->select();
	}
	
	/**
	 * 取得支付方式id列表
	 * @param   bool    $is_cod 是否货到付款
	 * @return  array
	 */
	public function payment_id_list($is_cod) {
		$db_payment = RC_DB::table('payment');
	    if ($is_cod) {
	        // $where = "is_cod = 1" ;
	        $db_payment->where('is_cod', 1);

	    } else {
	        // $where = "is_cod = 0" ;
	        $db_payment->where('is_cod', 0);
	    }
	    // $row = $this->db->field('pay_id')->where($where)->select();
	    $row = $db_payment->select('pay_id')->get();

	    $arr = array();
	    if(!empty($row) && is_array($row)) {
	    	foreach ($row as $val) {
	    		$arr[] = $val['pay_id'];
	    	}
	    }
	    
	    return $arr;
	}
	
	
	/**
	 * 将支付LOG插入数据表
	 *
	 * @access public
	 * @param integer $id
	 *        	订单编号
	 * @param float $amount
	 *        	订单金额
	 * @param integer $type
	 *        	支付类型
	 * @param integer $is_paid
	 *        	是否已支付
	 *
	 * @return int
	 */
	public function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
	    // $db = RC_Loader::load_app_model('pay_log_model', 'orders');
	    $data = array (
	        'order_id'     => $id,
	        'order_amount' => $amount,
	        'order_type'   => $type,
	        'is_paid'      => $is_paid
	    );
	
	    // $insert_id = $db->insert($data);
		$insert_id = RC_DB::table('pay_log')->insertGetId($data);    	

	    return $insert_id;
	}
	
	
	/**
	 * 取得上次未支付的pay_lig_id
	 *
	 * @access public
	 * @param array $surplus_id
	 *        	余额记录的ID
	 * @param array $pay_type
	 *        	支付的类型：预付款/订单支付
	 *
	 * @return int
	 */
	public function get_paylog_id($surplus_id, $pay_type = PAY_SURPLUS) {
	    // $db = RC_Loader::load_app_model('pay_log_model', 'orders');
	    // $log_id = $db->where(array('order_id' => $surplus_id, 'order_type' => $pay_type, 'is_paid' => 0))->get_field('log_id');

	   	$log_id = RC_DB::table('pay_log')->where('order_id', $surplus_id)->where('order_type', $pay_type)->where('is_paid', 0)->pluck('log_id');
		return $log_id;
	}

	/**
	 * 更新支付LOG
	 *
	 * @access public
	 * @param integer $id
	 *        	订单编号
	 * @param float $amount
	 *        	订单金额
	 * @param integer $type
	 *        	支付类型
	 * @param integer $is_paid
	 *        	是否已支付
	 *
	 * @return int
	 */
	public function update_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
		// $db = RC_Loader::load_app_model('pay_log_model', 'orders');
		// $row = $db->where(array('order_id' => $id, 'order_type'=> $type, 'is_paid' => 0))->update(array('order_amount' => $amount));
		// return $row;
		RC_DB::table('pay_log')->where('order_id', $id)->where('order_type', $type)->where('is_paid', 0)->update(array('order_amount' => $amount));
		return true;
	}
	
	/**
	 * 处理序列化的支付、配送的配置参数
	 * 返回一个以name为索引的数组
	 *
	 * @access  public
	 * @param   string       $cfg
	 * @return  void
	 */
	public function unserialize_config($cfg) {
	    if (is_string($cfg) && ($arr = unserialize($cfg)) !== false) {
	        $config = array();
	        foreach ($arr AS $key => $val) {
	            $config[$val['name']] = $val['value'];
	        }
	        return $config;
	    } else {
	        return false;
	    }
	}
	
	/**
	 * 取得已安装的支付方式(其中不包括线下支付的)
	 * @param   bool    $include_balance    是否包含余额支付（冲值时不应包括）
	 * @return  array   已安装的配送方式列表
	 */
	public function get_online_payment_list($include_balance = true) {
		// $where = array();
		// $where['enabled'] = '1';
		// $where['is_cod'] = array('neq' => '1');

		$db_payment = RC_DB::table('payment')->where('enabled', 1)->where('is_cod', '!=', 1);

		if (!$include_balance) {
			// $where['pay_code'] = array('neq' => 'balance');
			$db_payment->where('pay_code', '!=', 'balance');
		}
		$plugins = $this->available_payment_plugins();
		
		// $data = $this->db->field('pay_id, pay_code, pay_name, pay_fee, pay_desc')->where($where)->select();
		$data = $db_payment->select('pay_id', 'pay_code', 'pay_name', 'pay_fee', 'pay_desc')->get();
		
		$pay_list = array();
		 
		if (!empty($data)) {
			foreach ($data as $row) {
				if (isset($plugins[$row['pay_code']])) {
					$row['format_pay_fee'] = strpos($row['pay_fee'], '%') !== false ? $row['pay_fee'] :
					$pay_list[] = $row;
				}
			}
		}
		
		return $pay_list;
		
// 		$modules = $GLOBALS['db']->getAll($sql);
	
// 		include_once(ROOT_PATH.'includes/lib_compositor.php');
	
// 		return $modules;
	}
}

// end