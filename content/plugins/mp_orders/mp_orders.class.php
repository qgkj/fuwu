<?php
  
/**
 * 订单查询
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_orders extends platform_abstract
{    

	/**
	 * 获取插件配置信息
	 */
	public function local_config() {
		$config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
		if (is_array($config)) {
			return $config;
		}
		return array();
	}
	
    public function event_reply() {

    	$wechatuser_db = RC_Loader::load_app_model('wechat_user_model','wechat');
    	$orders_db = RC_Loader::load_app_model('order_info_model','orders');
    	RC_Loader::load_app_func('admin_order','orders');
    	
    	$openid = $this->from_username;
    	$uid  = $wechatuser_db->where(array('openid' => $openid))->get_field('ect_uid');//获取绑定用户会员id
    	$nobd = "还未绑定，需<a href = '".RC_Uri::url('platform/plugin/show', array('handle' => 'mp_userbind/bind_init', 'openid' => $openid, 'uuid' => $_GET['uuid']))."'>点击此处</a>进行绑定";
    	if(empty($uid)) {
    		$content = array(
				'ToUserName' => $this->from_username,
				'FromUserName' => $this->to_username,
				'CreateTime' => SYS_TIME,
				'MsgType' => 'text',
				'Content' => $nobd
			);
    	} else {
    		$order_id  = $orders_db->where(array('user_id' => $uid))->order('add_time desc')->get_field('order_id');//获取会员当前订单
    		
    		if (!empty($order_id)) {
    			$order	= order_info($order_id);//取得订单信息
    			$order_goods = order_goods($order_id);//去的订单商品简单信息
    			$goods = '';
    			if(!empty($order_goods)){
    				foreach($order_goods as $key=>$val){
    					$goods .= $val['goods_name'].'('.$val['goods_attr'].')('.$val['goods_number'].'), ';
    				}
    			}
    			// 	作何操作0,未确认, 1已确认; 2已取消; 3无效; 4退货
    			if ($order['order_status'] ==1) {
    				$order_status = '未确认';
    			} elseif($order['order_status'] ==2){
    				$order_status = '未确认';
    			} elseif ($order['order_status'] ==3) {
    				$order_status = '未确认';
    			} elseif ($order['order_status'] ==4) {
    				$order_status = '退货';
    			} else {
    				$order_status = '未确认';
    			}
    			 
    			 
    			//发货状态; 0未发货; 1已发货  2已取消  3备货中
    			if ($order['shipping_status'] ==1) {
    				$shipping_status = '已发货';
    			} elseif($order['shipping_status'] ==2){
    				$shipping_status = '已取消';
    			} elseif ($order['shipping_status'] ==3) {
    				$shipping_status = '备货中';
    			} else {
    				$shipping_status = '未发货';
    			}
    			 
    			//支付状态 0未付款;  1已付款中;  2已付款
    			if ($order['pay_status'] ==1) {
    				$pay_status = '已付款中';
    			} elseif($order['pay_status'] ==2){
    				$pay_status = '已付款';
    			} else {
    				$pay_status = '未付款';
    			}
    			 
    			$articles = array();
    			$articles[0]['Title'] = '订单号：'.$order['order_sn'];
    			$articles[0]['PicUrl'] = '';
    			$articles[0]['Description'] = '商品信息：'. $goods ."\r\n". '总金额：'. $order['total_fee'] ."\r\n". '订单状态：'. $order_status . $shipping_status . $pay_status ."\r\n". '快递公司：'. $order['shipping_name'] ."\r\n". '物流单号：' . $order['invoice_no'];
    			$home_url =  RC_Uri::home_url();
    			if (strpos($home_url, 'sites')) {
    				$url = substr($home_url, 0, strpos($home_url, 'sites'));
    				$articles[0]['Url'] = $url.'sites/m/index.php?m=user&c=user_order&a=order_detail&order_id='.$order_id;
    			} else {
    				$articles[0]['Url'] = $home_url.'/sites/m/index.php?m=user&c=user_order&a=order_detail&order_id='.$order_id;
    			}

    			$count = count($articles);
    			$content = array(
    					'ToUserName'    => $this->from_username,
    					'FromUserName'  => $this->to_username,
    					'CreateTime'    => SYS_TIME,
    					'MsgType'       => 'news',
    					'ArticleCount'	=> $count,
    					'Articles'		=> $articles
    			);
    		} else {
    			$content = array(
    				'ToUserName'    => $this->from_username,
    				'FromUserName'  => $this->to_username,
    				'CreateTime'    => SYS_TIME,
    				'MsgType'       => 'text',
    				'Content'		=> '您当前还未产生任何订单'
    			);
    		}
    	}
    	
    	
        return $content;
    }
    
}

// end