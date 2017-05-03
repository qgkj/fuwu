<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 帐号 Connect 后台管理
 */
class admin extends ecjia_admin {

	private $db_user;	
	private $connect_account;
	private $db_connect;
	
	public function __construct() {
		parent::__construct();
		
		$this->connect_account = RC_Loader::load_app_class('connect_account');
		$this->db_user = RC_Loader::load_app_model('users_model');
		$this->db_connect = RC_Loader::load_app_model('connect_model');

		/* 加载所全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('connect', RC_App::apps_url('statics/js/connect.js', __FILE__), array(), false, true);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Loader::load_app_class('connect_factory', null, false);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.connect'), RC_Uri::url('connect/admin/init')));
		
		$js_lang = array(
			'name_required'	=> RC_Lang::get('connect::connect.pls_name'),
			'desc_required'	=> RC_Lang::get('connect::connect.pls_desc'),
		);
		RC_Script::localize_script('connect', 'js_lang', $js_lang);
	}
	
	/**
	 * 连接号码列表
	 */
	public function init() {
	    $this->admin_priv('connect_users_manage');
	    
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.connect')));
		$this->assign('ur_here', RC_Lang::get('connect::connect.connect_list'));
		
		$listdb = $this->connect_list();
		$this->assign('listdb', $listdb);
		
		$this->display('connect_list.dwt');
	}
	
	/**
	 * 编辑页面
	 */
	public function edit() {
		$this->admin_priv('connect_users_update');
		
		if (isset($_GET['code'])) {
		    $connect_code = trim($_GET['code']);
		} else {
		    return $this->showmessage(RC_Lang::get('connect::connect.invalid_parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 查询该连接方式内容 */
		$connect = $this->db_connect->where(array('connect_code' => $connect_code, 'enabled' => 1))->find();
		if (empty($connect)) {
		    return $this->showmessage(RC_Lang::get('connect::connect.connect_type'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}

		/* 取得配置信息 */
		if (is_string($connect['connect_config'])) {
		    $connect_config = unserialize($connect['connect_config']);
		    /* 取出已经设置属性的code */
		    $code_list = array();
		    if (!empty($connect_config)) {
		        foreach ($connect_config as $key => $value) {
		            $code_list[$value['name']] = $value['value'];
		        }
		    }
		    $connect_handle            = new connect_factory($connect_code);
		    $connect['connect_config'] = $connect_handle->configure_forms($code_list, true);
		
		}

		$this->assign('connect', $connect);
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('connect::connect.edit')));
		$this->assign('ur_here', RC_Lang::get('connect::connect.edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('connect::connect.connect_list'), 'href' => RC_Uri::url('connect/admin/init')));
		$this->assign('form_action', RC_Uri::url('connect/admin/update'));
	
		$this->assign_lang();
		$this->display('connect_edit.dwt');
	}
	
	/**
	 * 编辑处理
	 */
	public function update() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);
	
		$connect_name = trim($_POST['connect_name']);
		$connect_desc = trim($_POST['connect_desc']);
		
		$oldname      = trim($_POST['oldname']);
		$code         = trim($_POST['connect_code']);
		
		if ($connect_name != $oldname) {
			$query = $this->db_connect->where(array('connect_name' => $connect_name))->count();
			if ($query > 0) {
				return $this->showmessage(RC_Lang::get('connect::connect.confirm_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 取得配置信息 */
		$connect_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
		    	
		    for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
		        $connect_config[] = array(
		            'name'  => trim($_POST['cfg_name'][$i]),
		            'type'  => trim($_POST['cfg_type'][$i]),
		            'value' => trim($_POST['cfg_value'][$i])
		        );
		    }
		}
		
		$connect_config = serialize($connect_config);
		
		if ($_POST['id']) {
		    /* 编辑 */
		    $data = array(
		        'connect_name'   => $connect_name,
		        'connect_desc'   => trim($_POST['connect_desc']),
		        'connect_config' => $connect_config,
		    );
		    $this->db_connect->where(array('connect_code' => $code))->update($data);
		
		    return $this->showmessage(RC_Lang::get('system::navigator.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
		    $data_one = $this->db_connect->where(array('connect_code' => $code))->count();
		    	
		    if ($data_one > 0) {
		        /* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
		        $data = array(
		            'connect_name'   => $connect_name,
		            'connect_desc'   => $connect_desc,
		            'connect_config' => $connect_config,
		            'enabled'        => '1'
		        );
		        $this->db_connect->where(array('connect_code' => $code))->update($data);
		    } else {
		        /* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
		        $data =array(
		            'connect_code' 		=> $code,
		            'connect_name' 		=> $connect_name,
		            'connect_desc' 		=> $connect_desc,
		            'connect_config' 	=> $connect_config,
		            'enabled'  			=> '1',
		        );
		
		        $this->db_connect->insert($data);
		    }
		}
	
		$links[] = array('text' =>RC_Lang::get('system::system.go_back'), 'href'=>RC_Uri::url('connect/admin/init'));
		return $this->showmessage(RC_Lang::get('connect::connect.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('connect/admin/edit', array('id' => $_POST['id']))));
	}
	
	/**
	 * 修改名称
	 */
	public function edit_name() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);

		$connect_id   = intval($_POST['pk']);
		$connect_name = trim($_POST['value']);
	
		/* 检查名称是否为空 */
		if (empty($connect_name)) {
			return $this->showmessage(RC_Lang::get('connect::connect.empty_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
		} else {
			if( $this->db_connect->where(array('connect_name' => $connect_name, 'connect_id' => array('neq' => $connect_id)))->count() > 0) {
				return $this->showmessage(RC_Lang::get('connect::connect.confirm_name'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				$this->db_connect->where(array('connect_id' => $connect_id ))->update(array('connect_name' => $connect_name));
				return $this->showmessage(RC_Lang::get('connect::connect.edit_name_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	
	/**
	 * 修改排序
	 */
	public function edit_order() {
		$this->admin_priv('connect_users_update', ecjia::MSGTYPE_JSON);
	
		if (!is_numeric($_POST['value']) ) {
			return $this->showmessage(RC_Lang::get('connect::connect.confirm_number'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$connect_id    = intval($_POST['pk']);
			$connect_order = intval($_POST['value']);
	
			$this->db_connect->where(array('connect_id' => $connect_id))->update(array('connect_order' => $connect_order));
			return $this->showmessage(RC_Lang::get('connect::connect.sort_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin/init')));
		}
	}
	
	/**
	 * 禁用
	 */
	public function disable() {
		$this->admin_priv('connect_users_disable', ecjia::MSGTYPE_JSON);
	
		$id   = trim($_GET['id']);
		$data = array(
			'enabled' => 0
		);
		$this->db_connect->where(array('connect_id' => $id))->update($data);
	
// 		ecjia_admin::admin_log($id, 'disable', 'payment');
		return $this->showmessage(RC_Lang::get('connect::connect.disable_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin/init')));
	}
	
	/**
	 * 启用
	 */
	public function enable() {
		$this->admin_priv('connect_users_enable', ecjia::MSGTYPE_JSON);
	
		$id   = trim($_GET['id']);
		$data = array(
			'enabled' => 1
		);
		$this->db_connect->where(array('connect_id' => $id))->update($data);

// 		ecjia_admin::admin_log($id, 'enable', 'payment');
		return $this->showmessage(RC_Lang::get('connect::connect.enable_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_uri::url('connect/admin/init')));
	}
	
	private function connect_list() {
		$db_topic = RC_Loader::load_app_model('connect_model');
		
		$filter   = array();
		
		$count    = $db_topic->count();
		$filter ['record_count'] = $count;
		$page     = new ecjia_page($count, 10, 5);
	
		$arr      = array ();
		$data     = $db_topic->order(array('connect_order'=> 'desc'))->limit($page->limit())->select();
		if (isset($data)) {
			foreach ($data as $rows) {
				$arr[] = $rows;
			}
		}
		return array('connect_list' => $arr, 'filter'=>$filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

// end