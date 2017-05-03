<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 配送方法
 * @author royalwang
 */
class shipping_method  {
	private $db;
    
	public function __construct() {
		$this->db = RC_Model::model('shipping/shipping_model');
	}
	
	
	/**
     * 取得可用的配送方式列表
     * @param   array   $region_id_list     收货人地区id数组（包括国家、省、市、区）
     * @return  array   配送方式数组
     */
    public function available_shipping_list($region_id_list, $store_id = 0) {  	
		$data = RC_DB::table('shipping')->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
			->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
			->select('shipping.shipping_id', 'shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
			->where('shipping.enabled', 1)
			->where('shipping_area.store_id', $store_id)
			->whereIn('area_region.region_id', $region_id_list)
			->orderby('shipping.shipping_order', 'asc')
			->get();	
		$plugins = $this->available_shipping_plugins();

		$pay_list = array();
        if (!empty($data)) {
        	foreach ($data as $row) {
        		if (isset($plugins[$row['shipping_code']])) {
        			$pay_list[] = $row;
        		}
        	}
        }
        return $pay_list;
    }
	
    /**
     * 激活的支付插件列表
     */
    public function available_shipping_plugins() {
    	return ecjia_config::instance()->get_addon_config('shipping_plugins', true);
    }
    
    /**
     * 取得某配送方式对应于某收货地址的区域信息
     * @param   int     $shipping_id        配送方式id
     * @param   array   $region_id_list     收货人地区id数组
     * @return  array   配送区域信息（config 对应着反序列化的 configure）
     */
    public function shipping_area_info($shipping_id, $region_id_list, $store_id) {
    	$db = RC_DB::table('shipping');
        $row = $db->leftJoin('shipping_area', 'shipping_area.shipping_id', '=', 'shipping.shipping_id')
        	->leftJoin('area_region', 'area_region.shipping_area_id', '=', 'shipping_area.shipping_area_id')
        	->select('shipping.shipping_code', 'shipping.shipping_name', 'shipping.shipping_desc', 'shipping.insure', 'shipping.support_cod', 'shipping_area.configure')
        	->where('shipping.shipping_id', $shipping_id)
        	->where('shipping.enabled', 1)
        	->whereIn('area_region.region_id', $region_id_list)
        	->where('shipping_area.store_id', $store_id)
        	->first();
        
        if (!empty($row)) {
            $shipping_config = $this->unserialize_config($row['configure']);
            if (isset($shipping_config['pay_fee'])) {
                if (strpos($shipping_config['pay_fee'], '%') !== false) {
                    $row['pay_fee'] 	= floatval($shipping_config['pay_fee']) . '%';
                } else {
                    $row['pay_fee'] 	= floatval($shipping_config['pay_fee']);
                }
            } else {
                $row['pay_fee'] 	= 0.00;
            }
        }
        return $row;
    }

	
    /**
     * 取得已安装的配送方式
     * @return  array   已安装的配送方式
     */
    public function shipping_list() {
    	$data = RC_DB::table('shipping')->select('shipping_id', 'shipping_name', 'shipping_code')->where('enabled', 1)->get();
    	
    	$plugins = $this->available_shipping_plugins();
    	$pay_list = array();
    	if (!empty($data)) {
    		foreach ($data as $row) {
    			if (isset($plugins[$row['shipping_code']])) {
    				$pay_list[] = $row;
    			}
    		}
    	}
    	return $pay_list;
    }
    
    
    /**
     * 取得配送方式信息
     * @param   int     $shipping_id    配送方式id
     * @return  array   配送方式信息
     */
    public function shipping_info($shipping_id) {
//         return $this->db->find(array('shipping_id' => $shipping_id , 'enabled' => 1));
        
        return RC_DB::table('shipping')->where('shipping_id', $shipping_id)->where('enabled', 1)->first();
    }
	
    
    /**
     * 计算运费
     * @param   string  $shipping_code	  配送方式代码
     * @param   mix	 $shipping_config	配送方式配置信息
     * @param   float   $goods_weight	   商品重量
     * @param   float   $goods_amount	   商品金额
     * @param   float   $goods_number	   商品数量
     * @return  float   运费
     */
    function shipping_fee($shipping_code, $shipping_config, $goods_weight, $goods_amount, $goods_number='') {
    	if (!is_array($shipping_config)) {
    		$shipping_config = unserialize($shipping_config);
    	}
    	
    	RC_Loader::load_app_class('shipping_factory', 'shipping', false);
    	$handler = new shipping_factory($shipping_code, $shipping_config);
    	$shipping_fee = $handler->calculate($goods_weight, $goods_amount, $goods_number);

    	if (empty($shipping_fee)) {
    		return 0;
    	} else {
    		return $shipping_fee;
    	}
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
     * 获取指定配送的保价费用
     *
     * @access  public
     * @param   string	  $shipping_code  配送方式的code
     * @param   float	   $goods_amount   保价金额
     * @param   mix		 $insure		 保价比例
     * @return  float
     */
    public function shipping_insure_fee($shipping_code, $goods_amount, $insure) {
    	if (strpos($insure, '%') === false) {
    		/* 如果保价费用不是百分比则直接返回该数值 */
    		return floatval($insure);
    	} else {
    		RC_Loader::load_app_class('shipping_factory', 'shipping', false);
    		$shipping_handle = new shipping_factory($shipping_code);
    		if ($shipping_handle){
    			$insure   = floatval($insure) / 100;
    			if (method_exists($shipping, 'calculate_insure')) {
    				return $shipping_handle->calculate_insure($goods_amount, $insure);
    			} else {
    				return ceil($goods_amount * $insure);
    			}
    		} else {
    			return false;
    		}
    	}
    }
}

// end