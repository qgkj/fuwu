<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    //address
    'address/add'           => 'user::address/add',
    'address/delete'        => 'user::address/delete',
    'address/info'          => 'user::address/info',
    'address/list'          => 'user::address/list',
    'address/setDefault'    => 'user::address/setDefault',
    'address/update'        => 'user::address/update',

    //article
    'article/category'      => 'api::article/category',//2.4+api(测试)
    'article/detail'        => 'article::article/detail',
	//article 1.0
    'article'				=> 'article::article/detail',

    //cart
    'cart/create'           => 'cart::cart/create',
    //'cart/gift/create'      => 'cart::cart/gift/create',//2.4+api(测试) //hyy 9.12
    'cart/delete'           => 'cart::cart/delete',
    'cart/list'             => 'cart::cart/list',
    'cart/update'           => 'cart::cart/update',
    'flow/checkOrder'       => 'cart::flow/checkOrder',
    'flow/done'             => 'cart::flow/done',

    //comments
	'comment/create'        => 'comment::goods/create',

    //feedback
    'feedback/list'         => 'feedback::feedback/list',
    'feedback/create'       => 'feedback::feedback/create',

    //goods
    'goods/category'        => 'goods::goods/category',
	'goods/list'        	=> 'goods::goods/list',
	'goods/suggestlist'     => 'goods::goods/suggestlist',
	'goods/groupbuygoods'   => 'groupbuy::groupbuygoods',
    'goods/comments'        => 'comment::goods/comments',
    'goods/detail'          => 'goods::goods/detail',
    'goods/desc'            => 'goods::goods/desc',
    'goods/brand'           => 'goods::goods/brand',
    'goods/price_range'     => 'goods::goods/price_range',
	/*商品店铺搜索*/
	'goods/search'		    	=> 'goods::goods/search',
    //goods 1.0
    'brand'					=> 'goods::goods/brand',
	'category'              => 'goods::goods/category',
	'comments'				=> 'comment::goods/comments',
	'goods'					=> 'goods::goods/detail',
	'price_range'			=> 'goods::goods/price_range',

    //home
    'home/category'         => 'goods::home/category',
    'home/data'             => 'mobile::home/data',
	'home/adsense'          => 'adsense::home/adsense',
	'home/discover'         => 'mobile::home/discover',
	'home/news'         	=> 'mobile::home/news',
	//home

    //order
    'order/affirmReceived'  => 'orders::order/affirmReceived',
    'order/cancel'          => 'orders::order/cancel',
    'order/list'            => 'orders::order/list',
    'order/pay'             => 'orders::order/pay',
    'order/detail'          => 'orders::order/detail',
    'order/update'          => 'orders::order/update',
    'order/express'         => 'orders::order/express',

    //shop
    'shop/config'           => 'setting::shop/config',
    'shop/server'           => 'setting::shop/server',
    'shop/region'           => 'setting::shop/region',
    'shop/payment'          => 'payment::shop/payment',
    'shop/help'             => 'article::shop/help',
    'shop/help/detail'      => 'article::shop/help/detail',


    //user
    'user/collect/create'   => 'user::user/collect/create',
    'user/collect/delete'   => 'user::user/collect/delete',
    'user/collect/list'     => 'user::user/collect/list',
    'user/info'             => 'user::user/info',
    'user/signin'           => 'user::user/signin',
	'user/signout'          => 'user::user/signout',
    'user/signup'           => 'user::user/signup',
	'user/update'           => 'user::user/update',
    'user/password'         => 'user::user/password',
    'user/signupFields'     => 'user::user/signupFields',
    'user/account/record'   => 'user::user/account/record',
    'user/account/log'      => 'user::user/account/log',
    'user/account/deposit'  => 'user::user/account/deposit',
    'user/account/pay'      => 'user::user/account/pay',
    'user/account/raply'    => 'user::user/account/raply',
    'user/account/cancel'   => 'user::user/account/cancel',
    'validate/bonus'        => 'user::validate/bonus',
    'validate/integral'     => 'user::validate/integral',

	'user/connect/signin'	=> 'user::user/connect/signin',
	'user/connect/signup'	=> 'user::user/connect/signup',

    //coupon
    'bonus/coupon'          => 'bonus::bonus/coupon',
    'receive/coupon'        => 'bonus::bonus/receive_coupon',

	//多商铺
	'seller/category'              => 'store::seller/category',
	'seller/list'                  => 'store::seller/list',
	'seller/search'                => 'store::seller/search',
	'seller/collect/list'          => 'store::seller/collect/list',
	'seller/collect/create'        => 'store::seller/collect/create',
	'seller/collect/delete'	       => 'store::seller/collect/delete',
	'merchant/config'              => 'store::merchant/config',
	'merchant/home/data'           => 'store::merchant/home/data',
	'merchant/goods/category'      => 'store::merchant/goods/category',
	'merchant/goods/list'          => 'store::merchant/goods/list',
	'merchant/goods/suggestlist'   => 'store::merchant/goods/suggestlist',

	//手机注册
	'user/userbind'     	=> 'user::user/userbind',
	'validate/bind'         => 'user::validate/bind',
	//第三方登录
	'user/snsbind'           => 'user::user/snsbind',

	//ecjia
	'admin/orders/list'			=> 'orders::admin/orders/list',
	'admin/orders/detail'		=> 'orders::admin/orders/detail',
	'admin/orders/cancel'		=> 'orders::admin/orders/cancel',


	'admin/goods/list'			=> 'goods::admin/goods/list',
	'admin/goods/detail'		=> 'goods::admin/goods/detail',
	'admin/goods/togglesale'	=> 'goods::admin/goods/togglesale',
	'admin/goods/trash'			=> 'goods::admin/goods/trash',
	'admin/goods/desc'			=> 'goods::admin/goods/desc',
	'admin/goods/product_search' => 'goods::admin/goods/product_search',


	'admin/user/signin'			=> 'user::v2/admin/user/signin',
    'admin/user/signout'		=> 'user::admin/user/signout',
    'admin/user/search' 		=> 'user::admin/user/search',
	'admin/user/userinfo'		=> 'user::v2/admin/user/userinfo',
	'admin/user/forget_request'	=> 'user::v2/admin/user/forget_request',
	'admin/user/forget_validate' => 'user::v2/admin/user/forget_validate',
	'admin/user/password' 		=> 'user::admin/user/password',

	'admin/home/data'			=> 'mobile::admin/home/data',
	'admin/shop/config'			=> 'setting::admin/shop/config',

	'admin/goods/category'		=> 'goods::admin/goods/category',
	'admin/goods/updatePrice'	=> 'goods::admin/goods/updateprice',
	'admin/merchant/info'		=> 'store::admin/merchant/info',
	'admin/merchant/update'		=> 'store::admin/merchant/update',
	//mobile
	'device/setDeviceToken' => 'mobile::device/setDeviceToken',


	'admin/connect/validate'	=> 'connect::admin/connect/validate',
	'admin/connect/signin'		=> 'connect::admin/connect/signin',

	'admin/flow/checkOrder'		=> 'cart::admin/flow/checkOrder',
	'admin/flow/done'			=> 'cart::admin/flow/done',
	'admin/goods/product_search' => 'goods::admin/goods/product_search',

	'admin/stats/orders'		=> 'orders::admin/stats/orders',
	'admin/stats/sales'			=> 'orders::admin/stats/sales',
	'admin/stats/sales_details'	=> 'orders::admin/stats/salesdetails',
	'admin/stats/visitor'		=> 'user::admin/stats/visitor',
	'admin/stats/order_sales'	=> 'orders::admin/stats/order_sales',


	'admin/order/split'			=> 'orders::admin/orders/split',
	'admin/order/receive'		=> 'orders::admin/orders/receive',
	'admin/order/update'		=> 'orders::admin/orders/update',



	'admin/order/payConfirm'	=> 'orders::admin/orders/payConfirm',	//收银台支付验证
	'admin/order/refundConfirm'	=> 'orders::admin/orders/refundConfirm',	//收银台退款验证
	'admin/order/check'			=> 'orders::admin/orders/check',	//收银台验单


	/* 消息*/
	'admin/message'				=> 'mobile::admin/message',

	'shop/token'           		=> 'setting::shop/token',

	'user/forget_password'      => 'user::user/forget_password',
	'validate/forget_password'  => 'user::validate/forget_password',
	'user/reset_password'       => 'user::user/reset_password',

	'goods/mobilebuygoods'		=> 'goods::goods/mobilebuygoods',

	'seller/home/data'			=> 'seller::home/data',


	//专题功能
	'topic/list'				=> 'topic::topic/list',
	'topic/info'				=> 'topic::topic/info',
	//扫码登录
	'mobile/qrcode/create'				=> 'mobile::qrcode/create',
	'mobile/qrcode/bind'				=> 'mobile::qrcode/bind',
	'mobile/qrcode/validate'			=> 'mobile::qrcode/validate',

	//后台咨询功能
	'admin/feedback/list'				=> 'feedback::admin/feedback/list',
	'admin/feedback/messages'			=> 'feedback::admin/feedback/messages',
	'admin/feedback/reply'				=> 'feedback::admin/feedback/reply',

	'goods/filter'          => 'goods::goods/filter',

	'order/comment'			=> 'comment::goods/detail',

	/* 入驻申请*/

	'admin/merchant/signup'			=> 'store::admin/merchant/signup',
	'admin/merchant/process'		=> 'store::admin/merchant/process',
	'admin/merchant/account/info' 	=> 'store::admin/account/info',
	'admin/merchant/account/validate'=>'store::admin/account/validate',
	'admin/merchant/validate'		=> 'store::admin/merchant/validate',


	/*掌柜1.1*/
	'admin/user/rank'           => 'user::admin/user/rank',
	'admin/favourable/list'		=> 'favourable::admin/favourable/list',
	'admin/favourable/add'		=> 'favourable::admin/favourable/manage',
	'admin/favourable/update'	=> 'favourable::admin/favourable/manage',
	'admin/favourable/info'		=> 'favourable::admin/favourable/info',
	'admin/favourable/delete'	=> 'favourable::admin/favourable/delete',
	'admin/goods/brand'			=> 'goods::admin/goods/brand',

	'admin/promotion/list'		=> 'promotion::admin/promotion/list',
	'admin/promotion/detail'	=> 'promotion::admin/promotion/detail',
	'admin/promotion/delete'	=> 'promotion::admin/promotion/delete',
	'admin/promotion/add'	    => 'promotion::admin/promotion/manage',
	'admin/promotion/update'	=> 'promotion::admin/promotion/manage',


	'mobile/checkin'			=> 'mobile::checkin/integral',
	'mobile/checkin/record'		=> 'mobile::checkin/record',

    'mobile/toutiao'		    => 'mobile::mobile/toutiao',

	/* o2o1.2*/
	'invite/user'				=> 'affiliate::invite/user',
	'invite/reward'				=> 'affiliate::invite/reward',
	'invite/record'				=> 'affiliate::invite/record',
	'invite/validate'			=> 'affiliate::invite/validate',

	'connect/signin'			=> 'connect::connect/signin',
	'connect/signup'			=> 'connect::connect/signup',
	'connect/bind'				=> 'connect::connect/bind',

	'shop/info'             	=> 'article::shop/info',
	'shop/info/detail'			=> 'article::shop/info/detail',

	'user/bonus'             	=> 'user::user/bonus',

	'device/setDeviceinfo' 	    => 'mobile::device/setDeviceinfo',

	//新增
	'merchant/goods/category'	=> 'store::merchant/goods/category',

	'goods/seller/list'			=> 'goods::seller/list',

    'cart/checked'              => 'cart::cart/checked', //购物车选中状态切换

    'admin/merchant/cancel'     => 'store::admin/merchant/cancel', //入驻撤销

    'admin/merchant/resignup'   => 'store::admin/merchant/resignup', //入驻修改信息提交

	'admin/merchant/preaudit'	=> 'store::admin/merchant/preaudit', //入驻修改获取信息
	
	/* o2o1.3*/
	'express/grab_list'			=> 'express::express/grab_list',
	'express/list'				=> 'express::express/list',
	'express/detail'			=> 'express::express/detail',
	'express/user/location'		=> 'express::express/user/location',
	'express/user/info'			=> 'express::express/user/info',
	'express/pickup'			=> 'express::express/pickup',
	'express/grab'				=> 'express::express/grab',
		
	'express/basicinfo'			=> 'express::express/basicinfo',
	'admin/user/update'			=> 'user::v2/admin/user/update',
	
	'admin/orders/delivery'		=> 'orders::admin/orders/delivery',
	'admin/user/account/validate'	=> 'user::admin/user/account/validate',
	'admin/user/account/update'	=> 'user::admin/user/account/update',

	'express/user/checkin'		=> 'express::express/user/checkin',
	'admin/merchant/notification'	=> 'notification::admin/merchant/notification',
	'admin/merchant/notification/read'	=> 'notification::admin/merchant/read',
);

// end
