<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 账单计算类
 */
class store_bill {
    /**
     * 计算店铺日账单
     * 默认计算所有店铺前一天的账单，可传参数指定店铺和日期
     * @param number $options store_id
     * @param string $options day 2016-05-11
     */
    public function bill_day($options) {
//         TODO:大数据
        if (!isset($options['day'])) {
            $options['day'] = RC_Time::local_date('Y-m-d', RC_Time::gmtime() - 86400) ;
        }
        RC_Logger::getLogger('bill_day')->error($options);
        
        //已有账单数据
        $data = RC_Model::model('commission/store_bill_detail_model')->count_bill_day($options);
        
//         TODO:异常重新发起
        if (! $data) {
            RC_Logger::getLogger('bill_day')->error('统计数据异常或者为空');
            return false;
        }
        return RC_DB::table('store_bill_day')->insert($data);
    }
    
    /**
     * 计算店铺月账单
     * 默认计算所有店铺前一月的账单，可传参数指定店铺和日期
     * @param number $options store_id
     * @param string $options month 2016-05
     */
    public function bill_month($options) {
        if (!isset($options['month'])) {
            $options['month'] = RC_Time::local_date('Y-m', RC_Time::gmtime() - 86400) ;
        }
        
        RC_Logger::getLogger('bill_month')->info($options);
        
        //已有账单数据
        $data = RC_Model::model('commission/store_bill_day_model')->count_bill_month($options);
        //         TODO:异常重新发起
        if (! $data) {
            RC_Logger::getLogger('bill_month')->error('统计数据异常或者为空');
            return false;
        }
        //201603 000015 236
        foreach ($data as &$bill) {
            $bill['bill_sn'] = str_replace('-', '', $options['month']).sprintf("%06d",$bill['store_id']).mt_rand(111, 999);
            $bill['add_time'] = RC_Time::gmtime();
        }
        return RC_DB::table('store_bill')->insert($data);
    }
}

// end