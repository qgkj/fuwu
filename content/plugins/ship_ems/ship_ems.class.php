<?php
  

/**
 * EMS插件
 */

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 邮政快递包裹费用计算方式
 * ====================================================================================
 * 500g及500g以内                             20元
 * -------------------------------------------------------------------------------------
 * 续重每500克或其零数                        6元/9元/15元(按分区不同收费不同，具体分区方式，请寄件人拨打电话或到当地邮局营业窗口咨询，客服电话11185。)
 * -------------------------------------------------------------------------------------
 *
 */

RC_Loader::load_app_class('shipping_abstract', 'shipping', false);

class ship_ems extends shipping_abstract
{
    /**
     * 获取插件配置信息
     */
    public function configure_config() {
        $config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
        if (is_array($config)) {
            return $config;
        }
        return array();
    }

    /**
     * 计算订单的配送费用的函数
     *
     * @param   float   $goods_weight   商品重量
     * @param   float   $goods_amount   商品金额
     * @param   float   $goods_number   商品件数
     * @return  decimal
     */
    public function calculate($goods_weight, $goods_amount, $goods_number)
    {
        if ($this->configure['free_money'] > 0 && $goods_amount >= $this->configure['free_money'])
        {
            return 0;
        }
        else
        {
            $fee = $this->configure['base_fee'];
            $this->configure['fee_compute_mode'] = !empty($this->configure['fee_compute_mode']) ? $this->configure['fee_compute_mode'] : 'by_weight';

            if ($this->configure['fee_compute_mode'] == 'by_number')
            {
                $fee = $goods_number * $this->configure['item_fee'];
            }
            else
            {
                if ($goods_weight > 0.5)
                {
                    $fee += (ceil(($goods_weight - 0.5) / 0.5)) * $this->configure['step_fee'];
                }
            }
            return $fee;
        }
    }

    /**
     * 查询发货状态
     *
     * @access  public
     * @param   string  $invoice_sn     发货单号
     * @return  string
     */
    public function query($invoice_sn)
    {
        $str = '<form style="margin:0px" method="post" '.
            'action="http://www.ems.com.cn/qcgzOutQueryAction.do" name="queryForm_' .$invoice_sn. '" target="_blank">'.
            '<input type="hidden" name="mailNum" value="' .$invoice_sn. '" />'.
            '<a href="javascript:document.forms[\'queryForm_' .$invoice_sn. '\'].submit();">' .$invoice_sn. '</a>'.
            '<input type="hidden" name="reqCode" value="browseBASE" />'.
            '<input type="hidden" name="checknum" value="0568792906411" />'.
            '</form>';

        return $str;
    }
}

// end