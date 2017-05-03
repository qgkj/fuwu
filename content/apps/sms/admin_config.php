<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA短信模块
 * @author songqian
 */
class admin_config extends ecjia_admin {
	private $db_sms_config;

	public function __construct() {
		parent::__construct();
	
		$this->db_sms_config = RC_Model::model('sms/sms_config_model');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('sms_config', RC_App::apps_url('statics/js/sms_config.js', __FILE__), array(), false, true);
		
		RC_Script::localize_script('sms_config', 'js_lang', RC_Lang::get('sms::sms.js_lang'));
	}

	/**
	 * 短信配置页面
	 */
	public function init() {
	    $this->admin_priv('sms_config_manage');
	    
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('sms::sms.sms_config')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('sms::sms.overview'),
			'content'	=> '<p>' . RC_Lang::get('sms::sms.sms_config_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('sms::sms.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:短信配置" target="_blank">'. RC_Lang::get('sms::sms.about_sms_config') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('sms::sms.sms_config'));
		
	    $this->assign('config_user', 		 ecjia::config('sms_user_name'));//用户名
	    $this->assign('config_password',	 ecjia::config('sms_password'));//密码
	    $this->assign('config_mobile',		 ecjia::config('sms_shop_mobile'));//商家电话
    	$this->assign('config_order',		 ecjia::config('sms_order_placed'));//客户下单
    	$this->assign('config_money',		 ecjia::config('sms_order_payed'));//客户付款
    	$this->assign('config_shipping',	 ecjia::config('sms_order_shipped'));//商家发货
    	$this->assign('config_user_sign_in', ecjia::config('sms_user_signin'));//用户注册
    	$this->assign('config_sms_receipt_verification', ecjia::config('sms_receipt_verification'));//收货验证码
    	
		$this->assign('current_code', 'sms');
		$this->assign('form_action', RC_Uri::url('sms/admin_config/update'));
		
		$this->display('sms_config.dwt');
	}
		
	/**
	 * 处理短信配置
	 */
	public function update() {
		$this->admin_priv('sms_config_update', ecjia::MSGTYPE_JSON);
		
		$sms_user_name    = $_POST['sms_user_name'];
		$sms_password     = $_POST['sms_password'];
		$sms_mobile       = $_POST['sms_shop_mobile'];
		$order            = intval($_POST['config_order']);
		$money            = intval($_POST['config_money']);
		$shipping         = intval($_POST['config_shipping']);
		$user_sign_in     = $_POST['config_user'];
		$sms_receipt_verification = intval($_POST['sms_receipt_verification']);

		ecjia_config::instance()->write_config('sms_user_name',       $sms_user_name);
		ecjia_config::instance()->write_config('sms_password',        $sms_password);
		ecjia_config::instance()->write_config('sms_shop_mobile',     $sms_mobile);
		ecjia_config::instance()->write_config('sms_order_placed',    $order);
		ecjia_config::instance()->write_config('sms_order_payed',     $money);
		ecjia_config::instance()->write_config('sms_order_shipped',   $shipping);
		ecjia_config::instance()->write_config('sms_user_signin',     $user_sign_in);
		ecjia_config::instance()->write_config('sms_receipt_verification', $sms_receipt_verification);
		
		ecjia_admin::admin_log(RC_Lang::get('sms::sms.set_config'), 'setup', 'sms_config');
		return $this->showmessage(RC_Lang::get('sms::sms.update_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('sms/admin_config/init')));
	}
	
	/**
	 * 查询账户余额
	 */
	public function check_balance() {
		$this->admin_priv('auction_manage', ecjia::MSGTYPE_JSON);
		
		RC_Loader::load_app_class('sms_send', 'sms');
		$balance = sms_send::make()->check_balance();
		
		if (is_ecjia_error($balance)) {
		    return $this->showmessage($balance->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$balance_label = sprintf(RC_Lang::get('sms::sms.surplus'), "<strong>{$balance}</strong>");
		    return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $balance_label));
		}
	}
}

//end