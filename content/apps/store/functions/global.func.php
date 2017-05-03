<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
* 添加管理员记录日志操作对象
*/
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('store_commission','佣金结算');
	ecjia_admin_log::instance()->add_object('store_commission_status','佣金结算状态');

	ecjia_admin_log::instance()->add_object('merchants_step', '申请流程');
	ecjia_admin_log::instance()->add_object('merchants_step_title', '申请流程信息');
	ecjia_admin_log::instance()->add_object('merchants_step_custom', '自定义字段');

	ecjia_admin_log::instance()->add_object('seller', '入驻商');
	ecjia_admin_log::instance()->add_object('merchants_brand', '商家品牌');
	ecjia_admin_log::instance()->add_object('store_category', '店铺分类');
	ecjia_admin_log::instance()->add_object('merchant_notice', '商家公告');

	ecjia_admin_log::instance()->add_object('config', '配置');
	ecjia_admin_log::instance()->add_object('store_percent', '佣金比例');
	ecjia_admin_log::instance()->add_object('store_mobileconfig', '店铺街配置');
}

/**
* 设置页面菜单
*/
function set_store_menu($store_id, $key){

    $keys = array('preview','store_set','commission_set','commission','view_staff','view_log','check_log');
//     if(!in_array($key,$keys)){
//         $key = 'preview';
//     }
    $arr = array(
        array(
            'menu'  => '基本信息',
            'name'  => 'preview',
            'url'   => RC_Uri::url('store/admin/preview', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '店铺设置',
            'name'  => 'store_set',
            'url'   => RC_Uri::url('store/admin/store_set', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '资质认证',
            'name'  => 'auth',
            'url'   => RC_Uri::url('store/admin/auth', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '佣金设置',
            'name'  => 'commission_set',
            'url'   => RC_Uri::url('store/admin_commission/edit', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '结算账单',
            'name'  => 'bill',
            'url'   => RC_Uri::url('commission/admin/init', array('store_id' => $store_id, 'refer' => 'store'))
        ),
        array(
            'menu'  => '查看员工',
            'name'  => 'view_staff',
            'url'   => RC_Uri::url('store/admin/view_staff', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '配送方式',
            'name'  => 'shipping',
            'url'   => RC_Uri::url('store/admin/shipping', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '查看日志',
            'name'  => 'view_log',
            'url'   => RC_Uri::url('store/admin/view_log', array('store_id' => $store_id))
        ),
        array(
            'menu'  => '审核日志',
            'name'  => 'check_log',
            'url'   => RC_Uri::url('store/admin/check_log', array('store_id' => $store_id))
        ),
    );
    foreach($arr as $k => $val){
        if($key == $val['name']){
            $arr[$k]['active']  = 1;
            $arr[$k]['url']     = "#tab".($k+1);
        }
    }
    return $arr;
}

//审核日志
function get_check_log ($store_id, $type, $page = 1, $page_size = 10) {
     
    $db_log = RC_DB::table('store_check_log')->where('store_id', $store_id)->where('type', $type);
    $count  = $db_log->count();
    $page   = new ecjia_page($count, $page_size, 5);
    $log_rs = $db_log->orderBy('id', 'desc')->take($page->page_size)->skip($page->start_id-1)->get();
     
    if (empty($log_rs)) {
        return false;
    }
    foreach ($log_rs as &$val) {
        $val['log']     = null;
        $new_data       = unserialize($val['new_data']);
        $original_data  = unserialize($val['original_data']);
        if ($original_data) {
            foreach ($original_data as $key => $original_data) {
                if (in_array($key, array('identity_pic_front', 'identity_pic_back', 'personhand_identity_pic', 'business_licence_pic'))) {
                    // 	                    $val['log'] .= '<br><code>'.$original_data['name'] . '</code>，旧图为<a href="'. $original_data['value'].'" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'. $original_data['value'].'"/></a>，新图为<a href="'. $new_data[$key]['value'].'" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'.$new_data[$key]['value'].'"/></a>；';
                    $val['log'][$key] = array(
                        'name'          => $original_data['name'],
                        'original_data' => '<a href="'. $original_data['value'].'" title="点击查看大图" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'. $original_data['value'].'"/></a>',
                        'new_data'      => '<a href="'. $new_data[$key]['value'].'" title="点击查看大图" target="_blank"><img class="w120 h70 thumbnail ecjiaf-ib" src="'.$new_data[$key]['value'].'"/></a>',
                        'is_img'        => 1
                    );
                } else {
                    // 	                    $val['log'] .= '<br><code>'.$original_data['name'] . '</code>，旧值为<code>'. $original_data['value'].'</code>，新值为<code>'.$new_data[$key]['value'].'</code>；';
                    $val['log'][$key] = array(
                        'name'          => $original_data['name'],
                        'original_data' => $original_data['value'],
                        'new_data'      => $new_data[$key]['value'],
                    );
                }
                 
            }
        }
        $val['formate_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['time']);
    }
    // 	    _dump($log_rs,1);
    return array('list' => $log_rs, 'page' => $page->show(2), 'desc' => $page->page_desc());
     
}

//end
