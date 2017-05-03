<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 计划任务
 * @author wutifang
 */
class admin extends ecjia_admin {
	private $db_crons;
	
	private $cron_method;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_crons = RC_Loader::load_app_model('crons_model', 'cron');
		
		$this->cron_method = RC_Package::package('app::cron')->loadClass('cron_method');
		RC_Package::package('app::cron')->loadClass('cron_helper');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/*加载全局JS及CSS*/
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('cron', RC_App::apps_url('statics/css/cron.css', __FILE__));
		RC_Script::enqueue_script('cron', RC_App::apps_url('statics/js/cron.js', __FILE__));
		
		RC_Script::localize_script('cron', 'js_lang', RC_Lang::get('cron::cron.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.cron'), RC_Uri::url('cron/admin/init')));
	}
	
	//列表页
	public function init () {
		$this->admin_priv('cron_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.cron')));
		$this->assign('ur_here', RC_Lang::get('cron::cron.cron'));

		$db_cron = RC_DB::table('crons');
		$count['type'] = isset($_GET['type']) ? $_GET['type'] : '';
		if (!empty($count['type'])) {
			$db_cron->where('enable', 0);
		}else{
			$db_cron->where('enable', 1);
		}
		$data = $db_cron->get();
		$filter_count = RC_DB::table('crons')->select(RC_DB::raw('SUM(IF(enable = 1, 1, 0)) as enabled'), RC_DB::raw('SUM(IF(enable =0 , 1, 0)) as disabled'))->first();
		$count['enabled'] 	= $filter_count['enabled'] > 0 ? $filter_count['enabled'] : 0;
		$count['disabled']  = $filter_count['disabled'] > 0 ? $filter_count['disabled'] : 0;
		
		$this->assign('count', $count);
		$data or $data = array();
		$modules = array();
		if (isset($data)) {
			foreach ($data as $_key => $_value) {
				$modules[$_key]['code'] 		= $_value['cron_code'];
				$modules[$_key]['name'] 		= $_value['cron_name'];
				$modules[$_key]['desc'] 		= $_value['cron_desc'];
				$modules[$_key]['cron_order'] 	= $_value['cron_order'];
				$modules[$_key]['nextime'] 		= RC_Time::local_date('Y-m-d H:i:s', $_value['nextime']);
				$modules[$_key]['thistime'] 	= $_value['thistime'] ? RC_Time::local_date('Y-m-d H:i:s', $_value['thistime']) : '-';
				$modules[$_key]['enabled'] 		= $_value['enable'];
				$modules[$_key]['install'] 		= '1';
			}
		} else {
			$modules[$_key]['install'] = '0';
		}
		$this->assign('modules', $modules);
		
		$this->display('cron_list.dwt');
	}
	
	
	/**
	 * 禁用计划任务
	 */
	public function disable() {
		$this->admin_priv('cron_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enable' => 0
		);
		$cron_disable = $this->db_crons->crons_update(array('cron_code' => $code), $data);
		$cron_name = $this->db_crons->crons_field(array('cron_code' => $code), 'cron_name');
		
		ecjia_admin::admin_log($cron_name, 'disable', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.cron_disabled'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin/init')));
	}
	
	/**
	 * 启用计划任务
	 */
	public function enable() {
		$this->admin_priv('cron_update', ecjia::MSGTYPE_JSON);
		
		$code = trim($_GET['code']);
		$data = array(
			'enable' => 1
		);
		$cron_enable = $this->db_crons->crons_update(array('cron_code' => $code), $data);
		$cron_name = $this->db_crons->crons_field(array('cron_code' => $code), 'cron_name');
		
		ecjia_admin::admin_log($cron_name, 'enable', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.cron_enable'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin/init')));
	}
	
	public function edit() {
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('cron::cron.edit_cron')));
		$this->assign('ur_here', RC_Lang::get('cron::cron.edit_cron'));
		$this->assign('action_link', array('text' => RC_Lang::get('cron::cron.cron'), 'href' => RC_Uri::url('cron/admin/init')));
		
		if (empty($_POST['step'])) {
		    $this->admin_priv('cron_update');
		    
			$code = trim($_GET['code']);
			$cron = $this->db_crons->crons_find(array('cron_code' => $code));
			
			if (empty($cron)) {
				$links[] = array('text' => RC_Lang::get('cron::cron.back_list'), 'href' => RC_Uri::url('cron/admin/init'));
			}
			/* 取相应插件信息 */
			//todo
			RC_Lang::load($code);
			$modules[0] = RC_Loader::load_app_config($code);
			$data = $modules[0];
			
			/* 取得配置信息 */
			$cron_config = unserialize($cron['cron_config']);
			
			$code_list = array();
			if (!empty($cron_config)) {
				foreach ($cron_config AS $key => $value) {
					$code_list[$value['name']] = $value['value'];
				}
			}
			
			$cron_handle = $this->cron_method->pluginInstance($code);
			$cron_config_file = $cron_handle->loadConfig();
			$cron['cron_config'] = $cron_handle->makeFormData($code_list);
			$cron['cron_act']   = 'edit';
			$cron['cronweek']   = $cron['week'] == '0' ? 7 : $cron['week'];
			$cron['cronday']    = $cron['day'];
			$cron['cronhour']   = $cron['hour'];
			$cron['cronminute'] = $cron['minute'];
			$cron['run_once'] && $cron['autoclose'] = 'checked';
			list($day, $week, $hours) = cron_helper::get_dwh();

			$this->assign('cron', $cron);
			$this->assign('days', $day);
			$this->assign('week', $week);
			$this->assign('hours', $hours);
			$this->assign('minute', RC_Lang::get('cron::cron.minute'));
			$this->assign('app_lists', $this->app_list($cron['alow_files']));
			$this->assign('cron_config_file', $cron_config_file);
			$this->display('cron_edit.dwt');
		} elseif ($_POST['step'] == 2) {
		    $this->admin_priv('cron_update', ecjia::MSGTYPE_JSON);
		    
			$code = trim($_GET['code']);
			
			$links[] = array('text' => RC_Lang::get('cron::cron.back_list'), 'href' => RC_Uri::url('cron/admin/init'));

			$cron_config = array();
			if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
				$temp = count($_POST['cfg_value']);
				for ($i = 0; $i < $temp; $i++) {
					$cron_config[] = array(
						'name'  => trim($_POST['cfg_name'][$i]),
						'type'  => trim($_POST['cfg_type'][$i]),
						'value' => trim($_POST['cfg_value'][$i])
					);
				}
			}
			$cron_config = serialize($cron_config);
			
			//锁定时间
			$data_time = array();
			$cron_handle = $this->cron_method->pluginInstance($code);
			$cron_config_file = $cron_handle->loadConfig();
			if (!array_get($cron_config_file, 'lock_time', false)) {
			    
			    $cron_minute = cron_helper::get_minute($_POST['cron_minute']);
			    	
			    if ($_POST['ttype'] == 'day') {
			        $cron_day = $_POST['cron_day'];
			        $cron_week = '';
			    } elseif ($_POST['ttype'] == 'week') {
			        $cron_day = 0;
			        $cron_week = $_POST['cron_week'];
			    
			        if ($cron_week == 7) {
			            $cron_week = 0;
			        }
			    
			    } else {
			        $cron_day = 0;
			        $cron_week = '';
			    }
			    
			    $cron_hour = $_POST['cron_hour'];
			    $cron = array('day' =>  $cron_day, 'week' => $cron_week, 'hour' => $cron_hour, 'm' => $cron_minute);
			    	
			    RC_Package::package('app::cron')->loadClass('cron_nexttime', false);
			    $next = cron_nexttime::make($cron)->getNextTime();
			    $data_time = array(
    				'nextime' 		=> $next,
    				'day' 			=> $cron_day,
    				'week' 			=> $cron_week,
    				'hour' 			=> $cron_hour,
    				'minute' 		=> $cron_minute,
			    );
			}
	
			$cron_name = !empty($_POST['cron_name']) ? $_POST['cron_name'] : '';
			$cron_desc = !empty($_POST['cron_desc']) ? $_POST['cron_desc'] : '';
			$cron_run_once = !empty($_POST['cron_run_once']) ? $_POST['cron_run_once'] : 0;
			$allow_ip = !empty($_POST['allow_ip']) ? $_POST['allow_ip'] : '';
			$alow_files = isset($_POST['alow_files']) ? implode(',', $_POST['alow_files']) : "";
			
			$data = array(
				'cron_name'		=> $cron_name,
				'cron_desc'		=> $cron_desc,
				'cron_config'	=> $cron_config,
				'run_once' 		=> $cron_run_once,
				'allow_ip' 		=> $allow_ip,
				'alow_files' 	=> $alow_files
			);
			$data = array_merge($data, $data_time);
		 	$cron_update = $this->db_crons->crons_update(array('cron_id' => $_POST['cron_id']), $data);
		 	
		 	ecjia_admin::admin_log($cron_name, 'edit', 'cron');
		 	if ($cron_update) {
		 		return $this->showmessage(RC_Lang::get('cron::cron.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin/edit', array('code' => $code))));
		 	} else {
		 		return $this->showmessage(RC_Lang::get('cron::cron.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		 	}
		}
	}
	
	/**
	 * 执行计划任务测试
	 */
	public function run() {
		$this->admin_priv('cron_run', ecjia::MSGTYPE_JSON);

		$cron = $this->db_crons->crons_find(array('cron_code' => $_GET['code']));
		if (empty($cron)) {
		    return $this->showmessage('Cron script not found.', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$handler = $this->cron_method->pluginInstance($cron['cron_code'], unserialize($cron['cron_config']));
		if (!$handler) {
		    return $this->showmessage($cron['cron_code'] . ' plugin not found!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$error = $handler->run();
		if (is_ecjia_error($error)) {
		    return $this->showmessage($error->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

 		$cron_name = $cron['cron_name'];
		$timestamp = RC_Time::gmtime();
		
		$data = array(
			'cron_code' => $_GET['code'],
			'thistime'  => $timestamp
		);
		
		$this->db_crons->crons_update(array('cron_code' => $_GET['code']), $data);
		ecjia_admin::admin_log($cron_name, 'run', 'cron');
		
		return $this->showmessage(RC_Lang::get('cron::cron.do_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('cron/admin/init')));
	}
	
	protected function app_list($alow_files) {
	    $apps = ecjia_app::installed_apps();
	    $alow_files = explode(',', $alow_files);
	    
	    $app_list = array();
	    foreach ($apps as $app) {
	        $app_list[] = array(
	        	'code' => $app['directory'],
	            'name' => $app['format_name'],
	            'checked' => in_array($app['directory'], $alow_files) ? 1 : 0,
	        );
	    }
	    return $app_list;
	}
}

//end