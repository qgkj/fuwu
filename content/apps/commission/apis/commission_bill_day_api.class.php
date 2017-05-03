<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加账单 日统计信息
 * table store_bill_day
 * 计算某一天的bill_detail 数据，入账订单-退货订单（默认前一天）
 * @author hyy
 */
class commission_bill_day_api extends Component_Event_Api {
    /*
     * $options store_id 15 选填
     * $options day '2016-10-10' 选填
     * 默认所有商店前一天数据统计
     */
    public function call(&$options) {
        return RC_Model::model('commission/store_bill_day_model')->add_bill_day($options);
    }
}

// end