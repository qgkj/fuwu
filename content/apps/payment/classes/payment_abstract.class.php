<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 支付抽象类
 * @author royalwang
 */
abstract class payment_abstract {
	protected $product_info 	= array();
	protected $customter_info 	= array();
	protected $order_info 		= array();
	protected $shipping_info 	= array();
	
	protected $configure        = array();
	
	protected $is_mobile        = false;
	
	/**
	 * 构造函数
	 *
	 * @param: $configure[array]    配送方式的参数的数组
	 *
	 * @return null
	*/
	public function __construct($cfg = array()) {
	    if (!empty($cfg)) {
	        foreach ($cfg AS $key => $val) {
	            $this->configure[$key] = $val;
	        }
	    }
	}
	
	/**
	 * 设置是否是手机访问使用
	 * @param boolean $bool
	 */
	public function set_mobile($bool) {
	    $this->is_mobile = $bool;
	}
	
	/**
	 * 支付方式的配置表单信息
	 */
	public function configure_forms($code_list = array(), $format = false) {
	    $config = $this->configure_config();
	    $forms = array();
	    if ($config['forms']) {
	        $forms = $config['forms'];
	    }
	    
	    if ($format) {
	        RC_Lang::load_plugin($config['pay_code']);
	        
	        $pay_config = array();
	        /* 循环插件中所有属性 */
	        if (!empty($forms)) {
	            foreach ($forms as $key => $value) {
	            	//todo 语言包升级待确认
	                $pay_config[$key]['desc'] = RC_Lang::lang($value['name'] . '_desc') ? RC_Lang::lang($value['name'] . '_desc') : '';
	                $pay_config[$key]['label'] = RC_Lang::lang($value['name']);
	                $pay_config[$key]['name'] = $value['name'];
	                $pay_config[$key]['type'] = $value['type'];
	        
	                if (!empty($code_list) && isset($code_list[$value['name']])) {
	                    $pay_config[$key]['value'] = $code_list[$value['name']];
	                } else {
	                    $pay_config[$key]['value'] = $value['value'];
	                }
	        
	                if ($pay_config[$key]['type'] == 'select' ||
	                    $pay_config[$key]['type'] == 'radiobox') {
	                	//todo 语言包升级待确认
	                        $pay_config[$key]['range'] = RC_Lang::lang($pay_config[$key]['name'] . '_range');
	                    }
	            }
	        }
	        
	        return $pay_config;
	    } else {
	        return $forms;
	    }
	}
	
	/**
	 * 获取插件配置信息
	 */
	abstract public function configure_config();
	public function set_config(array $config) {
		foreach ($config as $key => $value) {
		    $this->configure[$key] = $value;
		}
		return $this;
	}
	public function get_config() {
	    return $this->configure;
	}

	public function set_productinfo($product_info) {
		$this->product_info = $product_info;
		return $this;
	}

	public function set_customerinfo($customer_info) {
		$this->customer_info = $customer_info;
		return $this;
	}

	public function set_orderinfo($order_info) {
		$this->order_info = $order_info;
		return $this;
	}

	public function set_shippinginfo($shipping_info) {
		$this->shipping_info = $shipping_info;
		return $this;
	}
	
	const PAYCODE_FORM     = 1;
	const PAYCODE_STRING   = 2;
	const PAYCODE_PARAM    = 3;

	/**
	 * 获取支付代码
	 * @param int $type 支付代码类型  1 => 表单, 2 => 链接, 3 => 数组
	 * @param string $args
	 * @return string
	 */
	public function get_code($type, $args = array()) {
	    $prepare_data = $this->get_prepare_data();
	    if (is_ecjia_error($prepare_data)) {
	        return $prepare_data;
	    }
	    
	    if ($type == self::PAYCODE_FORM) {
	        return $this->build_request_form($prepare_data, $args);
	    } elseif ($type == self::PAYCODE_STRING) {
	        return $this->build_request_param_toString($prepare_data);
	    } elseif ($type == self::PAYCODE_PARAM) {
	        return $this->build_request_param($prepare_data);
	    } else {
	        return ;
	    }
	}
    
