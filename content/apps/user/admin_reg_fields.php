<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员注册项管理程序
*/
class admin_reg_fields extends ecjia_admin {
	private $db_reg_fields;
	private $db_reg_extend_info;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global', 'goods');
		$this->db_reg_fields		= RC_Model::model('user/reg_fields_model');
		$this->db_reg_extend_info	= RC_Model::model('user/reg_extend_info_model');
		
		/* 加载所需js */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));

		$reg_field_jslang = array(
			'reg_field_name_required'	=> RC_Lang::get('user::reg_fields.reg_field_name_confirm'),
			'reg_field_order_required'	=> RC_Lang::get('user::reg_fields.reg_field_order_confirm'),
		);
		RC_Script::localize_script( 'user_info', 'reg_jslang', $reg_field_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::reg_fields.21_reg_fields'), RC_Uri::url('user/admin_reg_fields/init')));
	}
	
	/**
	 * 会员注册项列表
	 */
	public function init() {
		$this->admin_priv('reg_fields');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::reg_fields.21_reg_fields')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.user_register_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">'.RC_Lang::get('user::users.about_user_register').'</a>') . '</p>'
		);
		
		$this->assign('ur_here',		RC_Lang::get('user::reg_fields.21_reg_fields'));
		$this->assign('action_link',	array('text' => RC_Lang::get('user::reg_fields.add_reg_field'), 'href' => RC_Uri::url('user/admin_reg_fields/add')));
		
		$fields = RC_DB::table('reg_fields')->orderBy('dis_order', 'asc')->orderBy('id', 'asc')->get();

		$this->assign('reg_fields', $fields);
		
		$this->display('reg_fields_list.dwt');
	}
	
	/**
	 * 添加会员注册项
	 */
	public function add() {
		$this->admin_priv('reg_fields');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::reg_fields.add_reg_field')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.add_register_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">'.RC_Lang::get('user::users.about_add_register').'</a>') . '</p>'
		);
		
		$this->assign('ur_here',		RC_Lang::get('user::reg_fields.add_reg_field'));
		$this->assign('action_link',	array('text' => RC_Lang::get('user::reg_fields.21_reg_fields'), 'href' => RC_Uri::url('user/admin_reg_fields/init')));
		
		$reg_field['reg_field_order']		= 100;
		$reg_field['reg_field_display']		= 1;
		$reg_field['reg_field_need']		= 1;
		$this->assign('reg_field',			$reg_field);
		$this->assign('form_action',		RC_Uri::url('user/admin_reg_fields/insert'));
		
		$this->display('reg_fields_edit.dwt');
	}
	
	/**
	 * 增加会员注册项到数据库
	 */
	public function insert() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		/* 取得参数  */
		$field_name		= trim($_POST['reg_field_name']);
		$dis_order		= trim($_POST['reg_field_order']);
		$display		= trim($_POST['reg_field_display']);
		$is_need		= trim($_POST['reg_field_need']);
		/* 检查是否存在重名的会员注册项 */
		if (RC_DB::table('reg_fields')->where('reg_field_name', $field_name)->count() != 0){

			return $this->showmessage(sprintf(RC_Lang::get('user::reg_fields.field_name_exist'), $field_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'reg_field_name'	=> $field_name,
			'dis_order'			=> $dis_order,
			'display'			=> $display,
			'is_need'			=> $is_need,
		);
		$max_id = RC_DB::table('reg_fields')->insertGetId($data);
		ecjia_admin::admin_log($field_name, 'add', 'reg_fields');
		
		$links[] = array('text' => RC_Lang::get('user::reg_fields.back_list'), 'href' => RC_Uri::url('user/admin_reg_fields/init'));
		$links[] = array('text' => RC_Lang::get('user::reg_fields.add_continue'), 'href' => RC_Uri::url('user/admin_reg_fields/add'));
		return $this->showmessage(RC_Lang::get('user::reg_fields.add_field_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_reg_fields/edit', array('id' => $max_id))));
	}
	
	/**
	 * 编辑会员注册项
	 */
	public function edit() {
		$this->admin_priv('reg_fields');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::reg_fields.edit_reg_field')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.edit_register_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员注册项设置" target="_blank">'.RC_Lang::get('user::users.about_edit_register').'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('user::reg_fields.edit_reg_field'));
		$this->assign('action_link', array('text' => RC_Lang::get('user::reg_fields.21_reg_fields'), 'href' => RC_Uri::url('user/admin_reg_fields/init')));
		
		$reg_field = RC_DB::table('reg_fields')
				->where('id', $_REQUEST['id'])->select('id as reg_field_id', 'reg_field_name', 'dis_order as reg_field_order', 'display as reg_field_display', 'is_need as reg_field_need')
				->first();

		$this->assign('reg_field',		$reg_field);
		$this->assign('form_action',	RC_Uri::url('user/admin_reg_fields/update'));
		
		$this->display('reg_fields_edit.dwt');
	}
	
	/**
	 * 更新会员注册项
	 */
	public function update() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		/* 取得参数  */
		$field_name		= trim($_POST['reg_field_name']);
		$dis_order		= trim($_POST['reg_field_order']);
		$display		= trim($_POST['reg_field_display']);
		$is_need		= trim($_POST['reg_field_need']);
		$id				= $_POST['id'];
		
		/* 根据id获取之前的名字  */
		$old_name = RC_DB::table('reg_fields')->where('id', $id)->pluck('reg_field_name');

		/* 检查是否存在重名的会员注册项 */
		if ($field_name != $old_name) {
			if (RC_DB::table('reg_fields')->where('reg_field_name', $field_name)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::reg_fields.field_name_exist'), $field_name),  ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$data = array(
			'reg_field_name'	=> $field_name,
			'dis_order'			=> $dis_order,
			'display'			=> $display,
			'is_need'			=> $is_need,
		);
		RC_DB::table('reg_fields')->where('id', $id)->update($data);

		ecjia_admin::admin_log($field_name, 'edit', 'reg_fields');
		$links[] = array('text' => RC_Lang::get('user::reg_fields.back_list'), 'href' => RC_Uri::url('user/admin_reg_fields/init'));
		return $this->showmessage(RC_Lang::get('user::reg_fields.edit_field_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_reg_fields/edit', array('id' => $id))));
	}
	
	/**
	 * 删除会员注册项
	 */
	public function remove() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		$field_id	= intval($_GET['id']);
		$field_name = RC_DB::table('reg_fields')->where('id', $field_id)->pluck('reg_field_name');

		if (RC_DB::table('reg_fields')->where('id', $field_id)->delete()) {
			/* 删除会员扩展信息表的相应信息 */
			RC_DB::table('reg_extend_info')->where('reg_field_id', $field_id)->delete();
			ecjia_admin::admin_log(addslashes($field_name), 'remove', 'reg_fields');
			
			return $this->showmessage(RC_Lang::get('user::reg_fields.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}	
	}
	
	/**
	 * 编辑会员注册项名称
	 */
	public function edit_name() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$id		= intval($_REQUEST['pk']);
		$val	= empty($_REQUEST['value']) ? '' : trim($_REQUEST['value']);
		
		if (empty($val)) {
			return $this->showmessage(RC_Lang::get('user::reg_fields.js_languages.field_name_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 验证名称,根据id获取之前的名字  */
		$old_name = RC_DB::table('reg_fields')->where('id', $id)->pluck('reg_field_name');

		if ($val != $old_name) {
			if (RC_DB::table('reg_fields')->where('reg_field_name', $val)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::reg_fields.field_name_exist'), htmlspecialchars($val)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		if (RC_DB::table('reg_fields')->where('id', $id)->update(array('reg_field_name' => $val))) {
			/* 管理员日志 */
			ecjia_admin::admin_log($val, 'edit', 'reg_fields');
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} 
	}
	
	/**
	 * 编辑会员注册项排序权值
	 */
	public function edit_order() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$id  = intval($_REQUEST['pk']);
		$val = isset($_REQUEST['value']) ? trim($_REQUEST['value']) : '' ;

		/* 验证参数有效性  */
		if (!is_numeric($val) || empty($val) || $val < 0 || strpos($val, '.') > 0 ) {
			return $this->showmessage(RC_Lang::get('user::reg_fields.order_not_num'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		RC_DB::table('reg_fields')->where('id', $id)->update(array('dis_order' => $val));

		if (RC_DB::table('reg_fields')->where('id', $id)->update(array('dis_order' => $val)) == 0) {
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/admin_reg_fields/init')));
		} else {
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 修改会员注册项显示状态
	 */
	public function toggle_dis() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$id		= intval($_POST['id']);
		$is_dis	= intval($_POST['val']);

		if (RC_DB::table('reg_fields')->where('id', $id)->update(array('display' => $is_dis))) {
			return $this->showmessage(RC_Lang::get('user::reg_fields.change_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_dis));
		} else {
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 修改会员注册项必填状态
	 */
	public function toggle_need() {
		$this->admin_priv('reg_fields', ecjia::MSGTYPE_JSON);

		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$id			= intval($_POST['id']);
		$is_need	= intval($_POST['val']);

		if (RC_DB::table('reg_fields')->where('id', $id)->update(array('is_need' => $is_need))) {
			return $this->showmessage(RC_Lang::get('user::reg_fields.change_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_need));
		} else {
			return $this->showmessage(RC_Lang::get('user::reg_fields.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end