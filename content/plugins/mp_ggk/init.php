<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_ggk_init implements platform_interface {
    
    public function action() {
        $css_url = RC_Plugin::plugins_url('css/activity-style.css', __FILE__);
        $jq_url = RC_Plugin::plugins_url('js/jquery.min.js', __FILE__);
    	$js_url = RC_Plugin::plugins_url('js/wScratchPad.js', __FILE__);
    	ecjia_front::$controller->assign('jq_url',$jq_url);
    	ecjia_front::$controller->assign('js_url',$js_url);
    	ecjia_front::$controller->assign('css_url',$css_url);
    	
    	$bannerbg= RC_Plugin::plugins_url('images/activity-scratch-card-bannerbg.png',__FILE__);
    	ecjia_front::$controller->assign('bannerbg',$bannerbg);
    	
    	$tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/ggk_index.dwt.php';
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	$platform_config_db = RC_Loader::load_app_model('platform_config_model','platform');
    	$wechat_prize_db = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	$wechat_prize_view_db = RC_Loader::load_app_model('wechat_prize_viewmodel','wechat');
    	
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	$ext_config  = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_ggk'))->get_field('ext_config');
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
    	    	
    	$starttime = strtotime($starttime);
    	$endtime   = strtotime($endtime);
    	$count = $wechat_prize_db->where('openid = "' . $openid . '"  and wechat_id = "' . $wechat_id . '"  and activity_type = "mp_ggk" and dateline between "' . $starttime . '" and "' . $endtime . '"')->count();
    	$prize_num = ($prize_num - $count) < 0 ? 0 : $prize_num - $count;
    	$list = $wechat_prize_view_db->where('p.wechat_id = "' . $wechat_id . '" and p.prize_type = 1  and p.activity_type = "mp_ggk" and dateline between "' . $starttime . '" and "' . $endtime . '"')->order('dateline desc')->limit(10)->select();
    	 
    	
    	ecjia_front::$controller->assign('form_action',RC_Uri::url('platform/plugin/show', array('handle' => 'mp_ggk/init_action', 'openid' => $openid, 'uuid' => $uuid, 'name' => 'mp_ggk')));
    	ecjia_front::$controller->assign('prize',$prize);
    	ecjia_front::$controller->assign('list',$list);
    	ecjia_front::$controller->assign('prize_num',$prize_num);
    	ecjia_front::$controller->assign('description',$description);
    	
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display($tplpath);
	}
}

// end