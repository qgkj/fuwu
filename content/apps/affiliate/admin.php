<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 后台推荐设置
 * @author wutifang
 */
class admin extends ecjia_admin {
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
		
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 * 推荐设置
	 */
	public function init() {
		$this->admin_priv('affiliate_percent_manage');
		
		RC_Style::enqueue_style('affiliate-css', RC_App::apps_url('statics/css/affiliate.css', __FILE__));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.affiliate_percent_list'));
		
		$config = unserialize(ecjia::config('affiliate'));
		
		if (count($config['item']) < 5) {
			$this->assign('add_percent', array('href' => RC_Uri::url('affiliate/admin/add'), 'text' => RC_Lang::get('affiliate::affiliate.add_affiliate_percent')));
		}
		
		$this->assign('config', $config);
		$this->assign('form_action', RC_Uri::url('affiliate/admin/update'));
		
		$this->display('affiliate_list.dwt');
	}
	
	public function add() {
		$this->admin_priv('affiliate_percent_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.add_affiliate_percent')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.add_affiliate_percent'));
		$this->assign('action_link', array('href' =>RC_Uri::url('affiliate/admin/init'), 'text' => RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		$config = unserialize(ecjia::config('affiliate'));
		
		if (count($config['item']) >= 5) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_error'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
			
		}
		
		$this->assign('level', count($config['item'])+1);
		
		$this->assign('form_action', RC_Uri::url('affiliate/admin/insert'));
		$this->display('affiliate_info.dwt');
	}
	
	/**
	 * 增加下线分配方案
	 */
	public function insert() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		//检查输入值是否正确
		if (empty($_POST['level_point'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_point'], -1, 1) == '%') {
				$intval = substr($_POST['level_point'], 0, strlen($_POST['level_point'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_point'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($_POST['level_money'])) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['level_money'], -1, 1) == '%') {
				$intval = substr($_POST['level_money'], 0, strlen($_POST['level_money'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['level_money'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$config = unserialize(ecjia::config('affiliate'));
		//下线不能超过5层
		if (count($config['item']) < 5) {
			$_POST['level_point'] = (float)$_POST['level_point'];
			$_POST['level_money'] = (float)$_POST['level_money'];
			$maxpoint = $maxmoney = 100;
			foreach ($config['item'] as $key => $val) {
				$maxpoint -= $val['level_point'];
				$maxmoney -= $val['level_money'];
			}
			$_POST['level_point'] > $maxpoint && $_POST['level_point'] = $maxpoint;
			$_POST['level_money'] > $maxmoney && $_POST['level_money'] = $maxmoney;
// 			if (!empty($_POST['level_point']) && strpos($_POST['level_point'], '%') === false) {
				$_POST['level_point'] .= '%';
// 			}
// 			if (!empty($_POST['level_money']) && strpos($_POST['level_money'], '%') === false) {
				$_POST['level_money'] .= '%';
// 			}
			$items = array('level_point' => $_POST['level_point'], 'level_money' => $_POST['level_money']);
			$config['item'][] = $items;
			$config['on'] = 1;
			$config['config']['separate_by'] = 0;
			
			ecjia_config::instance()->write_config('affiliate', serialize($config));
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$_POST['level_point'].'，'.RC_Lang::get('affiliate::affiliate.level_money_is').$_POST['level_money'], 'add', 'affiliate');
			
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin/init')));
			
		} else {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function edit() {
		$this->admin_priv('affiliate_percent_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.update_affiliate_percent')));
		
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.update_affiliate_percent'));
		$this->assign('action_link', array('href' =>RC_Uri::url('affiliate/admin/init'), 'text' => RC_Lang::get('affiliate::affiliate.affiliate_percent_list')));
		$config = unserialize(ecjia::config('affiliate'));
		$id = $_GET['id'];
		
		$this->assign('level', $id);
		$config['item'][$id-1]['level_point'] = str_replace('%', '', $config['item'][$id-1]['level_point']);
		$config['item'][$id-1]['level_money'] = str_replace('%', '', $config['item'][$id-1]['level_money']);
		$this->assign('affiliate_percent', $config['item'][$id-1]);
		
		$this->assign('form_action', RC_Uri::url('affiliate/admin/insert'));
		$this->display('affiliate_info.dwt');
	}
	
	
	/**
	 * 修改配置
	 */
	public function update() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);

		$config = unserialize(ecjia::config('affiliate'));

		$separate_by = isset($_POST['separate_by']) ? intval($_POST['separate_by']) : $config['config']['separate_by'];
		$expire_unit = isset($_POST['expire_unit']) ? $_POST['expire_unit'] 		: $config['config']['expire_unit'];
		$invite_template	= isset($_POST['invite_template']) ? trim($_POST['invite_template']) : '';
		$invite_explain		= isset($_POST['invite_explain']) ? $_POST['invite_explain'] : '';
		
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
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 编辑积分分成百分比
	 */
	public function edit_point() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		/* 取得参数 */
		$key = trim($_POST['pk']) - 1;
		$val = (float)trim($_POST['value']);
		
		//检查输入值是否正确
		if (empty($_POST['value']) && $val != 0) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['value'], -1, 1) == '%') {
				$intval = substr($_POST['value'], 0, strlen($_POST['value'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['value'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_point_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($val)) {
			$val = 0;
		}
		$maxpoint = 100;
		foreach ($config['item'] as $k => $v) {
			if ($k != $key) {
				$maxpoint -= $v['level_point'];
			}
		}
		
		$val > $maxpoint && $val = $maxpoint;
		if (!empty($val) && strpos($val, '%') === false) {
			$val .= '%';
		}
		$config['item'][$key]['level_point'] = $val;
		$config['on'] = 1;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 编辑现金分成百分比
	 */
	public function edit_money() {
		$this->admin_priv('affiliate_percent_update', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		$key = trim($_POST['pk']) - 1;
		$val = (float)trim($_POST['value']);
		
		//检查输入值是否正确
		if (empty($_POST['value']) && $val != 0) {
			return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (substr($_POST['value'], -1, 1) == '%') {
				$intval = substr($_POST['value'], 0, strlen($_POST['value'])-1);
				if (!preg_match("/^[0-9]+$/", $intval)) {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} elseif (!preg_match("/^[0-9]+$/", $_POST['value'])) {
				return $this->showmessage(RC_Lang::get('affiliate::affiliate.level_money_wrong'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		if (empty($val)) {
			$val = 0;
		}
		$maxmoney = 100;
		foreach ($config['item'] as $k => $v) {
			if ($k != $key) {
				$maxmoney -= $v['level_money'];
			}
		}
		$val > $maxmoney && $val = $maxmoney;
		if (!empty($val) && strpos($val, '%') === false) {
			$val .= '%';
		}
		$config['item'][$key]['level_money'] = $val;
		$config['on'] = 1;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val, 'pjaxurl' => RC_Uri::url('affiliate/admin/init')));
	}
	
	/**
	 * 删除分成
	 */
	public function remove() {
		$this->admin_priv('affiliate_percent_drop', ecjia::MSGTYPE_JSON);
		
		$config = unserialize(ecjia::config('affiliate'));
		$key = trim($_GET['id']) - 1;
		$info = $config['item'][$key];
		
		unset($config['item'][$key]);
		$temp = array();
		
		if (!empty($config['item'])) {
			foreach ($config['item'] as $key => $val) {
				$temp[] = $val;
			}
		}
		
		$config['item'] = $temp;
		$config['on'] = 1;
		$config['config']['separate_by'] = 0;
		
		ecjia_config::instance()->write_config('affiliate', serialize($config));
		ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate.level_point_is').$info['level_point'].'，'.RC_Lang::get('affiliate::affiliate.level_money_is').$info['level_money'], 'remove', 'affiliate');
		
		return $this->showmessage(RC_Lang::get('affiliate::affiliate.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}	
}

//end