    /**
     * PHP Crul库 模拟Post提交至支付宝网关
     * 如果使用Crul 你需要改一改你的php.ini文件的设置，找到php_curl.dll去掉前面的";"就行了
     * 返回 $data
     */
    public function post($url, $param) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url); // 配置网关地址
        curl_setopt($ch, CURLOPT_HEADER, 0); // 过滤HTTP头
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1); // 设置post提交
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param); // post传输数据
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    
    /**
     * 返回通知url
     * @param string $url
     */
    public function return_url($url) {
        return RC_Uri::site_url() . $url;
    }

	/**
	 * 支付服务器异步回调通知 POST方式
	 */
	abstract public function notify();

	/**
	 * 支付服务器同步回调响应 GET方式
	 */
	abstract public function response();

	/**
	 * 支付方式的预处理数据
	 * @return array
	 */
	abstract public function get_prepare_data();
	
	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $prepare_data 请求前的参数数组
	 * @return 要请求的参数数组字符串
	 */
	public function build_request_param($prepare_data) {
	    return $prepare_data;
	}
	
	/**
	 * 生成要请求给支付宝的参数字符串连接
	 * @param $prepare_data 请求前的参数数组
	 * @return 要请求的参数数组字符串
	 */
	public function build_request_param_toString($prepare_data) {	    
	    return $prepare_data['pay_online'];
	}
	
	/**
	 * 建立请求，以表单HTML形式构造（默认）
	 * @param $prepare_data 请求参数数组
	 * @param $button_args 确认按钮参数
	 * @return 提交表单HTML文本
	 */
	public function build_request_form($prepare_data, $button_args) {
	    if (strtoupper($this->configure['gateway_method']) == 'POST') {
	        $code = '<form action="' . $this->configure['gateway_url'] . '" method="POST" target="_blank">';
	    } else {
	        $code = '<form action="' . $this->configure['gateway_url'] . '" method="GET" target="_blank">';
	    }
	     
	    unset($prepare_data['pay_online']);
	     
	    foreach ($prepare_data as $key => $value) {
	        $code .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
	    }
	     
	    if (is_array($button_args) && !empty($button_args)) {
	        $button_attr = '';
	        foreach ($button_args as $key => $value) {
	            $button_attr .=  ' ' . $key . '="' . $value . '"';
	        }
	    }
	     
	    $code .= '<input type="submit"' . $button_attr . ' />';
	    $code .= '</form>';
	    return $code;
	}
	
	/**
	 * 获取外部支付使用的订单号
	 */
	public function get_out_trade_no() {
	    $app = 'ecjia.payment';
	    $group = 'paylog';
	    
	    $order_sn = $this->order_info['order_sn'];
	    $log_id = $this->order_info['log_id'];
	    $out_trade_no = $order_sn . $log_id;
	    
	    $relationship_db = RC_Model::model('goods/term_relationship_model');
	    
	    $data = array(
	    	'object_type' 	=> $app,
	        'object_group' 	=> $group,
	        'object_id' 	=> $log_id,
	        'item_key1' 	=> 'order_sn',
	        'item_value1' 	=> $order_sn,
	        'item_key2' 	=> 'out_trade_no',
	        "item_value2 	= '$out_trade_no'" ,
	    );
	    $count = $relationship_db->where($data)->count();
	    if (!$count) {
	    	$data = array(
    			'object_type' 	=> $app,
    			'object_group' 	=> $group,
    			'object_id' 	=> $log_id,
    			'item_key1' 	=> 'order_sn',
    			'item_value1' 	=> $order_sn,
    			'item_key2' 	=> 'out_trade_no',
    			'item_value2' 	=> $out_trade_no,
	    	);
	        $relationship_db->insert($data);
	    }
	    return $out_trade_no;
	}
	
	/**
	 * 解析支付使用的外部订单号
	 */
	public function parse_out_trade_no($out_trade_no) {
	    $app = 'ecjia.payment';
	    $group = 'paylog';
	    
	    if (empty($out_trade_no)) {
	        return false;
	    }
	    
	    $data = array(
	        'object_type'	=> $app,
	        'object_group'	=> $group,
	        'item_key1'		=> 'order_sn',
	        'item_key2'		=> 'out_trade_no',
	    	"item_value2 	= '$out_trade_no'" ,
	    );
	    $relationship_db = RC_Model::model('goods/term_relationship_model');
	    $item = $relationship_db->where($data)->find();
	    RC_Logger::getLogger('pay')->info($item);
	    if ($item) {
	       return array('order_sn' => $item['item_value1'], 'log_id' => $item['object_id']);
	    } 
	    return false;
	}
}

// end