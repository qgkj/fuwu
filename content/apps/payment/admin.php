<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 支付方式管理
 */
class admin extends ecjia_admin {
	
	private $db;	
	public function __construct() {
		parent::__construct();
		
		$this->db = RC_Model::model('payment/payment_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');		
		
		/* 支付方式 列表页面 js/css */

		RC_Script::enqueue_script('payment_admin', RC_App::apps_url('statics/js/payment_admin.js',__FILE__),array(), false, true);
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));

		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::localize_script('payment_admin', 'js_lang', RC_Lang::get('payment::payment.js_lang'));
		
		RC_Loader::load_app_class('payment_factory', null, false);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('支付方式'), RC_Uri::url('payment/admin/init')));
	}

	/**
	 * 支付方式列表
	 */
	public function init() {
		$this->admin_priv('payment_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.payment')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
		'id'		=> 'overview',
		'title'		=> RC_Lang::get('payment::payment.overview'),
		'content'	=> '<p>' . RC_Lang::get('payment::payment.payment_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . RC_Lang::get('payment::payment.more_info') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:支付方式" target="_blank">'. RC_Lang::get('payment::payment.about_payment_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', RC_Lang::get('payment::payment.payment'));
		
		$plugins = ecjia_config::instance()->get_addon_config('payment_plugins', true, true);
		/* 不能用，该数据查询会把特殊字符双重转义*/
// 		$data = RC_DB::table('payment')->orderBy('pay_order')->get();
		$data = RC_Model::model('payment/payment_model')->select();
		$data or $data = array();
		$modules = array();
		foreach($data as $_key => $_value) {
		    if (isset($plugins[$_value['pay_code']])) {
		    	$modules[$_key]['id'] 			= $_value['pay_id'];
		        $modules[$_key]['code'] 		= $_value['pay_code'];
		        $modules[$_key]['name'] 		= $_value['pay_name'];
		        $modules[$_key]['pay_fee'] 		= $_value['pay_fee'];
		        $modules[$_key]['is_cod'] 		= $_value['is_cod'];
		        $modules[$_key]['desc'] 		= $_value['pay_desc'];
		        $modules[$_key]['pay_order'] 	= $_value['pay_order'];
		        $modules[$_key]['enabled'] 		= $_value['enabled'];
		    }
		}
		
		$this->assign('modules', $modules);
		
		$this->display('payment_list.dwt');
	}

	/**
	 * 禁用支付方式
	 */
	public function disable() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
				
		$code = trim($_GET['code']);
		$data = array(
			'enabled' => 0
		);
		RC_DB::table('payment')->where('pay_code', $code)->update($data);
		
		$pay_name = RC_DB::table('payment')->where('pay_code', $code)->pluck('pay_name');
		
		ecjia_admin::admin_log($pay_name, 'stop', 'payment');
		
		$refresh_url = RC_Uri::url('payment/admin/init');
		return $this->showmessage(RC_Lang::get('payment::payment.plugin')."<strong> ".RC_Lang::get('payment::payment.disabled')." </strong>", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
	}
	
	/**
	 * 启用支付方式
	 */
	public function enable() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enabled' => 1
		);
		
		RC_DB::table('payment')->where('pay_code', $code)->update($data);
		
		
		$pay_name = RC_DB::table('payment')->where('pay_code', $code)->pluck('pay_name');
		
		ecjia_admin::admin_log($pay_name, 'use', 'payment');
		
		$refresh_url = RC_Uri::url('payment/admin/init');
		return $this->showmessage(RC_Lang::get('payment::payment.plugin')."<strong> ".RC_Lang::get('payment::payment.enabled')." </strong>", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
	}
	
	/**
	 * 编辑支付方式 code={$code}
	 */
	public function edit() {
		$this->admin_priv('payment_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('payment::payment.edit_payment')));
		$this->assign('action_link', array('text' => RC_Lang::get('payment::payment.payment'), 'href' => RC_Uri::url('payment/admin/init')));
		$this->assign('ur_here', RC_Lang::get('payment::payment.edit_payment'));
		
		if (isset($_GET['code'])) {
		    $pay_code = trim($_GET['code']); 
		} else {
		    return $this->showmessage(__('invalid parameter'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查询该支付方式内容 */
		$pay = RC_DB::table('payment')->where('pay_code', $pay_code)->where('enabled', 1)->first();
		
		if (empty($pay)) {
		    return $this->showmessage(RC_Lang::get('payment::payment.payment_not_available'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 取得配置信息 */
		if (is_string($pay['pay_config'])) {
		    $pay_config = unserialize($pay['pay_config']);
		    /* 取出已经设置属性的code */
		    $code_list = array();
		    if (!empty($pay_config)) {
		        foreach ($pay_config as $key => $value) {
		            $code_list[$value['name']] = $value['value'];
		        }
		    }
		    $payment_handle = new payment_factory($pay_code);
		    $pay['pay_config'] = $payment_handle->configure_forms($code_list, true);

		}
		
		/* 如果以前没设置支付费用，编辑时补上 */
		if (!isset($pay['pay_fee'])) {
		    $pay['pay_fee'] = 0;
		}	
		$this->assign('pay', $pay);
		$this->assign('form_action', RC_Uri::url('payment/admin/save'));
		
		$this->display('payment_edit.dwt');
	}
	
	/**
	 * 提交支付方式 post
	 */
	public function save() {	
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		$name = trim($_POST['pay_name']);
		$code = trim($_POST['pay_code']);
		/* 检查输入 */
		if (empty($name)) {
			return $this->showmessage(RC_Lang::get('payment::payment.payment_name') . RC_Lang::get('system::system.empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = RC_DB::table('payment')->where('pay_name', $name)->where('pay_code', '!=', $code)->count();
		if ($data > 0) {
			return $this->showmessage(RC_Lang::get('payment::payment.payment_name'). RC_Lang::get('payment::payment.repeat'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 取得配置信息 */
		$pay_config = array();
		if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
			for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
				$pay_config[] = array(
					'name'  => trim($_POST['cfg_name'][$i]),
					'type'  => trim($_POST['cfg_type'][$i]),
					'value' => trim($_POST['cfg_value'][$i])
				);
			}
		}
		
		$pay_config = serialize($pay_config);
		/* 取得和验证支付手续费 */
		$pay_fee = empty($_POST['pay_fee'])? 0: intval($_POST['pay_fee']);

		if ($_POST['pay_id']) {
			/* 编辑 */
			$array = array(
				'pay_name'   => $name,
				'pay_desc'   => trim($_POST['pay_desc']),
				'pay_config' => $pay_config,
				'pay_fee'    => $pay_fee
			);
			RC_DB::table('payment')->where('pay_code', $code)->update($array);
			 
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'payment');
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			$data_one = RC_DB::table('payment')->where('pay_code', $code)->count();
			if ($data_one > 0) {
				/* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
				$data = array(
					'pay_name'   => $name,
					'pay_desc'   => trim($_POST['pay_desc']),
					'pay_config' => $pay_config,
					'pay_fee'    => $pay_fee,
					'enabled'    => '1'						
				);
			    RC_DB::table('payment')->where('pay_code', $code)->update($data);
			    
			} else {
				/* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */				
				$data = array(
				    'pay_code'     => $code,
					'pay_name'     => $name,
					'pay_desc'     => trim($_POST['pay_desc']),
					'pay_config'   => $pay_config,
					'is_cod'       => intval($_POST['is_cod']),
					'pay_fee'      => $pay_fee,
					'enabled'      => '1',
					'is_online'    => intval($_POST['is_online'])
				);
	           	RC_DB::table('payment')->insertGetId($data);
			}
			
			/* 记录日志 */
			ecjia_admin::admin_log($name, 'edit', 'payment');
			$refresh_url = RC_Uri::url('payment/admin/edit', array('code' => $code));
			
			return $this->showmessage(RC_Lang::get('payment::payment.install_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $refresh_url));
		}			
	}
	
	/**
	 * 修改支付方式名称
	 */
	public function edit_name() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		/* 取得参数 */
		$pay_id  = intval($_POST['pk']);
		$pay_name = trim($_POST['value']);
		
		/* 检查名称是否为空 */
		if (empty($pay_name) || $pay_id==0 ) {
			return $this->showmessage(RC_Lang::get('payment::payment.name_is_null'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 检查名称是否重复 */
			if (RC_DB::table('payment')->where('pay_name', $pay_name)->where('pay_id', '!=', $pay_id)->count() > 0) {
				return $this->showmessage(RC_Lang::get('payment::payment.name_exists') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR );
			} else {
				RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_name' => stripcslashes($pay_name)));
				
				ecjia_admin::admin_log(stripcslashes($pay_name), 'edit', 'payment');
				return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
		}
	}
	

	/**
	 * 修改支付方式排序
	 */
	public function edit_order() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		if ( !is_numeric($_POST['value']) ) {
			return $this->showmessage('请输入合法数字', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			/* 取得参数 */
			$pay_id    = intval($_POST['pk']);
			$pay_order = intval($_POST['value']);
		
			RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_order' => $pay_order));
			
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_uri::url('payment/admin/init')) );
		}
	}
	
	/**
	 * 修改支付方式费用
	 */
	public function edit_pay_fee() {
		$this->admin_priv('payment_update', ecjia::MSGTYPE_JSON);
		
		/* 取得参数 */
		$pay_id  = intval($_POST['pk']);
		$pay_fee = trim($_POST['value']);
		
		if (empty($pay_fee) && !($pay_fee === '0')) {
			return $this->showmessage(RC_Lang::get('payment::payment.invalid_pay_fee') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$pay_insure = make_semiangle($pay_fee); //全角转半角
			if (strpos($pay_insure, '%') === false) { //不包含百分号
				if ( !is_numeric($pay_fee) ) {
					return $this->showmessage('请输入合法数字或百分比%', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				} else {
					$pay_fee = floatval($pay_insure);
				}
			}
			else {
				$pay_fee = floatval($pay_insure) . '%';
			}
			$pay_name = RC_DB::table('pay_id', $pay_id)->pluck('pay_name');
			RC_DB::table('payment')->where('pay_id', $pay_id)->update(array('pay_fee' => stripcslashes($pay_fee)));
			
			ecjia_admin::admin_log($pay_name.'，'.'修改费用为 '.$pay_fee, 'setup', 'payment');
			return $this->showmessage(RC_Lang::get('payment::payment.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
}

// end