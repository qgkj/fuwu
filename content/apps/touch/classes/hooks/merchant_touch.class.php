<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_touch_hooks {
   
   public static function goods_merchant_priview_handler($goods_id)
   {
       $url = RC_Uri::url('goods/index/show', array('goods_id' => $goods_id));
       $url = str_replace(RC_Uri::site_url(), RC_Uri::home_url().'/sites/m', $url) ;
       ecjia_admin::$controller->redirect($url);
   }
}

RC_Hook::add_action( 'goods_merchant_priview_handler', array('merchant_touch_hooks', 'goods_merchant_priview_handler') );

// end