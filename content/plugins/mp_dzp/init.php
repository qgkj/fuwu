<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_dzp_init implements platform_interface {
    
    public function action() {
        $css_url = RC_Plugin::plugins_url('css/activity-style.css', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
    	$easing_url = RC_Plugin::plugins_url('js/jquery.easing.min.js', __FILE__);
    	$Rotate_url = RC_Plugin::plugins_url('js/jQueryRotate.2.2.js', __FILE__);
    	
    	$tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/dzp_index.dwt.php';
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	
    	ecjia_front::$controller->assign('jq_url',$jq_url);
    	ecjia_front::$controller->assign('easing_url',$easing_url);
    	ecjia_front::$controller->assign('Rotate_url',$Rotate_url);
    	ecjia_front::$controller->assign('css_url',$css_url);

    	$platform_config_db = RC_Loader::load_app_model('platform_config_model','platform');
    	$wechat_prize_db = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	$wechat_prize_view_db = RC_Loader::load_app_model('wechat_prize_viewmodel','wechat');
    	
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$ext_config  = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_dzp'))->get_field('ext_config');
    	$config = array();
    	$config = unserialize($ext_config);
    	
    	foreach ($config as $k => $v) {
    		if ($v['name'] == 'starttime') {
    			$starttime = $v['value'];
    		}
    		if ($v['name'] == 'endtime') {
    			$endtime = $v['value'];
    		}
    		if ($v['name'] == 'prize_num') {
    			$prize_num = $v['value'];
    		}
    		if ($v['name'] == 'description') {
    			$description = $v['value'];
    		}
    		if ($v['name'] == 'list') {
    			$list = explode("\n",$v['value']);
    			foreach ($list as $k => $v){
    				$prize[] = explode(",",$v);
    			}
    		}
    	}
    	$countprize = count($prize);
    	$starttime = strtotime($starttime);
    	$endtime   = strtotime($endtime);
    	$count = $wechat_prize_db->where('openid = "' . $openid . '"  and wechat_id = "' . $wechat_id . '"  and activity_type = "mp_dzp" and dateline between "' . $starttime . '" and "' . $endtime . '"')->count();
    	$prize_num = ($prize_num - $count) < 0 ? 0 : $prize_num - $count;
    	$list = $wechat_prize_view_db->where('p.wechat_id = "' . $wechat_id . '" and p.prize_type = 1  and p.activity_type = "mp_dzp" and dateline between "' . $starttime . '" and "' . $endtime . '"')->order('dateline desc')->limit(10)->select();
    	
    	ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_dzp/init_action', 'openid' => $openid, 'uuid' => $uuid)));
    	
    	ecjia_front::$controller->assign('countprize',$countprize);
    	ecjia_front::$controller->assign('prize',$prize);
    	ecjia_front::$controller->assign('list',$list);
    	ecjia_front::$controller->assign('prize_num',$prize_num);
    	ecjia_front::$controller->assign('description',$description);
    	
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display($tplpath);
	}
}

// end