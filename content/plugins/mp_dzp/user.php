<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_dzp_user implements platform_interface {
    
    public function action() {
    	$css_url = RC_Plugin::plugins_url('css/bootstrap.min.css', __FILE__);
    	$js_url = RC_Plugin::plugins_url('js/bootstrap.min.js', __FILE__);
    	$jq_url = RC_Plugin::plugins_url('js/jquery.js', __FILE__);
        ecjia_front::$controller->assign('css_url',$css_url);
        ecjia_front::$controller->assign('js_url',$js_url);
        ecjia_front::$controller->assign('jq_url',$jq_url);
    	$tplpath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/dzp_user_info.dwt.php';
    	$dzppath = RC_Plugin::plugin_dir_path(__FILE__) . 'templates/dzp_index.dwt.php';
    	$wechat_prize_db = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);
    	
    	if (!empty($_GET['id'])) {
    		$id = trim($_GET['id']);
    		$rs = $wechat_prize_db->where(array('openid' => $openid,'id' => $id))->get_field('winner');
    		if (!empty($rs)) {
    			ecjia_front::$controller->showmessage('已经领取', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		ecjia_front::$controller->assign('id',$id);
    		ecjia_front::$controller->assign_lang();
       		ecjia_front::$controller->display($tplpath);
    	}
    	
    	if ($_POST) {
    		$id = trim($_POST['id']);
    		$data = $_POST['data'];
    		if (empty($id)) {
    			ecjia_front::$controller->showmessage('请选择中奖的奖品', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		if (empty($data['name'])) {
    			ecjia_front::$controller->showmessage('请填写姓名', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		if (empty($data['phone'])) {
    			ecjia_front::$controller->showmessage('请填写手机号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		if (empty($data['address'])) {
    			ecjia_front::$controller->showmessage('请填写详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$winner['winner'] = serialize($data);
    		$wechat_prize_db->where(array('id' => $id))->update($winner);
    		ecjia_front::$controller->showmessage('资料提交成功，请等待发放奖品,可以继续去参加大转盘赢得丰厚礼品哦', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('platform/plugin/show', array('handle' => 'mp_dzp/init', 'openid' => $openid, 'uuid' => $uuid))));
    	}       
	}
}

// end