<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA自定义菜单
 */
class admin_menus extends ecjia_admin {
	private $db_menu;
	private $db_platform_account;

	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_menu = RC_Loader::load_app_model('wechat_menu_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);

		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('wechat_menus', RC_App::apps_url('statics/js/wechat_menus.js', __FILE__), array(), false, true);
		
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') );
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		
		RC_Script::localize_script('wechat_menus', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu'), RC_Uri::url('wechat/admin_menus/init')));
	}

	/**
	 * 微信菜单页面
	 */
	public function init() {
		$this->admin_priv('wechat_menus_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.wechat_menu_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.add_wechat_menu'), 'href'=> RC_Uri::url('wechat/admin_menus/add')));
	
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E8.87.AA.E5.AE.9A.E4.B9.89.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$listdb = $this->get_menuslist();
			$this->assign('listdb', $listdb);
		}
		
		$this->assign_lang();
		$this->display('wechat_menus_list.dwt');
	}
	
	/**
	 * 添加菜单页面
	 */
	public function add() {
		$this->admin_priv('wechat_menus_add');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_wechat_menu'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));

		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_add_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E6.B7.BB.E5.8A.A0.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_add_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$pmenu = $this->db_menu->where(array('pid' => 0, 'wechat_id' => $wechat_id))->select();
			$this->assign('pmenu', $pmenu);
			
			$wechatmenus['type'] 	= 'click';
			$wechatmenus['status'] 	= 0;
			$this->assign('wechatmenus', $wechatmenus);
			$this->assign('form_action', RC_Uri::url('wechat/admin_menus/insert'));
		}
		
		$this->assign_lang();
		$this->display('wechat_menus_edit.dwt');
	}
	
	/**
	 * 添加菜单处理
	 */
	public function insert() {
		$this->admin_priv('wechat_menus_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$pid	= !empty($_POST['pid'])		? intval($_POST['pid']) : 0	;
		$name 	= !empty($_POST['name']) 	? trim($_POST['name']) 	: '';
		$type 	= !empty($_POST['type']) 	? $_POST['type'] 		: '';
		$key	= !empty($_POST['key']) 	? $_POST['key'] 		: '';
		$url 	= !empty($_POST['url']) 	? $_POST['url'] 		: '';
		$status = !empty($_POST['status']) 	? $_POST['status'] 		: '';
		$sort 	= !empty($_POST['sort']) 	? $_POST['sort'] 		: '';
		
		$data = array(
			'wechat_id'	=> $wechat_id,
			'pid'		=>	$pid,
		    'name'		=>	$name,
		    'type'		=>	$type,
			'key'		=>	$key,
			'url'		=>	$url,
			'status'	=>	$status,
			'sort'		=>	$sort
		);
		
		if($type == 'click'){
			$data['url']='';
		}elseif ($type == 'view') {
			$data['key']='';
		}
		
		$id = $this->db_menu->insert($data);
		ecjia_admin::admin_log($_POST['name'], 'add', 'menu');
		
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑菜单页面
	 */
	public function edit() {
		$this->admin_priv('wechat_menus_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_wechat_menu')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_wechat_menu'));
		$this->assign('action_link', array('href' => RC_Uri::url('wechat/admin_menus/init'), 'text' => RC_Lang::get('wechat::wechat.wechat_menu_list')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=> '<p>' . RC_Lang::get('wechat::wechat.wechat_menu_edit_content') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:自定义菜单#.E7.BC.96.E8.BE.91.E5.BE.AE.E4.BF.A1.E8.8F.9C.E5.8D.95" target="_blank">'.RC_Lang::get('wechat::wechat.wechat_menu_edit_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
		$this->assign('type', $type);
		$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_subscribe_nonsupport'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));

	    $id = intval($_GET['id']);
	  	$wechatmenus = $this->db_menu->find(array('id' => $id));
		$this->assign('wechatmenus', $wechatmenus);
		$where['pid'] = 0;
		$where[] = "id <> $id";
		$where['wechat_id'] = $wechat_id;
		$pmenu = $this->db_menu->where($where)->select();
		
		$this->assign('pmenu', $pmenu);
		$child = $this->db_menu->where(array('id' => $id))->get_field('pid');
		$this->assign('child', $child);
		$this->assign('form_action', RC_Uri::url('wechat/admin_menus/update'));
	
		$this->assign_lang();
		$this->display('wechat_menus_edit.dwt');
	}
	
	/**
	 * 编辑菜单处理
	 */
	public function update() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$pid	= !empty($_POST['pid'])		? intval($_POST['pid']) : 0;
		$name 	= !empty($_POST['name']) 	? trim($_POST['name']) 	: '';
		$type 	= !empty($_POST['type']) 	? $_POST['type'] 		: '';
		$key	= !empty($_POST['key']) 	? $_POST['key'] 		: '';
		$url 	= !empty($_POST['url']) 	? $_POST['url'] 		: '';
		$status = !empty($_POST['status']) 	? $_POST['status'] 		: '';
		$sort 	= !empty($_POST['sort']) 	? $_POST['sort'] 		: '';
		$menu_id = !empty($_POST['menu_id']) ? intval($_POST['menu_id']) : 0;
		
		$data = array(
			'pid'		=>	$pid,
			'name'		=>	$name,
			'type'		=>	$type,
			'key'		=>	$key,
			'url'		=>	$url,
			'status'	=>	$status,
			'sort'		=>	$sort
		);
		if ($type == 'click'){
			$data['url']='';
		} elseif ($type == 'view') {
			$data['key']='';
		}
		
		$this->db_menu->where(array('id' => $menu_id))->update($data);
		
		ecjia_admin::admin_log($name, 'edit', 'menu');
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/edit', array('id' => $menu_id))));
	}
	
	
	/**
	 * 生成自定义菜单
	 */
	public function sys_menu() {
		$this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$list = $this->db_menu->where(array('status' => 1, 'wechat_id' => $wechat_id))->order('sort asc')->select();
			if (empty($list)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.check_menu_status'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$data = array();
			if (is_array($list)) {
				foreach ($list as $val) {
					if ($val['pid'] == 0) {
						$sub_button = array();
						foreach ($list as $v) {
							if ($v['pid'] == $val['id']) {
								$sub_button[] = $v;
							}
						}
						$val['sub_button'] = $sub_button;
						$data[] = $val;
					}
				}
			}
			
			$menu = array();
			foreach ($data as $key => $val) {
				if (empty($val['sub_button'])) {
					$menu['button'][$key]['type'] = $val['type'];
					$menu['button'][$key]['name'] = $val['name'];
					if ('click' == $val['type']) {
						$menu['button'][$key]['key'] = $val['key'];
					} else {
						$menu['button'][$key]['url'] = $this->html_out($val['url']);
					}
				} else {
					$menu['button'][$key]['name'] = $val['name'];
					foreach ($val['sub_button'] as $k => $v) {
						$menu['button'][$key]['sub_button'][$k]['type'] = $v['type'];
						$menu['button'][$key]['sub_button'][$k]['name'] = $v['name'];
						if ('click' == $v['type']) {
							$menu['button'][$key]['sub_button'][$k]['key'] = $v['key'];
						} else {
							$menu['button'][$key]['sub_button'][$k]['url'] = $this->html_out($v['url']);
						}
					}
				}
			}
			
			$uuid = platform_account::getCurrentUUID('wechat');
			$wechat = wechat_method::wechat_instance($uuid);
			$rs = $wechat->setMenu($menu);
			
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.make_menu'), 'setup', 'menu');
				return $this->showmessage(RC_Lang::get('wechat::wechat.make_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	
	/**
	 * 获取自定义菜单
	 */
	public function get_menu() {
		$this->admin_priv('wechat_menus_manage', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$wechat = wechat_method::wechat_instance($uuid);
			$list = $wechat->getMenu();
			if (RC_Error::is_error($list)) {
				return $this->showmessage(wechat_method::wechat_error($list->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				$info = $this->db_menu->select();
				if ($info) {
					$this->db_menu->where(array('wechat_id' => $wechat_id))->delete();
				}
					
				foreach ($list['menu']['button'] as $key => $value) {
					$value['type'] = isset($value['type']) ? $value['type'] : '';
					$value['url'] = isset($value['url']) ? $value['url'] : '';
					$value['key'] = isset($value['key']) ? $value['key'] : '';

					if ($value['type'] == 'view') {
						$array = array('name' => $value['name'], 'status' => 1, 'type' => 'view', 'url' => $value['url'], 'wechat_id' => $wechat_id);
					} else {
						$array = array('name' => $value['name'], 'status' => 1, 'type' => 'click', 'key' => $value['key'], 'wechat_id'=> $wechat_id);
					}
					$id = $this->db_menu->insert($array);
					if ($value['sub_button']) {
						$data = array();
						foreach ($value['sub_button'] as $k => $v) {
							$v['name']   = isset($v['name']) ? $v['name'] : '';
							$v['type']   = isset($v['type']) ? $v['type'] : '';
							$v['url']    = isset($v['url'])  ? $v['url']  : '';
							$v['key']    = isset($v['key'])  ? $v['key']  : '';
							
							$data['wechat_id']   = $wechat_id;
							$data['name']        = $v['name'];
							$data['type']        = $v['type'];
							$data['url']         = $v['url'];
							$data['key']         = $v['key'];
							$data['status']      = 1;
							$data['pid']         = $id;
							$this->db_menu->insert($data);
						}
					}
				}
				ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.get_menu'), 'setup', 'menu');
				return $this->showmessage(RC_Lang::get('wechat::wechat.get_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/init')));
			}
		}
	}
	
	/**
	 * 删除自定义菜单
	 */
	public function delete_menu() {
		$this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else { 
			$wechat = wechat_method::wechat_instance($uuid);
			$rs = $wechat->deleteMenu();
			
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				ecjia_admin::admin_log(RC_Lang::get('wechat::wechat.clear_menu'), 'setup', 'menu');
				$this->db_menu->where(array('id' => array('gt' => 0), 'wechat_id'=>$wechat_id))->update(array('status' => 0));
				return $this->showmessage(RC_Lang::get('wechat::wechat.clear_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_menus/init')));
			}
		}
	}
	
	/**
	 * 删除菜单
	 */
	public function remove()  {
		$this->admin_priv('wechat_menus_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$name = $this->db_menu->where(array('id' =>$id))->get_field('name');
		$field='id, pid';
		$minfo = $this->db_menu->field($field)->find(array('id' =>$id));
		
		if ($minfo['pid'] == 0) {
			$this->db_menu->where(array('pid' =>$minfo['id']))->delete();
		}
		$this->db_menu->where(array('id' => $id))->delete();

		ecjia_admin::admin_log($name, 'remove', 'menu');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_menu_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
		
	/**
	 * 手动排序
	 */
	public function edit_sort() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
		
		$id    = intval($_POST['pk']);
		$sort  = trim($_POST['value']);
		$name = $this->db_menu->where(array('id' => $id))->get_field('name');
		if (!empty($sort)) {
			if (!is_numeric($sort)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.sort_numeric'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} else {
				if ($this->db_menu->where(array('id' => $id))->update(array('sort' => $sort))) {
					ecjia_admin::admin_log($name, 'edit', 'menu');
					return $this->showmessage(RC_Lang::get('wechat::wechat.edit_sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_menus/init')) );
				}
			}
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.menu_sort_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 切换是否显示
	 */
	public function toggle_show() {
		$this->admin_priv('wechat_menus_update', ecjia::MSGTYPE_JSON);
	
		$id     = intval($_POST['id']);
		$val    = intval($_POST['val']);
		$this->db_menu->where(array('id' => $id))->update(array('status' => $val));
	
		return $this->showmessage(RC_Lang::get('wechat::wechat.switch_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('wechat/admin_menus/init')));
	}
	
	/**
	 * 取得菜单信息
	 */
	private function get_menuslist() {
		$db_menu = RC_Loader::load_app_model('wechat_menu_model');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$list = $db_menu->order('sort asc')->where(array('wechat_id' => $wechat_id))->select();
		$result = array();
		
		if (!empty($list)) {
			foreach ($list as $vo) {
				if ($vo['pid'] == 0) {
					$vo['val'] = ($vo['type'] == 'click') ? $vo['key'] : $vo['url'];
					$sub_button = array();
					foreach ($list as $val) {
						$val['val'] = ($val['type'] == 'click') ? $val['key'] : $val['url'];
						if ($val['pid'] == $vo['id']) {
							$sub_button[] = $val;
						}
					}
					$vo['sub_button'] = $sub_button;
					$result[] = $vo;
				}
			}
		}
		return array ('menu_list' => $result);
	}
	
	/**
	 * html代码输出
	 * @param unknown $str
	 * @return string
	 */
	private function html_out($str) {
		if (function_exists('htmlspecialchars_decode')) {
			$str = htmlspecialchars_decode($str);
		} else {
			$str = html_entity_decode($str);
		}
		$str = stripslashes($str);
		return $str;
	}
}

//end