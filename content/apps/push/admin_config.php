<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息模块
 */
class admin_config extends ecjia_admin {

	private $db_mobile_manage;
	
	public function __construct() {
		parent::__construct();
	
		$this->db_mobile_manage = RC_Model::model('mobile/mobile_manage_model');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('push_config', RC_App::apps_url('statics/js/push_config.js', __FILE__), array(), false, true);
		
		RC_Script::localize_script('push_config', 'js_lang', RC_Lang::get('push::push.js_lang'));
		
		RC_Style::enqueue_style('push_event', RC_App::apps_url('statics/css/push_event.css', __FILE__), array(), false, false);
	}

	/**
	 * 消息配置页面
	 */
	public function init () {
	    $this->admin_priv('push_config_manage');
	   
		$this->assign('ur_here', RC_Lang::get('push::push.msg_config'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_config')));

    	$this->assign('config_appname',       ecjia::config('app_name'));//应用名称
    	$this->assign('config_apppush',       ecjia::config('app_push_development'));
    	
    	$this->assign('config_pushplace',     ecjia::config('push_order_placed'));//客户下单
    	$this->assign('config_pushpay',       ecjia::config('push_order_payed'));//客户付款
    	$this->assign('config_pushship',      ecjia::config('push_order_shipped'));//商家发货
    	$this->assign('config_pushsignin',    ecjia::config('push_user_signin'));//用户注册
    	
    	$mobile_manage = $this->db_mobile_manage->select();
    	
    	$push_event = RC_Model::model('push/push_event_model')->field(array('event_name', 'event_code'))->group('event_code')->where(array('is_open' => 1))->select();
    	
    	/* 客户下单*/
    	$push_order_placed_apps = ecjia::config('push_order_placed_apps');
    	
    	/* 客户付款*/
    	$push_order_payed_apps = ecjia::config('push_order_payed_apps');
    	 
    	/* 商家发货*/
    	$push_order_shipped_apps = ecjia::config('push_order_shipped_apps');
    	
    	/*配送员消息推送*/
    	$push_express_assign	= ecjia::config('push_express_assign');
    	$push_express_grab		= ecjia::config('push_express_grab');
    	$push_express_assign_event	= ecjia::config('push_express_assign_event');
    	$push_express_grab_event	= ecjia::config('push_express_grab_event');
    	
    	$this->assign('push_express_assign',	$push_express_assign);
    	$this->assign('push_express_grab',		$push_express_grab);
    	$this->assign('push_express_assign_event',	$push_express_assign_event);
    	$this->assign('push_express_grab_event', 	$push_express_grab_event);
    	
    	$this->assign('mobile_manage',     	$mobile_manage);
    	$this->assign('apps_group_order',	$push_order_placed_apps);
    	$this->assign('apps_group_payed',   $push_order_payed_apps);
    	$this->assign('apps_group_shipped', $push_order_shipped_apps);
    	
    	$this->assign('push_event' , $push_event);
    	$this->assign('current_code', 'push');
		$this->assign('form_action', RC_Uri::url('push/admin_config/update'));
		
		$this->display('push_config.dwt');
	}
		
	/**
	 * 处理消息配置
	 */
	public function update() {
		$this->admin_priv('push_config_manage', ecjia::MSGTYPE_JSON);
		
		ecjia_config::instance()->write_config('app_name',             $_POST['app_name']);
		ecjia_config::instance()->write_config('app_push_development', $_POST['app_push_development']);
		
		ecjia_config::instance()->write_config('push_order_placed',    intval($_POST['config_order']));
		ecjia_config::instance()->write_config('push_order_payed',     intval($_POST['config_money']));
		ecjia_config::instance()->write_config('push_order_shipped',   intval($_POST['config_shipping']));
		ecjia_config::instance()->write_config('push_user_signin',     intval($_POST['config_user']));
		
		/*配送员消息推送*/
		ecjia_config::instance()->write_config('push_express_assign',  intval($_POST['push_express_assign']));
		ecjia_config::instance()->write_config('push_express_grab',    intval($_POST['push_express_grab']));
		
		$push_express_assign_event = trim($_POST['push_express_assign_event']);
		ecjia_config::instance()->write_config('push_express_assign_event', $push_express_assign_event);
		$push_express_grab_event = trim($_POST['push_express_grab_event']);
		ecjia_config::instance()->write_config('push_express_grab_event', $push_express_grab_event);
		$push_order_placed_apps = trim($_POST['push_order_placed_apps']);
		ecjia_config::instance()->write_config('push_order_placed_apps', $push_order_placed_apps);
		
		$push_order_payed_apps = trim($_POST['push_order_payed_apps']);
		ecjia_config::instance()->write_config('push_order_payed_apps', $push_order_payed_apps);
		
		$push_order_shipped_apps = trim($_POST['push_order_shipped_apps']);
		ecjia_config::instance()->write_config('push_order_shipped_apps', $push_order_shipped_apps);
		
		ecjia_admin::admin_log('推送消息>消息配置', 'setup', 'config');
		return $this->showmessage(RC_Lang::get('push::push.update_config_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin_config/init')));
	}
}

//end