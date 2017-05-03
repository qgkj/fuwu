<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 插件抽象类
 * @author royalwang
 */
abstract class shipping_abstract {

	protected $configure = array();

	/**
	 * 构造函数
	 *
	 * @param: $configure[array]    配送方式的参数的数组
	 *
	 * @return null
	 */
	public function __construct($cfg = array()) {
	    foreach ($cfg AS $key=>$val) {
	        $this->configure[$val['name']] = $val['value'];
	    }
	}
	
	/**
	 * 配送方式的配置表单信息
	 */
    public function form_format($fields, $format = false) {
	    $config = $this->configure_config();
	    $forms = array();
	    if ($config['forms']) {
	        $forms = $config['forms'];
	    }
	    
        RC_Lang::load_plugin($config['shipping_code']);
        if (empty ( $fields )) {
            $fields = $forms;
        }
        //@todo 语言包更换方法待确认
	    if ($format) {    
	        foreach ( $fields as $key => $val ) {
	            $fields [$key] ['name'] = $val ['name'];
	            $fields [$key] ['label'] = RC_Lang::lang($val['name']);
	        }
	        return $fields;
	    } else {
	        return $forms;
	    }
	}
	
	/**
	 * 获取插件配置信息
	 */
	abstract public function configure_config();

	
	/**
     * 计算订单的配送费用的函数
     *
     * @param   float   $goods_weight   商品重量
     * @param   float   $goods_amount   商品金额
     * @param   float   $goods_number   商品件数
     * @return  decimal
     */
	abstract public function calculate($goods_weight, $goods_amount, $goods_number);
	
	/**
	 * 查询发货状态
	 * 该配送方式不支持查询发货状态
	 *
	 * @access  public
	 * @param   string  $invoice_sn     发货单号
	 * @return  string
	 */
	abstract public function query($invoice_sn);

}

// end