<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 移动设备管理
*/
class admin_device extends ecjia_admin {
	private $db_device;
	
	public function __construct() {
		parent::__construct();

		/* 数据模型加载 */
		$this->db_device = RC_Model::model('mobile/mobile_device_model');
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'), array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Script::enqueue_script('media-editor', RC_Uri::vendor_url('tinymce/tinymce.min.js'), array(), false, true);
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('device', RC_App::apps_url('statics/js/device.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::localize_script('device', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device_manage'), RC_Uri::url('mobile/admin_device/init')));
	}
	
	/**
	 * 移动设备列表
	 */
	public function init() {
		$this->admin_priv('device_manage');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_device_list'));
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_device_manage')));
		
		$device_list = $this->get_device_list();
		$this->assign('device_list', $device_list);
		$this->assign('search_action', RC_Uri::url('mobile/admin_device/init'));
				
		$this->display('device_list.dwt');
	}

	/**
	 * 移至回收站
	 */
	public function trash()  {
		$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		$success = $this->db_device->device_update($id, array('in_status' => 1));
		
		$info = $this->db_device->device_find($id);
		
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'trash', 'mobile_device');
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.trash_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.trash_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 从回收站还原
	 */
	public function returndevice()  {
		$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
	
		$id = intval($_GET['id']);
		$success = $this->db_device->device_update($id, array('in_status' => 0));
		
		$info = $this->db_device->device_find($id);
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'restore', 'mobile_device');
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.restore_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.restore_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除移动设备
	 */
	public function remove()  {
		$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
		
		$id = intval($_GET['id']);
		$deviceval = intval($_GET['deviceval']);
		
		$info = $this->db_device->device_find($id);
	    if ($info['device_client'] == 'android') {
            $info['device_client'] = 'Android';
        } elseif ($info['device_client'] == 'iphone') {
            $info['device_client'] = 'iPhone';
        } elseif ($info['device_client'] == 'ipad') {
            $info['device_client'] = 'iPad';
        }
		
		$success = $this->db_device->device_delete($id);
		ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_name']), 'remove', 'mobile_device');
		
		if ($success){
			return $this->showmessage(RC_Lang::get('mobile::mobile.del_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.del_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 批量删除设备
	 */
	public function batch(){
		$action    = trim ($_GET['sel_action']);
		$deviceval = intval($_GET['deviceval']);
		
		if ($action == 'del') {
			$this->admin_priv('device_delete', ecjia::MSGTYPE_JSON);
		} else {
			$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
		}
		$ids  = $_POST['id'];
		$ids  = explode(',', $ids);
		$info = $this->db_device->device_select($ids, true);
		
		foreach ($info as $k => $rows) {
		    if ($rows['device_client'] == 'android') {
                $info[$k]['device_client'] = 'Android';
            } elseif ($rows['device_client'] == 'iphone') {
                $info[$k]['device_client'] = 'iPhone';
            } elseif ($rows['device_client'] == 'ipad'){
                $info[$k]['device_client'] = 'iPad';
            }
		}
		
		switch ($action) {
			case 'trash':
				$data = array(
					'in_status' => 1
				);
				$this->db_device->device_update($ids, $data, true);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_trash', 'mobile_device');
				}
				break;
				
			case 'returndevice':
				$data = array(
					'in_status' => 0
				);
				$this->db_device->device_update($ids, $data, true);
				
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_restore', 'mobile_device');
				}
				break;
					
			case 'del':
				$this->db_device->device_delete($ids, true);
				foreach ($info as $v) {
					ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $v['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $v['device_name']), 'batch_remove', 'mobile_device');
				}
				break;
				
			default :
				break;
		}
		return $this->showmessage(RC_Lang::get('mobile::mobile.batch_handle_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_device/init', array('deviceval' => $deviceval))));
	}
	
	/**
	 * 预览
	 */
	public function preview() {
		$this->admin_priv('device_detail');
	
		$id = intval($_GET['id']);
	
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.view_device_info'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_device_list'), 'href' => RC_Uri::url('mobile/admin_device/init')));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.view_device_info')));

		$device                = $this->db_device->device_find($id);
		$device['add_time']    = RC_Time::local_date(ecjia::config('time_format'), $device['add_time']);
		$device['update_time'] = RC_Time::local_date(ecjia::config('time_format'), $device['update_time']);
		
	    if ($device['device_client'] == 'android') {
            $device['device_client'] = 'Android';
        } elseif ($device['device_client'] == 'iphone') {
            $device['device_client'] = 'iPhone';
        } elseif ($device['device_client'] == 'ipad') {
            $device['device_client'] = 'iPad';
        }
		$this->assign('device', $device);

		$this->display('preview.dwt');
	}
	
	/**
	 * 编辑设备别名
	 */
	public function edit_device_alias() {
		$this->admin_priv('device_update', ecjia::MSGTYPE_JSON);
	
		$id           = intval($_POST['pk']);
		$device_alias = !empty($_POST['value']) ? trim($_POST['value']) : '';
		
		if (empty($device_alias)) {
			return $this->showmessage(RC_Lang::get('mobile::mobile.device_alias_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$query = $this->db_device->device_update($id, array('device_alias' => $device_alias));
		if ($query) {
			$info = $this->db_device->device_find($id);
		    if ($info['device_client'] == 'android') {
	            $info['device_client'] = 'Android';
	        } elseif ($info['device_client'] == 'iphone') {
	            $info['device_client'] = 'iPhone';
	        } elseif ($info['device_client'] == 'ipad') {
	            $info['device_client'] = 'iPad';
	        }
			ecjia_admin::admin_log(sprintf(RC_Lang::get('mobile::mobile.device_type_is'), $info['device_client']).'，'.sprintf(RC_Lang::get('mobile::mobile.device_name_is'), $info['device_udid']).'，'.sprintf(RC_Lang::get('mobile::mobile.edit_device_alias_as'), $device_alias), 'setup', 'mobile_device');
			return $this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('mobile::mobile.edit_device_alias_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 取得设备列表
	 *
	 * @return  array
	 */
	private function get_device_list() {
		$device_db = RC_DB::table('mobile_device');
		
		$where = $filter = array();
		$filter['keywords'] 	= empty($_GET['keywords']) 	? '' 	: trim($_GET['keywords']);
		$filter['deviceval']	= empty($_GET['deviceval']) ? 0 	: intval($_GET['deviceval']);
	
		if ($filter['keywords']) {
			$device_db->where('device_name', 'like', '%' . mysql_like_quote($filter['keywords']) . '%');
		}
		
		$msg_count = $device_db
			->selectRaw("SUM(IF(in_status=0,1,0)) AS count,
				SUM(IF(device_client='android' and device_code !='8001' and in_status = 0,1,0)) AS android,
				SUM(IF(device_client='iphone' and in_status = 0,1,0)) AS iphone,
				SUM(IF(device_client='ipad' and in_status = 0,1,0)) AS ipad,
				SUM(IF(device_client='android' and device_code='8001' and in_status = 0,1,0)) AS cashier,
				SUM(IF(in_status = 1,1,0)) AS trashed")
			->first();
		
		$msg_count = array(
			'count'		=> empty($msg_count['count']) 	? 0 : $msg_count['count'],
			'android'	=> empty($msg_count['android']) ? 0 : $msg_count['android'],
			'iphone'	=> empty($msg_count['iphone']) 	? 0 : $msg_count['iphone'],
			'ipad'	    => empty($msg_count['ipad']) 	? 0 : $msg_count['ipad'],
			'cashier'	=> empty($msg_count['cashier']) ? 0 : $msg_count['cashier'],
			'trashed'	=> empty($msg_count['trashed']) ? 0 : $msg_count['trashed']
		);
	
		$android = 'android';
		if ($filter['deviceval'] == 1) {
			$device_db->where('device_client', $android)->where('device_code', '!=', 8001)->where('in_status', 0);
		}
	
		$iphone = 'iphone';
		if ($filter['deviceval'] == 2) {
			$device_db->where('device_client', $iphone)->where('in_status', 0);
		}
	
		$ipad = 'ipad';
		if ($filter['deviceval'] == 3) {
			$device_db->where('device_client', $ipad)->where('in_status', 0);
		}
	
		$cashier = 'android';
		if ($filter['deviceval'] == 4) {
			$device_db->where('device_client', $cashier)->where('device_code', 8001)->where('in_status', 0);
		}
		
		if ($filter['deviceval'] == 0) {
			$device_db->where('in_status', 0);
		}
		
		if ($filter['deviceval'] == 5) {
			$device_db->where('in_status', 1);
		}

		$count = $device_db->count('id');
		$page = new ecjia_page($count, 10, 5);
	
		$data = $device_db->select('*')->orderby('id', 'desc')->take(10)->skip($page->start_id-1)->get();
		
		$arr = array();
		if (!empty($data)) {
			foreach ($data as $rows) {
				$rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
				if ($rows['device_client'] == 'android') {
					$rows['device_client'] = 'Android';
				} elseif ($rows['device_client'] == 'iphone') {
					$rows['device_client'] = 'iPhone';
				} elseif ($rows['device_client'] == 'ipad'){
					$rows['device_client'] = 'iPad';
				}
				$arr[] = $rows;
			}
		}
		return array('device_list' => $arr, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'msg_count' => $msg_count);
	}
}

// end