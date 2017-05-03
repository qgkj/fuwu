<?php
  
/**
 * ECJIA 角色管理信息以及权限管理程序
 */
defined('IN_ECJIA') or exit('No permission resources.');

class admin_role extends ecjia_admin {
	
	private $db_role;
	private $db_user;
	
	public function __construct() {
		parent::__construct();

		$this->db_role = RC_Loader::load_model('role_model');
		$this->db_user = RC_Model::model('admin_user_model');

		RC_Style::enqueue_style('fontello');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('ecjia-admin_role');
		RC_Script::enqueue_script('jquery-uniform');
		
		// 加载JS语言包
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		
		
		$admin_role_jslang = array(
				'pls_name'	=> __('请输入用户名！'),
		);
		RC_Script::localize_script('ecjia-admin_role', 'admin_role_lang', $admin_role_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('角色管理'), RC_Uri::url('@admin_role/init')));
	}

	/**
	 * 角色列表页面
	 */
	public function init() {
		$this->admin_priv('admin_manage');
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('角色管理')));
		$this->assign('ur_here', __('角色管理'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台角色管理页面，系统中所有的角色都会显示在此列表中。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E8.A7.92.E8.89.B2.E7.AE.A1.E7.90.86" target="_blank">关于角色管理帮助文档</a>') . '</p>'
		);
		
		$this->assign('action_link',	array('href'=>RC_Uri::url('@admin_role/add'), 'text' => __('添加角色')));
		$this->assign('admin_list',		$this->db_role->get_role_list());
			
		$this->display('role_list.dwt');
	}

	/**
	 * 添加角色页面
	 */
	public function add() {
		$this->admin_priv('admin_manage');
		
		$priv_group = ecjia_purview::load_purview();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加角色')));
		$this->assign('ur_here',		__('添加角色'));
		$this->assign('action_link',	array('href'=>RC_Uri::url('@admin_role/init'), 'text' => __('角色列表')));
		
		$this->assign('form_act',		'insert');
		$this->assign('priv_group',		$priv_group);
		$this->assign('pjaxurl',		RC_Uri::url('@admin_role/edit'));
		
		$this->display('role_info.dwt');
	}
	
	/**
	 * 添加角色的处理
	 */
	public function insert() {
		$this->admin_priv('admin_manage');
		
		$act_list = join(",", $_POST['action_code']);
		$data = array(
			'role_name'		=> trim($_POST['user_name']),
			'action_list'	=> $act_list,
			'role_describe'	=> trim($_POST['role_describe']),
		);
		$new_id = $this->db_role->insert($data);

		/* 记录日志 */
        ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
		ecjia_admin::admin_log($_POST['user_name'], 'add', 'role');
		
		/*添加链接*/
		$link[0]['text'] = __('角色列表');
		$link[0]['href'] = RC_Uri::url('@admin_role/init');

		return $this->showmessage(sprintf(__('添加 %s 操作成功'),$_POST['user_name']), 0x21, array('link' => $link, 'id' => $new_id));
	}
	
	/**
	 * 编辑角色信息
	 */
	public function edit() {
	    $this->admin_priv('admin_manage');
	    
		$_REQUEST['id'] = !empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
		
		/* 查看是否有权限编辑其他管理员的信息 */
		if ($_SESSION['admin_id'] != $_REQUEST['id']) {
			$this->admin_priv('admin_manage');
		}

		$user_info = $this->db_role->field('role_id, role_name, role_describe, action_list')->where(array('role_id' => $_REQUEST['id']))->find();
		$priv_str = $user_info['action_list'];

		$priv_group = ecjia_purview::load_purview($priv_str);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('修改角色')));

		$this->assign('user',		$user_info);
		$this->assign('ur_here',	 __('修改角色'));
		$this->assign('action_link', array('href'=>RC_Uri::url('@admin_role/init'), 'text' => __('角色列表')));
		$this->assign('priv_group',	$priv_group);
		$this->assign('user_id',	 $_GET['id']);
		$this->assign('form_act',	'update');
		
		$this->display('role_info.dwt');
	}
	
	/**
	 * 更新角色信息
	 */
	public function update() {
		$this->admin_priv('admin_manage');
		
		$act_list = join(",", $_POST['action_code']);
		$data_role = array(
				'action_list' 	=> $act_list,
				'role_name' 	=> $_POST['user_name'],
				'role_describe' => $_POST['role_describe'],
		);
		
		$data_user = array(
				'action_list' => $act_list,
		);
		
		$this->db_role->where(array('role_id' => $_POST['id']))->update($data_role);
		$this->db_user->where(array('role_id' => $_POST['id']))->update($data_user);

        /* 记录日志 */
        ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
        ecjia_admin::admin_log($_POST['user_name'], 'edit', 'role');
		
		/* 提示信息 */
		$link[] = array('text' => __('返回角色列表'), 'href'=>RC_Uri::url('@admin_role/init'));
		return $this->showmessage(sprintf(__('编辑 %s 操作成功'),$_POST['user_name']), 0x21, array('link' => $link));
	}
	
	/**
	 * 删除一个角色
	 */
	public function remove() {
		$this->admin_priv('admin_drop', ecjia::MSGTYPE_JSON);
		$id = intval($_GET['id']);
		
		$remove_num = $this->db_user->where(array('role_id' => $id))->count();
		if ($remove_num > 0) {
			return $this->showmessage(__('此角色有管理员在使用，暂时不能删除！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
            $role_name = $this->db_role->where(array('role_id' => $id))->get_field('role_name');
			$this->db_role->where(array('role_id' => $id))->delete();

            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('role', __('管理员角色'));
            ecjia_admin::admin_log($role_name, 'remove', 'role');

			return $this->showmessage(sprintf(__('成功删除管理员角色 %s'), $role_name),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
}

// end