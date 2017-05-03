<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class done_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
		/**
         * bonus 0 //红包
         * how_oos 0 //缺货处理
         * integral 0 //积分
         * payment 3 //支付方式
         * postscript //订单留言
         * shipping 3 //配送方式
         * surplus 0 //余额
         * inv_type 4 //发票类型
         * inv_payee 发票抬头
         * inv_content 发票内容
         */
    	
    	$this->authSession();
    	$rec_id = $this->requestData('rec_id');
    	if (isset($_SESSION['cart_id'])) {
    		$rec_id = empty($rec_id) ? $_SESSION['cart_id'] : $rec_id;
    	}
    	$cart_id = array();
    	if (!empty($rec_id)) {
    		$cart_id = explode(',', $rec_id);
    	}
    	
    	$location		= $this->requestData('location',array());
    	//TODO:目前强制坐标
//     	$location = array(
//     	    'latitude'	=> '31.235450744628906',
//     	    'longitude' => '121.41641998291016',
//     	);
    	/* 取得购物类型 */
    	$flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
    	
    	/* 获取收货信息*/
    	$address_id = $this->requestData('address_id', 0);
    	
    	$order = array(
    		'shipping_id'   => $this->requestData('shipping_id' ,0),
    		'pay_id'        => $this->requestData('pay_id' ,0),
    		'pack_id'     	=> $this->requestData('pack', 0),
    		'card_id'    	=> $this->requestData('card', 0),
    		'card_message'  => trim($this->requestData('card_message')),
    		'surplus'   	=> $this->requestData('surplus', 0.00),
    		'integral'     	=> $this->requestData('integral', 0),
    		'bonus_id'     	=> $this->requestData('bonus', 0),
    		'need_inv'     	=> $this->requestData('need_inv', 0),
    		'inv_type'     	=> $this->requestData('inv_type', ''),
    		'inv_payee'    	=> $this->requestData('inv_payee', ''),
    		'inv_content'   => $this->requestData('inv_content', ''),
    		'postscript'    => $this->requestData('postscript', ''),
    		'need_insure'   => $this->requestData('need_insure', 0),
    		'user_id'      	=> $_SESSION['user_id'],
    		'add_time'     	=> RC_Time::gmtime(),
    			
    		'order_status'  	=> OS_UNCONFIRMED,
    		'shipping_status' 	=> SS_UNSHIPPED,
    		'pay_status'    	=> PS_UNPAYED,	
//     		'agency_id' => get_agency_by_regions(array(
//     			$consignee['country'],
//     			$consignee['province'],
//     			$consignee['city'],
//     			$consignee['district']
//     		))
    		'agency_id'		=> 0,
    		'expect_shipping_time' =>  $this->requestData('expect_shipping_time', ''),
    	);
    	
    	$result = RC_Api::api('cart', 'flow_done', array('cart_id' => $cart_id, 'order' => $order, 'address_id' => $address_id, 'flow_type' => $flow_type, 'bonus_sn' => $this->requestData('bonus_sn'), 'location' => $location, 'device' => $this->device));
    	
    	return $result;
    }
}

// end