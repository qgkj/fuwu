<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class goods_hooks {
    
    public static function widget_admin_dashboard_goodsstat() {
    	
    	if (!ecjia_admin::$controller->admin_priv('goods_manage', ecjia::MSGTYPE_HTML, false)) {
    		return false;	
    	}
    	
        $title = RC_Lang::get('goods::goods.goods_count_info');
        
    	$goods = RC_Cache::app_cache_get('admin_dashboard_goods', 'goods');
	    if (!$goods) {
			$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
			$time = RC_Time::gmtime();
			$fields = "SUM(IF(goods_id>0,1,0)) as total,SUM(IF(is_new=1,1,0)) as new,SUM(IF(is_best=1,1,0)) as best,SUM(IF(is_hot=1,1,0)) as hot,SUM(IF(goods_number <= warn_number,1,0)) as warn_goods,SUM(IF(promote_price>0 and promote_start_date<=".$time." and promote_end_date>=".$time.",1,0)) as promote_goods";
			$row = $db_goods ->field($fields)->where(array("is_delete"=>'0' , "is_real"=>'1'))->select();
			
			$goods['total'] 		= $row[0]['total'];
			$goods['new_goods']		= $row[0]['new'];
			$goods['new_goods_url'] = RC_Uri::url('goods/admin/init','intro_type=is_new');
			$goods['best_goods']	= $row[0]['best'];
			$goods['best_goods_url'] = RC_Uri::url('goods/admin/init','intro_type=is_best');
			$goods['hot_goods']		= $row[0]['hot'];
			$goods['hot_goods_url'] = RC_Uri::url('goods/admin/init','intro_type=is_hot');
			$goods['promote_goods'] = $row[0]['promote_goods'];
			$goods['promote_goods_url'] = RC_Uri::url('goods/admin/init','intro_type=is_promote');
			
			/* 缺货商品 */
			if (ecjia::config('use_storage')) {
				$goods['warn_goods'] = $row[0]['warn_goods'];
			} else {
				$goods['warn_goods'] = 0;
			}
			$goods['warn_goods_url'] = RC_Uri::url('goods/admin/init','stock_warning=1');
		
	    	RC_Cache::app_cache_set('admin_dashboard_goods', $goods, 'goods', 120);
	    }
		
		ecjia_admin::$controller->assign('title', $title);
		ecjia_admin::$controller->assign('goods', $goods);
		ecjia_admin::$controller->assign_lang();
		ecjia_admin::$controller->display(ecjia_app::get_app_template('library/widget_admin_dashboard_goodsstat.lbi', 'goods'));
    }
}

RC_Hook::add_action( 'admin_dashboard_left', array('goods_hooks', 'widget_admin_dashboard_goodsstat'), 20);

// end