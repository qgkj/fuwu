<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 购物流程相关语言
 */
return array(
	'flow_login_register' => array(
		'username_not_null' => '请您输入用户名。',
		'username_invalid' 	=> '您输入了一个无效的用户名。',
		'password_not_null' => '请您输入密码。',
		'email_not_null' 	=> '请您输入电子邮件。',
		'email_invalid' 	=> '您输入的电子邮件不正确。',
		'password_not_same' => '您输入的密码和确认密码不一致。',
		'password_lt_six' 	=> '密码不能小于6个字符。',
	),
		
	'regist_success' 	=> "恭喜您，%s 账号注册成功!",
	'login_success' 	=> '恭喜！您已经成功登陆本站！',
		
	/* 购物车 */
	'update_cart' 					=> '更新购物车',
	'back_to_cart' 					=> '返回购物车',
	'update_cart_notice' 			=> '购物车更新成功，请您重新选择您需要的赠品。',
	'direct_shopping' 				=> '不打算登录，直接购买',
	'goods_not_exists' 				=> '对不起，指定的商品不存在',
	'drop_goods_confirm'			=> '您确实要把该商品移出购物车吗？',
	'goods_number_not_int' 			=> '请您输入正确的商品数量。',
	'stock_insufficiency' 			=> '非常抱歉，您选择的商品 %s 的库存数量只有 %d，您最多只能购买 %d 件。',
	'package_stock_insufficiency' 	=> '非常抱歉，您选择的超值礼包数量已经超出库存。请您减少购买量或联系商家。',
	'shopping_flow' 				=> '购物流程',
	'username_exists' 				=> '您输入的用户名已存在，请换一个试试。',
	'email_exists' 					=> '您输入的电子邮件已存在，请换一个试试。',
	'surplus_not_enough' 			=> '您使用的余额不能超过您现有的余额。',
	'integral_not_enough' 			=> '您使用的积分不能超过您现有的积分。',
	'integral_too_much' 			=> "您使用的积分不能超过%d",
	'invalid_bonus' 				=> "您选择的红包并不存在。",
	'no_goods_in_cart' 				=> '您的购物车中没有商品！',
	'not_submit_order' 				=> '您参与本次团购商品的订单已提交，请勿重复操作！',
	'pay_success' 					=> '本次支付已经成功，我们将尽快为您发货。',
	'pay_fail' 						=> '本次支付失败，请及时和我们取得联系。',
	'pay_disabled' 					=> '您选用的支付方式已经被停用。',
	'pay_invalid' 					=> '您选用了一个无效的支付方式。该支付方式不存在或者已经被停用。请您立即和我们取得联系。',
	'flow_no_shipping' 				=> '您必须选定一个配送方式。',
	'flow_no_payment' 				=> '您必须选定一个支付方式。',
	'pay_not_exist' 				=> '选用的支付方式不存在。',
	'storage_short'			 		=> '库存不足',
	'subtotal' 						=> '小计',
	'accessories' 					=> '配件',
	'largess' 						=> '赠品',
	'shopping_money' 				=> '购物金额小计 %s',
	'than_market_price' 			=> '比市场价 %s 节省了 %s (%s)',
	'your_discount' 				=> '根据优惠活动<a href="activity.php"><font color=red>%s</font></a>，您可以享受折扣 %s',
	'no' 							=> '无',
	'not_support_virtual_goods' 	=> '购物车中存在非实体商品,不支持匿名购买,请登陆后在购买',
	'not_support_insure' 			=> '不支持保价',
	'clear_cart' 					=> '清空购物车',
	'drop_to_collect' 				=> '放入收藏夹',
	
	'password_js' => array(
		'show_div_text' => '请点击更新购物车按钮',
		'show_div_exit' => '关闭',
	),
	'goods_fittings' 	=> '商品相关配件',
	'parent_name' 		=> '相关商品：',
	'remark_package' 	=> '礼包',
		
	/* 优惠活动 */
	'favourable_name' 	=> '活动名称：',
	'favourable_period' => '优惠期限：',
	'favourable_range' 	=> '优惠范围：',
	
	'far_ext' => array(
		FAR_ALL 		=> '全部商品',
		FAR_BRAND 		=> '以下品牌',
		FAR_CATEGORY 	=> '以下分类',
		FAR_GOODS 		=> '以下商品',
	),
	
	'fat_ext' => array(
		FAT_DISCOUNT 	=> '享受 %d%% 的折扣',
		FAT_GOODS 		=> '从下面的赠品（特惠品）中选择 %d 个（0表示不限制数量）',
		FAT_PRICE 		=> '直接减少现金 %d',
	),
	
	'favourable_amount' => '金额区间：',
	'favourable_type' 	=> '优惠方式：',
	
	'favourable_not_exist' 		=> '您要加入购物车的优惠活动不存在',
	'favourable_not_available' 	=> '您不能享受该优惠',
	'favourable_used' 			=> '该优惠活动已加入购物车了',
	'pls_select_gift' 			=> '请选择赠品（特惠品）',
	'gift_count_exceed' 		=> '您选择的赠品（特惠品）数量超过上限了',
	'gift_in_cart' 				=> '您选择的赠品（特惠品）已经在购物车中了：%s',
	'label_favourable' 			=> '优惠活动',
	'label_collection' 			=> '我的收藏',
	'collect_to_flow' 			=> '立即购买',
		
	/* 登录注册 */
	'forthwith_login' 		=> '登录',
	'forthwith_register'	=> '注册新用户',
	'signin_failed' 		=> '对不起，登录失败，请检查您的用户名和密码是否正确',
	'gift_remainder' 		=> '说明：在您登录或注册后，请到购物车页面重新选择赠品。',
		
	/* 收货人信息 */
	'flow_js' => array(
		'consignee_not_null' 	=> '收货人姓名不能为空！',
		'country_not_null' 		=> '请您选择收货人所在国家！',
		'province_not_null' 	=> '请您选择收货人所在省份！',
		'city_not_null' 		=> '请您选择收货人所在城市！',
		'district_not_null' 	=> '请您选择收货人所在区域！',
		'invalid_email' 		=> '您输入的邮件地址不是一个合法的邮件地址。',
		'address_not_null' 		=> '收货人的详细地址不能为空！',
		'tele_not_null' 		=> '电话不能为空！',
		'shipping_not_null' 	=> '请您选择配送方式！',
		'payment_not_null' 		=> '请您选择支付方式！',
		'goodsattr_style' 		=> 1,
		'tele_invaild' 			=> '电话号码不有效的号码',
		'zip_not_num' 			=> '邮政编码只能填写数字',
		'mobile_invaild' 		=> '手机号码不是合法号码',
	),
		
	'new_consignee_address' 	=> '新收货地址',
	'consignee_address' 		=> '收货地址',
	'consignee_name' 			=> '收货人姓名',
	'country_province' 			=> '配送区域',
	'please_select' 			=> '请选择',
	'city_district' 			=> '城市/地区',
	'email_address' 			=> '电子邮件地址',
	'detailed_address' 			=> '详细地址',
	'postalcode' 				=> '邮政编码',
	'phone' 					=> '电话',
	'mobile' 					=> '手机',
	'backup_phone' 				=> '手机',
	'sign_building' 			=> '标志建筑',
	'deliver_goods_time' 		=> '最佳送货时间',
	'default' 					=> '默认',
	'default_address' 			=> '默认地址',
	'confirm_submit' 			=> '确认提交',
	'confirm_edit' 				=> '确认修改',
	'country' 					=> '国家',
	'province' 					=> '省份',
	'city' 						=> '城市',
	'area' 						=> '所在区域',
	'consignee_add' 			=> '添加新收货地址',
	'shipping_address' 			=> '配送至这个地址',
	'address_amount' 			=> '您的收货地址最多只能是三个',
	'not_fount_consignee' 		=> '对不起，您选定的收货地址不存在。',
		
	/*------------------------------------------------------ */
	//-- 订单提交
	/*------------------------------------------------------ */
	'goods_amount_not_enough' 	=> '您购买的商品没有达到本店的最低限购金额 %s ，不能提交订单。',
	'balance_not_enough' 		=> '您的余额不足以支付整个订单，请选择其他支付方式',
	'select_shipping' 			=> '您选定的配送方式为',
	'select_payment' 			=> '您选定的支付方式为',
	'order_amount' 				=> '您的应付款金额为',
	'remember_order_number' 	=> '您的订单号',
	'back_home' 				=> '<a href="index.php">返回首页</a>',
	'goto_user_center' 			=> '<a href="user.php">用户中心</a>',
	'order_submit_back' 		=> '您可以 %s 或去 %s',
	
	'order_placed_sms' 			=> "您有新订单.收货人:%s 电话:%s",
	'sms_paid' 					=> '已付款',
	
	'notice_gb_order_amount' 	=> '（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）',
	'pay_order' 				=> '支付订单 %s',
	'validate_bonus' 			=> '验证红包',
	'input_bonus_no' 			=> '或者输入红包序列号',
	'select_bonus' 				=> '选择已有红包',
	'bonus_sn_error' 			=> '该红包序列号不正确',
	'bonus_min_amount_error' 	=> '订单商品金额没有达到使用该红包的最低金额 %s',
	'bonus_is_ok' 				=> '该红包序列号可以使用，可以抵扣 %s',
	
	'shopping_myship' 			=> '我的配送',
	'shopping_activity'			=> '活动列表',
	'shopping_package' 			=> '超值礼包列表',
	
	'label_place_order'			=> '订单提交成功',
	'unpay'						=> '待付款',
	'merchant_process'			=> '等待商家接单',
	'gram'						=> '克',
	'kilogram'					=> '千克',
);

// end