<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 订单列表接口
 * @author
 */
class orders_order_list_api extends Component_Event_Api {
    /**
     * 查看订单列表
     * @param array $options
     * @return  array
     */
    public function call (&$options) {
        if (!is_array($options) || !isset($options['type'])) {
            return new ecjia_error('invalid_parameter', RC_Lang::get('orders::order.invalid_parameter'));
        }

        $user_id = $_SESSION['user_id'];
        $type = !empty($options['type']) ? $options['type'] : '';

        $size = $options['size'];
        $page = $options['page'];


        $orders = $this->user_orders_list($user_id, $type, $page, $size);

        return $orders;
    }

    /**
     *  获取用户指定范围的订单列表
     *
     * @access  public
     * @param   int         $user_id        用户ID号
     * @param   int         $num            列表最大数量
     * @param   int         $start          列表起始位置
     * @return  array       $order_list     订单列表
     */
    private function user_orders_list($user_id, $type = '', $page = 1, $size = 15) {
        /**
         * await_pay 待付款
         * await_ship 待发货
         * shipped 待收货
         * finished 已完成
         */
        $dbview_order_info = RC_Model::model('orders/order_info_viewmodel');
        $dbview_order_info->view = array(
            'order_goods' => array(
                'type'  =>    Component_Model_View::TYPE_LEFT_JOIN,
                'alias'    =>    'og',
                'on'    =>    'oi.order_id = og.order_id ',
            ),
            'goods' => array(
                'type'         => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'g',
                'on'         => 'og.goods_id = g.goods_id'
            ),
            
            'store_franchisee' => array(
                'type'         => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'     => 'ssi',
                'on'         => 'oi.store_id = ssi.store_id'
            ),
        );

        RC_Loader::load_app_class('order_list', 'orders', false);
        $where = array('oi.user_id' => $user_id, 'oi.is_delete' => 0);

        if (!empty($type)) {
            $order_type = 'order_'.$type;
            $where = array_merge($where, order_list::$order_type('oi.'));
        }

        $record_count = $dbview_order_info->join(null)->where($where)->count('*');
        //实例化分页
        $page_row = new ecjia_page($record_count, $size, 6, '', $page);

        $order_group = $dbview_order_info->join(null)->field('oi.order_id')->where($where)->order(array('oi.add_time' => 'desc'))->limit($page_row->limit())->select();
        if (empty($order_group)) {
            return array('order_list' => array(), 'page' => $page_row);
        } else {
            foreach ($order_group as $val) {
                $where['oi.order_id'][] = $val['order_id'];
            }
        }

        $field = 'oi.order_id, oi.order_sn, oi.order_status, oi.shipping_status, oi.pay_status, oi.add_time, (oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee + oi.tax - oi.integral_money - oi.bonus - oi.discount) AS total_fee, oi.discount, oi.integral_money, oi.bonus, oi.shipping_fee, oi.pay_id, oi.order_amount'.
        ', og.goods_id, og.goods_name, og.goods_attr, og.goods_price, og.goods_number, og.goods_price * og.goods_number AS subtotal, g.goods_thumb, g.original_img, g.goods_img, ssi.store_id, ssi.merchants_name, ssi.manage_mode';
        $res = $dbview_order_info->join(array('order_goods', 'goods', 'store_franchisee'))->field($field)->where($where)->order(array('oi.order_id' => 'desc'))->select();
        RC_Lang::load('orders/order');

        /* 取得订单列表 */
        $orders = array();
        if (!empty($res)) {
            $order_id = $goods_number = $goods_type_number = 0;
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            foreach ($res as $row) {
                $attr = array();
                if (isset($row['goods_attr']) && !empty($row['goods_attr'])) {
                    $goods_attr = explode("\n", $row['goods_attr']);
                    $goods_attr = array_filter($goods_attr);
                    foreach ($goods_attr as  $val) {
                        $a = explode(':',$val);
                        if (!empty($a[0]) && !empty($a[1])) {
                            $attr[] = array('name' => $a[0], 'value' => $a[1]);
                        }
                    }
                }
                if ($order_id == 0 || $row['order_id'] != $order_id ) {
                    $goods_number = $goods_type_number = 0;
                    if ($row['pay_id'] > 0) {
                        $payment = $payment_method->payment_info_by_id($row['pay_id']);
                    }
                    $goods_type_number ++;
                    $subject = $row['goods_name'].RC_Lang::get('orders::order.etc').$goods_type_number.RC_Lang::get('orders::order.kind_of_goods');
                    $goods_number += isset($row['goods_number']) ? $row['goods_number'] : 0;


                    if (in_array($row['order_status'], array(OS_CONFIRMED, OS_SPLITED)) &&
                        in_array($row['shipping_status'], array(SS_RECEIVED)) &&
                        in_array($row['pay_status'], array(PS_PAYED, PS_PAYING)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.cs.'.CS_FINISHED);
                        $status_code = 'finished';
                    }
                    elseif (in_array($row['shipping_status'], array(SS_SHIPPED)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_confirm');
                        $status_code = 'shipped';
                    }
                    elseif (in_array($row['order_status'], array(OS_CONFIRMED, OS_SPLITED, OS_UNCONFIRMED)) &&
                            in_array($row['pay_status'], array(PS_UNPAYED)) &&
                            (in_array($row['shipping_status'], array(SS_SHIPPED, SS_RECEIVED)) || !$payment['is_cod']))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_pay');
                        $status_code = 'await_pay';
                    }
                    elseif (in_array($row['order_status'], array(OS_UNCONFIRMED, OS_CONFIRMED, OS_SPLITED, OS_SPLITING_PART)) &&
                        in_array($row['shipping_status'], array(SS_UNSHIPPED, SS_PREPARING, SS_SHIPPED_ING)) &&
                        (in_array($row['pay_status'], array(PS_PAYED, PS_PAYING)) || $payment['is_cod']))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_await_ship');
                        $status_code = 'await_ship';
                    }
               		elseif (in_array($row['order_status'], array(OS_SPLITING_PART)) &&
                        in_array($row['shipping_status'], array(SS_SHIPPED_PART)))
                    {
                        $label_order_status = RC_Lang::get('orders::order.label_shipped_part');
                        $status_code = 'shipped_part';
                    }
                    elseif (in_array($row['order_status'], array(OS_CANCELED))) {
                        $label_order_status = RC_Lang::get('orders::order.label_canceled');
                        $status_code = 'canceled';
                    }

                    $orders[$row['order_id']] = array(
                        'seller_id'             => !empty($row['store_id']) ? intval($row['store_id']) : 0,
                        'seller_name'           => !empty($row['merchants_name']) ? $row['merchants_name'] : RC_Lang::get('orders::order.self_support'),
                        'manage_mode'           => $row['manage_mode'],
                        'order_id'              => $row['order_id'],
                        'order_sn'              => $row['order_sn'],
                        'order_status'          => $row['order_status'],
                        'shipping_status'       => $row['shipping_status'],
                        'pay_status'            => $row['pay_status'],
                        'label_order_status'    => $label_order_status,
                        'order_status_code'     => $status_code,
                        'order_time'            => RC_Time::local_date(ecjia::config('time_format'), $row['add_time']),
                        'total_fee'             => $row['total_fee'],
                        'discount'              => $row['discount'],
                        'goods_number'          => $goods_number,
                        'is_cod'                => $payment['is_cod'],
                        'formated_total_fee'    => price_format($row['total_fee'], false),
                        'formated_integral_money'=> price_format($row['integral_money'], false),
                        'formated_bonus'        => price_format($row['bonus'], false),
                        'formated_shipping_fee' => price_format($row['shipping_fee'], false),
                        'formated_discount'     => price_format($row['discount'], false),
                        'order_info'            => array(
                            'pay_code'          => isset($payment['pay_code']) ? $payment['pay_code'] : '',
                            'order_amount'      => $row['order_amount'],
                            'order_id'          => $row['order_id'],
                            'subject'           => $subject,
                            'desc'              => $subject,
                            'order_sn'          => $row['order_sn'],
                        ),
                        'goods_list' => array()
                    );

                    if (!empty($row['goods_id'])) {
                        $orders[$row['order_id']]['goods_list']    = array(
                            array(
                                'goods_id'              => isset($row['goods_id'])? $row['goods_id'] : 0,
                                'name'                  => isset($row['goods_name'])? $row['goods_name']: '',
                                'goods_attr'            => empty($attr)? '' : $attr,
                                'goods_number'          => isset($row['goods_number'])? $row['goods_number']: 0,
                                'subtotal'              => isset($row['subtotal'])? price_format($row['subtotal'], false): 0,
                                'formated_shop_price'   => isset($row['goods_price']) ? price_format($row['goods_price'], false) : 0,
                                'img' => array(
                                    'small' => (isset($row['goods_thumb']) && !empty($row['goods_thumb']))       ? RC_Upload::upload_url($row['goods_thumb'])     : '',
                                    'thumb' => (isset($row['goods_img']) && !empty($row['goods_img']))           ? RC_Upload::upload_url($row['goods_img'])         : '',
                                    'url'   => (isset($row['original_img']) && !empty($row['original_img']))     ? RC_Upload::upload_url($row['original_img'])     : '',
                                ),
                                'is_commented'    => 0,
                            )
                        );
                    }


                    $order_id = $row['order_id'];
                } else {
                    $goods_number += isset($row['goods_number']) ? $row['goods_number'] : 0;
                    $orders[$row['order_id']]['goods_number'] = $goods_number;
                    $goods_type_number ++;
                    $subject = $row['goods_name'].RC_Lang::get('orders::order.etc').$goods_type_number.RC_Lang::get('orders::order.kind_of_goods');
                    $orders[$row['order_id']]['order_info']['subject']    = $subject;
                    $orders[$row['order_id']]['order_info']['desc']        = $subject;
                    $orders[$row['order_id']]['goods_list'][] = array(
                        'goods_id'          => isset($row['goods_id'])? $row['goods_id'] : 0,
                        'name'              => isset($row['goods_name'])? $row['goods_name'] : '',
                        'goods_attr'        => empty($attr) ? '' : $attr,
                        'goods_number'      => isset($row['goods_number']) ? $row['goods_number'] : 0,
                        'subtotal'          => isset($row['subtotal'])? price_format($row['subtotal'], false) : 0,
                        'formated_shop_price' => isset($row['goods_price']) ? price_format($row['goods_price'], false)     : 0,
                        'img' => array(
                            'small'         => (isset($row['goods_thumb']) && !empty($row['goods_thumb']))       ? RC_Upload::upload_url($row['goods_thumb'])     : '',
                            'thumb'         => (isset($row['goods_img']) && !empty($row['goods_img']))           ? RC_Upload::upload_url($row['goods_img'])         : '',
                            'url'           => (isset($row['original_img']) && !empty($row['original_img']))     ? RC_Upload::upload_url($row['original_img'])     : '',
                        ),
                        'is_commented'    => empty($row['relation_id']) ? 0 : 1,
                    );

                }
            }
        }
        $orders = array_merge($orders);

        return array('order_list' => $orders, 'page' => $page_row);
    }
}

// end