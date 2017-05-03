<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加账单条目信息。入账订单/退货单
 * table store_bill_detail
 * @author hyy
 */
class commission_add_bill_detail_api extends Component_Event_Api {
    /*
     * 必填参数
     * order_type 1入账订单，2退货
     * order_id
     * 非必填
     * store_id
     * order_amount 金额
     */
    public function call(&$options) {
        if (!is_array($options) || !isset($options['order_type']) || !in_array($options['order_type'], array(1,2))
            || !isset($options['order_id']) ) {
            return new ecjia_error('invalid_parameter', '参数无效');
        }
        
        return RC_Model::model('commission/store_bill_detail_model')->add_bill_detail($options);
    }
}

// end