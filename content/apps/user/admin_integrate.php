<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 第三方程序会员数据整合插件管理程序
 */
class admin_integrate extends ecjia_admin {
	private $db_user;	
	private $integrate;
	
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('admin_user');
		
		$this->integrate = RC_Loader::load_app_class('integrate', 'user');
		$this->db_user = RC_Model::model('user/users_model');

		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('integrate_list', RC_Uri::home_url('content/apps/user/statics/js/integrate_list.js'));
		
		$integrate_jslang = array(
			'home'		=>	RC_Lang::get('user::integrate.home'),
			'last_page'	=> 	RC_Lang::get('user::integrate.last_page'),
			'previous'	=> 	RC_Lang::get('user::integrate.previous'),
			'next'		=> 	RC_Lang::get('user::integrate.next'),
		);
		RC_Script::localize_script('integrate_list', 'js_lang', RC_Lang::get('user::integrate.js_lang'));
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.member_integration'), RC_Uri::url('user/admin_integrate/init')));
	}

	/**
	 * 会员数据整合插件列表
	 */
	public function init() {
	    $this->admin_priv('integrate_users');
		
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.member_integration')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=> '<p>' . RC_Lang::get('user::users.user_integrate_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员整合" target="_blank">'.RC_Lang::get('user::users.about_user_integrate').'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('user::integrate.member_integration'));
		
		$integrate_list['ecjia'] = array(
			'format_name'           => 'ECJia',
			'code'   	            => 'ecjia',
			'format_description'   	=> 'ECJia默认会员系统',
		);
		
		$list = $this->integrate->integrate_list();
		if (is_array($list)) {
		    $integrate_list = array_merge($integrate_list, $list);
		}

		foreach ($integrate_list as &$integrate) {
		    $code = ecjia::config('integrate_code') == 'ecshop' ? 'ecjia' : ecjia::config('integrate_code');
		    if ($integrate['code'] == $code) {
		        $integrate['activate'] = 1;
		    } else {
		        $integrate['activate'] = 0;
		    }
		}
		$this->assign('integrate_list', $integrate_list);

		$this->display('integrates_list.dwt');
	}
	
	/**
	 * 设置会员数据整合插件
	 */
	public function setup() {
	    $this->admin_priv('integrate_users');
	
	    $this->assign('ur_here',      RC_Lang::get('user::integrate.integrate_setup'));
	    $this->assign('action_link',  array('text' => RC_Lang::get('user::integrate.back_integration'), 'href' => RC_Uri::url('user/admin_integrate/init')));
	    
	    $code = strval($_GET['code']);
	    
	    if ($code == 'ecshop' || $code == 'ecjia') {
	        return $this->showmessage(RC_Lang::get('user::integrate.need_not_setup'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_INFO);
	    }
	
	    $cfg = unserialize(ecjia::config('integrate_config'));
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::integrate.integrate_setup')));
	    if ($code != 'ucenter') {
	        $this->assign('set_list',     integrate::charset_list());
	        $cfg['integrate_url'] = "http://";
	    }
	    
	    $this->assign('code',         $code);
	    $this->assign('cfg',		  $cfg);
	    $this->assign('form_action',  RC_Uri::url('user/admin_integrate/save_config'));

	    $this->display('integrates_setup.dwt');
	}
	
	/**
	 * 启用会员数据整合插件
	 */
	public function activate() {
        $this->admin_priv('integrate_users', ecjia::MSGTYPE_JSON);

		$code = strval($_GET['code']);

		if ($code == 'ucenter') {
		    ecjia_config::instance()->write_config('integrate_code', 'ucenter'); 
		} elseif ($code == 'ecshop') {
			ecjia_config::instance()->write_config('integrate_code', 'ecshop');
		} elseif ($code == 'ecjia') {
		    ecjia_config::instance()->write_config('integrate_code', 'ecjia');
		} else {
		    //如果有标记，清空标记
			$data = array(
				'flag' => 0,
				'alias' => ''
			);
			RC_DB::table('users')->where('flag', '>', 0)->update($data);
			
			ecjia_config::instance()->write_config('integrate_code', $code);
		}
		ecjia_config::instance()->write_config('points_rule', '');
		
		return $this->showmessage(RC_Lang::get('user::integrate.integration_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_integrate/init')));
	}
	
	/**
	 * 保存整合填写的配置资料
	 */
	public function save_config() {
		$code = strval($_POST['code'], ecjia::MSGTYPE_JSON);

		if ($code != 'ecjia' && $code != 'ucenter' && $code != 'ecshop') {
		    return $this->showmessage(RC_Lang::get('user::integrate.support_UCenter'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
		
		$cfg = unserialize(ecjia::config('integrate_config'));
		$_POST['cfg']['quiet'] = 1;
		
		/* 合并数组，保存原值 */
		$cfg = array_merge($cfg, $_POST['cfg']);
		
		/* 直接保存修改 */
		if (integrate::save_integrate_config($code, $cfg)) {	
			return $this->showmessage(RC_Lang::get('user::integrate.save_ok'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
		} else {			
			return $this->showmessage(RC_Lang::get('user::integrate.save_error'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}
	}
}

// end