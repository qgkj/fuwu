<?php
  
/**
 * 支付宝插件
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('payment_abstract', 'payment', false);

class pay_alipay extends payment_abstract
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
    
    
    public function get_prepare_data() {
        
        $charset = RC_CHARSET;
        $alipay_config = $this->configure;
        
        if ($this->is_mobile) {
            $req_id = date('Ymdhis');
            
            $pay_parameter['subject']       = ecjia::config('shop_name') . '的订单：' . $this->order_info['order_sn'];
            $pay_parameter['partner']       = $this->configure['alipay_partner'];
            $pay_parameter['order_sn']      = $this->order_info['order_sn'];
            $pay_parameter['order_logid']   = $this->order_info['log_id'];
            $pay_parameter['order_amount']  = $this->order_info['order_amount'];
            $pay_parameter['seller_id']     = $this->configure['alipay_account'];
            $pay_parameter['notify_url']    = $this->return_url('/notify/pay_alipay.php');
            $pay_parameter['callback_url']  = $this->return_url('/notify/pay_alipay.php');
            $pay_parameter['pay_order_sn']  = $this->get_out_trade_no();
            $pay_parameter['pay_code']      = $this->configure['pay_code'];
            $pay_parameter['pay_name']      = $this->configure['pay_name'];
            $pay_parameter['private_key']   = $this->configure['private_key_pkcs8'];
            
            $req_data  = '<direct_trade_create_req>';
            $req_data .= '<subject>' . $pay_parameter['subject'] . '</subject>';
            $req_data .= '<out_trade_no>' . $pay_parameter['pay_order_sn'] . '</out_trade_no>';
            $req_data .= '<total_fee>' . $pay_parameter['order_amount'] . '</total_fee>';
            $req_data .= '<seller_account_name>' . $pay_parameter['seller_id'] . '</seller_account_name>';
            $req_data .= '<notify_url>' . $pay_parameter['notify_url'] . '</notify_url>';
            $req_data .= '<out_user>' . $this->order_info['consignee'] . '</out_user>';
            $req_data .= '<merchant_url>' . $this->return_url('/notify/pay_alipay.php') . '</merchant_url>';
            $req_data .= '<call_back_url>' . $pay_parameter['callback_url'] . '</call_back_url>';
            $req_data .= '</direct_trade_create_req>';
            
            $parameter = array (
                'req_data' 			=> $req_data,
                'service' 			=> 'alipay.wap.trade.create.direct',
                'sec_id' 			=> 'MD5',
                'partner' 			=> $this->configure['alipay_partner'],
                'req_id' 			=> $req_id,
                'format' 			=>'xml',
                'v' 				=>'2.0',
                '_input_charset' 	=> trim(strtolower($charset)),
            );
            
            
            $alipay_config['sign_type'] = 'MD5';
            //建立请求
            $alipay_request = new alipay_request_wap($alipay_config);
            $html_text = $alipay_request->build_request_http($parameter);
            //urldecode返回的信息
            $html_text = urldecode($html_text);
            //解析远程模拟提交后返回的信息
            $para_html_text = $alipay_request->parse_response($html_text);
            //获取request_token
            $request_token = isset($para_html_text['request_token']) ? $para_html_text['request_token'] : '';

            $req_data  = '<auth_and_execute_req>';
            $req_data  .= '<request_token>' . $request_token . '</request_token>';
            $req_data  .= '</auth_and_execute_req>';
            
            $parameter = array (
                'service'           => 'alipay.wap.auth.authAndExecute',
                'partner'           => $this->configure['alipay_partner'],
                'sec_id'            => 'MD5',
                'format'            => 'xml',
                'v'                 => '2.0',
                'req_id'	        => $req_id,
                'req_data'          => $req_data,
                '_input_charset'	=> trim(strtolower($charset)),
            );

            $pay_parameter['pay_online'] = $alipay_request->build_request_param_toLink($parameter);
            
            return $pay_parameter;
        } else {
            $real_method = $this->configure['alipay_pay_method'];
            
            switch ($real_method){
            	case '0':
            	    $service = 'trade_create_by_buyer';
            	    break;
            	case '1':
            	    $service = 'create_partner_trade_by_buyer';
            	    break;
            	case '2':
            	    $service = 'create_direct_pay_by_user';
            	    break;
                default:
                    $service = 'trade_create_by_buyer';
            }
            
            $extend_param = 'isv^sh22';
            
            $parameter = array(
                'extend_param'      => $extend_param,
                'service'           => $service,
                'partner'           => $this->configure['alipay_partner'],
                '_input_charset'    => $charset,
                'notify_url'        => $this->return_url('/notify/pay_alipay.php'),
                'return_url'        => $this->return_url('/notify/pay_alipay.php'),
            
                /* 业务参数 */
                'subject'           => $this->order_info['order_sn'],
                'out_trade_no'      => $this->get_out_trade_no(),
                'price'             => $this->order_info['order_amount'],
                'quantity'          => 1,
                'payment_type'      => 1,
            
                /* 物流参数 */
                'logistics_type'    => 'EXPRESS',
                'logistics_fee'     => '0',
                'logistics_payment' => 'BUYER_PAY_AFTER_RECEIVE',
            
                /* 买卖双方信息 */
                'seller_email'      => $this->configure['alipay_account']
            );

            $alipay_config['sign_type'] = 'MD5';
            $alipay_request = new alipay_request_web($alipay_config);
            $button_attr = $alipay_request->build_request_param($parameter);;

            $button_attr['pay_online'] = $alipay_request->build_request_param_toLink($parameter);
            
            return $button_attr;
        }
    }
    
    
    public function notify() {
        $alipay_config = array(
            'alipay_partner'    => $this->configure['alipay_partner'],
            'alipay_key'        => $this->configure['alipay_key'],
            'input_charset'     => 'utf-8',
            'transport'         => 'http',
        );
        
        if ($_POST['service'] == 'alipay.wap.trade.create.direct') {
            $alipay_config['sign_type'] = 'MD5';
            $alipay_notify = new alipay_notify_wap($alipay_config);
        } else {
            //计算得出通知验证结果 //web mobile 区分
            if ($_POST['sign_type'] == 'RSA') {
                $alipay_config['sign_type'] = 'RSA';
                $alipay_config['private_key'] = $this->configure['private_key'];
                $alipay_notify = new alipay_notify_mobile($alipay_config);
            } else {
                $alipay_config['sign_type'] = 'MD5';
                $alipay_notify = new alipay_notify_web($alipay_config);
            }
        }

        $verify_result = $alipay_notify->verify_notify();
        //验证成功
        if ($verify_result) {
            if (isset($_POST['notify_data'])) {
                $notify_data = $alipay_notify->get_notify_data($_POST['notify_data']);
                if (!empty($notify_data)) {
                    //获取订单ID
                    $item = $this->parse_out_trade_no($notify_data['out_trade_no']);
                    $order_sn = $item['order_sn'];
                    $log_id = $item['log_id'];
                
                    $db = RC_DB::table('payment_record');
                    $db->where('order_sn', $order_sn)->where('trade_type', 'buy')->update(array('trade_no' => $notify_data['trade_no']));
                    
                    $pay_status = PS_UNPAYED;
                    if ($notify_data['trade_status'] == 'TRADE_FINISHED' || $notify_data['trade_status'] == 'TRADE_SUCCESS') {
                        $pay_status = PS_PAYED;
                    }
                
                    $result = RC_Api::api('orders', 'order_paid', array('log_id' => $log_id, 'money' => $notify_data['total_fee'], 'pay_status' => $pay_status));
                    if (is_ecjia_error($result)) {
                        return $result;
                    } else {
                        return $result;
                    }
                
                }
            } else {
                //获取订单ID
                $item = $this->parse_out_trade_no($_POST['out_trade_no']);
                $order_sn = $item['order_sn'];
                $log_id = $item['log_id'];
                
                $db = RC_DB::table('payment_record');
                $db->where('order_sn', $order_sn)->where('trade_type', 'buy')->update(array('trade_no' => $_POST['trade_no']));
                
                $pay_status = PS_UNPAYED;
                if ($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
                    $pay_status = PS_PAYED;
                }
                
                $result = RC_Api::api('orders', 'order_paid', array('log_id' => $log_id, 'money' => $_POST['total_fee'], 'pay_status' => $pay_status));
                if (is_ecjia_error($result)) {
                    return $result;
                } else {
                    return $result;
                }
            } 
        } else {
            return new ecjia_error('sign_verify_data_fail', '签名验证失败');
        }
    }
    
    public function response() {
        $alipay_config = array(
            'alipay_partner'    => $this->configure['alipay_partner'],
            'alipay_key'        => $this->configure['alipay_key'],
            'sign_type'         => 'MD5',
            'input_charset'     => 'utf-8',
            'transport'         => 'http',
        );
        //计算得出通知验证结果
        if (!empty($_GET['result'])) {
            $alipay_notify = new alipay_notify_wap($alipay_config);
            $result_status = $_GET['result']; // success 是WAP支付时返回的GET参数
        } else {
            $alipay_notify = new alipay_notify_web($alipay_config);
            $result_status = $_GET['trade_status']; // TRADE_FINISHED, TRADE_SUCCESS 是WEB支付时返回的GET参数
        }
        
        $verify_result = $alipay_notify->verify_return();
        if ($verify_result) {
            if ($result_status == 'TRADE_FINISHED' || $result_status == 'TRADE_SUCCESS' || $result_status == 'success') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

// end