<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台推荐设置
 * @author wutifang
 */
class admin_config extends ecjia_admin {
	private $db_shop_config;
	public function __construct() {
		parent::__construct();
		
		$this->db_shop_config = RC_Loader::load_app_model('affiliate_shop_config_model');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 *推荐设置
	 */
	public function init() {
		$this->admin_priv('affiliate_config');
		
		RC_Style::enqueue_style('affiliate-css', RC_App::apps_url('statics/css/affiliate.css', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.affiliate_set')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.affiliate_set'));
		$this->assign('separate_config', RC_Lang::get('affiliate::affiliate.affiliate_set'));
		$this->assign('add_separate', RC_Lang::get('affiliate::affiliate.add_affiliate'));
		$this->assign('unit', RC_Lang::get('affiliate::affiliate.unit'));
		
		$config = unserialize(ecjia::config('affiliate'));

		$bonus_type_list = RC_Api::api('bonus', 'bonus_type_list', array('type' => 'allow_send'));

		$this->assign('bonus_type_list', $bonus_type_list);
		$this->assign('config', $config);
		$this->assign('invite_template', ecjia::config('invite_template'));
		$this->assign('invite_explain', ecjia::config('invite_explain'));
		$this->assign('current_code', 'affiliate');
		$this->assign('form_action', RC_Uri::url('affiliate/admin_config/update'));
		
		$this->display('affiliate_config.dwt');
	}
	
	/**
	 * 修改配置
	 */
	public function update() {
		$this->admin_priv('affiliate_config', ecjia::MSGTYPE_JSON);

		$config = unserialize(ecjia::config('affiliate'));

		$separate_by 		= isset($_POST['separate_by']) 		? intval($_POST['separate_by']) 	: $config['config']['separate_by'];
		$expire_unit 		= isset($_POST['expire_unit']) 		? $_POST['expire_unit'] 			: $config['config']['expire_unit'];
		$invite_template	= isset($_POST['invite_template']) 	? trim($_POST['invite_template']) 	: '';
		$invite_explain		= isset($_POST['invite_explain']) 	? $_POST['invite_explain'] 			: '';
		
		$_POST['expire'] 			= (float)$_POST['expire'];
		$_POST['level_point_all'] 	= (float)$_POST['level_point_all'];
		$_POST['level_money_all'] 	= (float)$_POST['level_money_all'];
		$_POST['level_money_all'] 	> 100 && $_POST['level_money_all'] = 100;
		$_POST['level_point_all'] 	> 100 && $_POST['level_point_all'] = 100;
		
		if (!empty($_POST['level_point_all']) && strpos($_POST['level_point_all'], '%') === false) {
			$_POST['level_point_all'] .= '%';
		}
		if (!empty($_POST['level_money_all']) && strpos($_POST['level_money_all'], '%') === false) {
			$_POST['level_money_all'] .= '%';
		}
		$_POST['level_register_all']			= intval($_POST['level_register_all']);
		$_POST['level_register_up']				= intval($_POST['level_register_up']);

		$temp = array();
		$temp['on'] = (intval($_POST['on']) == 1) ? 1 : 0;
		
		if ($temp['on'] == 1) {
			$temp['config'] = array(
				'expire'                		=> $_POST['expire'],             //COOKIE过期数字
				'expire_unit'           		=> $expire_unit,        		 //单位：小时、天、周
				'separate_by'           		=> $separate_by,                 //分成模式：0、注册 1、订单
				'level_point_all'       		=> $_POST['level_point_all'],    //积分分成比
				'level_money_all'       		=> $_POST['level_money_all'],    //金钱分成比
				'level_register_all'    		=> intval($_POST['level_register_all']), //推荐注册奖励积分
				'level_register_up'     		=> intval($_POST['level_register_up']),  //推荐注册奖励积分上限
			);
			
			/* 邀请人奖励*/
			$intive_reward_by	= trim($_POST['intive_reward_by']) == 'orderpay' ? 'orderpay' : 'signup';
			$intive_reward_type = trim($_POST['intive_reward_type']);
			if ($intive_reward_type == 'bonus') {
				$intive_reward_value = intval($_POST['intive_reward_type_bonus']);
			} elseif ($intive_reward_type == 'integral') {
				$intive_reward_value = intval($_POST['intive_reward_type_integral']);
			} else {
				$intive_reward_value = trim($_POST['intive_reward_type_balance']);
			}
			
			/* 受邀人奖励*/
			$intivee_reward_by	= trim($_POST['intivee_reward_by']) == 'orderpay' ? 'orderpay' : 'signup';
			$intivee_reward_type = trim($_POST['intivee_reward_type']);
			if ($intivee_reward_type == 'bonus') {
				$intivee_reward_value = intval($_POST['intivee_reward_type_bonus']);
			} elseif ($intivee_reward_type == 'integral') {
				$intivee_reward_value = intval($_POST['intivee_reward_type_integral']);
			} else {
				$intivee_reward_value = trim($_POST['intivee_reward_type_balance']);
			}
			
			$temp['intvie_reward'] = array(
				'intive_reward_by'		=> $intive_reward_by,
				'intive_reward_type'	=> $intive_reward_type,
				'intive_reward_value'	=> $intive_reward_value
			);
			
			$temp['intviee_reward'] = array(
				'intivee_reward_by'		=> $intivee_reward_by,
				'intivee_reward_type'	=> $intivee_reward_type,
				'intivee_reward_value'	=> $intivee_reward_value
			);
			
		} else {
			$temp['config'] = !empty($config['config']) ? $config['config'] : '';
		}
		
		$temp['item'] = !empty($config['item']) ? $config['item'] : array();
		
		ecjia_config::instance()->write_config('affiliate', serialize($temp));
		ecjia_config::instance()->write_config('invite_template', $invite_template);
		ecjia_config::instance()->write_config('invite_explain', $invite_explain);
		ecjia_admin::admin_log(RC_Lang::get('system::system.affiliate'), 'edit', 'config');
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin_config/init')));
	}
}

//end