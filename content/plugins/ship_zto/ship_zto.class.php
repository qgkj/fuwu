<?php
  

/**
 * 中通速递插件
 */

defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('shipping_abstract', 'shipping', false);

class ship_zto extends shipping_abstract
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
            @$fee = $this->configure['base_fee'];
            $this->configure['fee_compute_mode'] = !empty($this->configure['fee_compute_mode']) ? $this->configure['fee_compute_mode'] : 'by_weight';

            if ($this->configure['fee_compute_mode'] == 'by_number')
            {
                $fee = $goods_number * $this->configure['item_fee'];
            }
            else
            {
                if ($goods_weight > 1)
                {
                    $fee += (ceil(($goods_weight - 1))) * $this->configure['step_fee'];
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
        $str = '<form style="margin:0px" methods="post" '.
            'action="http://www.zto.cn/bill.asp" name="queryForm_' .$invoice_sn. '" target="_blank">'.
            '<input type="hidden" name="ID" value="' .str_replace("<br>","\n",$invoice_sn). '" />'.
            '<a href="javascript:document.forms[\'queryForm_' .$invoice_sn. '\'].submit();">' .$invoice_sn. '</a>'.
            '<input type="hidden" name="imageField.x" value="26" />'.
            '<input type="hidden" name="imageField.x" value="43" />'.
            '</form>';

        return $str;
    }

    /**
     * 计算保价费用
     * 保价费不低于100元，保价金额不得高于10000元，保价金额超过10000元的，超过的部分无效
     * @access  public
     * @param   int     $goods_amount       保价费用
     * @param   int     $insure             保价比例
     *
     * @return void
     */
    public function calculate_insure ($goods_amount, $insure)
    {
        if ($goods_amount > 10000)
        {
            $goods_amount = 10000;
        }

        $fee = $goods_amount * $insure;

        if ($fee < 100)
        {
            $fee = 100;
        }

        return $fee;
    }

}

// end