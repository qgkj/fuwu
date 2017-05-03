<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_touch_api 
{
   
	//==============================================
	// 商店配置
	//==============================================
    const SHOP_CONFIG      = 'shop/config';//商店配置
	const SHOP_TOKEN       = 'shop/token';//获取token信息
	const SHOP_PAYMENT     = 'shop/payment'; //支付方式
	const SHOP_REGION      = 'shop/region';//地区
	const SHOP_HELP	       = 'shop/help';//商店帮助分类列表
	const SHOP_INFO	       = 'shop/info';//网店信息
	const SHOP_HELP_DETAIL = 'shop/help/detail';//商店帮助内容
	const SHOP_INFO_DETAIL = 'shop/info/detail';//网店信息内容
	const SHOP_SERVER      = 'shop/server';//服务器环境信息
    
    //==============================================
    // 首页
    //==============================================
    const HOME_CATEGORY    = 'home/category';//HOME分类
    const HOME_DATA 	   = 'home/data';//HOME数据
    const HOME_ADSENSE     = 'home/adsense';//HOME广告
    const HOME_DISCOVER    = 'home/discover';//discover数据
    const HOME_NEWS 	   = 'home/news';//今日热点数据
    
    //==============================================
    // 收货地址
    //==============================================
    const ADDRESS_ADD        = 'address/add'; // 添加地址
    const ADDRESS_DELETE     = 'address/delete'; // 删除地址
    const ADDRESS_INFO       = 'address/info'; // 单条地址信息
    const ADDRESS_LIST       = 'address/list'; // 所有地址列表
    const ADDRESS_UPDATE     = 'address/update'; // 更新单条地址信息
    const ADDRESS_SETDEFAULT = 'address/setDefault'; // 设置默认地址
    
    //==============================================
    // 红包模块
    //==============================================
 	const BONUS_VALIDATE 	= 'bonus/validate';//红包获取验证
 	const BONUS_BIDN		= 'bonus/bind';//红包兑换
 	const BONUS_COUPON 		= 'bonus/coupon';//获取优惠红包列表信息O2O
 	const RECEIVE_COUPON 	= 'receive/coupon';//领取商品或店铺优惠券
 	const SEND_COUPON 		= 'send/coupon';//获取优惠券
 	
 	//==============================================
 	// 购物车
 	//==============================================
 	const CART_CREATE 		= 'cart/create'; //添加到购物车	
 	const CART_DELETE		= 'cart/delete'; //从购物车中删除商品
 	const CART_LIST			= 'cart/list';//购物车列表
 	const CART_UPDATE		= 'cart/update';//购物车更新商品数目
 	const CART_CHECKED		= 'cart/checked';//购物车更新选中状态
 	const FLOW_CHECKORDER 	= 'flow/checkOrder';//购物流检查订单
 	const FLOW_DONE			= 'flow/done';//购物流完成
 	
 	//==============================================
 	// 商品
 	//==============================================
 	const GOODS_CATEGORY 	= 'goods/category';//所有分类
 	const GOODS_COMMENTS 	= 'goods/comments';//某商品的所有评论
 	const GOODS_SELLER_LIST	= 'goods/seller/list';//店铺分类列表
 	const GOODS_SUGGESTLIST	= 'goods/suggestlist';//商品推荐列表
 	const GOODS_DETAIL		= 'goods/detail';//单个商品的信息
 	const GOODS_DESC		= 'goods/desc';//单个商品的详情
 	const GOODS_FILTER		= 'goods/filter';//某一分类的属性列表
 	
 	//==============================================
 	// 订单
 	//==============================================
 	const ORDER_AFFIRMRECEIVED = 'order/affirmReceived';//订单确认收货
 	const ORDER_CANCEL	       = 'order/cancel';//订单取消
 	const ORDER_LIST	       = 'order/list';//订单列表
 	const ORDER_PAY		       = 'order/pay';//订单支付
 	const ORDER_DETAIL	       = 'order/detail';//订单详情
 	const ORDER_REMINDER       = 'order/reminder'; //提醒卖家发货
 	const ORDER_UPDATE	       = 'order/update';//订单更新
 	const ORDER_EXPRESS        = 'order/express';//订单快递
 	
 	//==============================================
 	// 用户
 	//==============================================
 	const USER_COLLECT_CREATE = 'user/collect/create';//用户收藏商品
 	const USER_COLLECT_DELETE = 'user/collect/delete';//用户删除收藏商品
 	const USER_COLLECT_LIST   = 'user/collect/list';//用户收藏列表
 	
 	const USER_INFO		= 'user/info';//用户信息
 	const USER_UPDATE   = 'user/update';//用户图片上传或修改
 	const USER_ACCOUNT_RECORD = 'user/account/record';//用户充值提现记录
 	const USER_ACCOUNT_LOG    = 'user/account/log';//用户账户资金变更日志/测试
 	const USER_ACCOUNT_DEPOSIT= 'user/account/deposit';//用户充值申请
 	const USER_ACCOUNT_PAY    = 'user/account/pay';//用户充值付款
 	const USER_ACCOUNT_RAPLY  = 'user/account/raply';//用户提现申请
 	const USER_ACCOUNT_CANCEL = 'user/account/cancel';//用户申请取消
 	const USER_ACCOUNT_UPDATE = 'user/account/update';//修改会员账户信息
 	const USER_BONUS          = 'user/bonus';//会员红包列表
 	const VALIDATE_BIND       = 'validate/bind';//验证用户绑定注册
 	const VALIDATE_BONUS      = 'validate/bonus';//验证红包
 	const VALIDATE_INTEGRAL   = 'validate/integral';//验证积分
 	const VALIDATE_ACCOUNT    = 'validate/account';//验证用户账户信息
 	const VALIDATE_SIGNIN     = 'validate/signin'; //用户手机验证码登录
 	const VALIDATE_FORGET_PASSWORD = 'validate/forget_password';//用户找回密码验证
 	
 	const USER_SIGNIN	           = 'user/signin';//用户登录
 	const USER_SIGNOUT	           = 'user/signout';//用户退出
 	const USER_SIGNUP 	           = 'user/signup';//用户注册
 	const USER_FORGET_PASSWORD     = 'user/forget_password'; //用户找回密码
 	const USER_RESET_PASSWORD      = 'user/reset_password';//用户找回密码重置密码
 	const USER_PASSWORD       = 'user/password';//修改登录密码
 	const USER_SNSBIND        = 'user/snsbind';//第三方登录
 	const USER_SEND_PWDMAIL   = 'user/send_pwdmail';//邮箱找回密码/测试
 	const USER_SIGNUPFIELDS   = 'user/signupFields';//用户注册字段
 	const USER_USERBIND       = 'user/userbind';//手机快速注册
 	
 	//==============================================
 	// 推广
 	//==============================================
 	const INVITE_USER         = 'invite/user';//推荐用户信息
 	const INVITE_REWARD       = 'invite/reward';//获取我所推荐的统计
 	const INVITE_RECORD       = 'invite/record';//奖励记录
 	const INVITE_VALIDATE     = 'invite/validate';//邀请码

 	//==============================================
 	// 关联
 	//==============================================
 	const CONNECT_SIGNIN = 'connect/signin';//第三方关联登录
 	const CONNECT_SIGNUP = 'connect/signup';//第三方关联注册
 	const CONNECT_BIND   = 'connect/bind';//第三方关联绑定
 	
 	
 	//==============================================
 	// 店铺街
 	//==============================================
 	const SELLER_CATEGORY = 'seller/category'; //店铺分类
 	const SELLER_LIST     = 'seller/list';//店铺列表
 	const SELLER_SEARCH   = 'seller/search';//店铺搜索
 	const SELLER_COLLECT_LIST   = 'seller/collect/list';//收藏店铺列表
 	const SELLER_COLLECT_CREATE = 'seller/collect/create';//收藏店铺
 	const SELLER_COLLECT_DELETE = 'seller/collect/delete';//删除店铺收藏
 	const MERCHANT_HOME_DATA         = 'merchant/home/data';//商店基本信息
 	const MERCHANT_GOODS_CATEGORY    = 'merchant/goods/category';//商店分类
 	const MERCHANT_GOODS_LIST 		 = 'merchant/goods/list';//商店商品
 	const MERCHANT_GOODS_SUGGESTLIST = 'merchant/goods/suggestlist';//商店推荐商品
}

// end