<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA消息模块
 */
class admin extends ecjia_admin {

	private $db_push;
	public function __construct() {
		parent::__construct();
		
		$this->db_push = RC_Model::model('push/push_message_model');
		RC_Loader::load_app_class('push_send', null, false);
		
		RC_Loader::load_app_class('mobile_manage','mobile', false);
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('push', RC_App::apps_url('statics/js/push.js', __FILE__), array(), false, true);
		RC_Style::enqueue_style('push_event', RC_App::apps_url('statics/css/push_event.css', __FILE__), array(), false, false);
		
		RC_Script::localize_script('push', 'js_lang', RC_Lang::get('push::push.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_record'), RC_Uri::url('push/admin/init')));
	}

	/**
	 * 显示发送记录的
	 */
	public function init() {
		$this->admin_priv('push_history_manage');
		
		$appid = isset($_GET['appid']) ? trim($_GET['appid']) : '';
		
		$applistdb = $this->get_applist();
		if (!empty($applistdb['item'])) {
			foreach ($applistdb['item'] as $key => $val) {
				$appcount = $this->db_push->where(array('app_id' =>$val['app_id']))->count();
				$applistdb['item'][$key]['count'] = $appcount;
			}
			if(empty($appid)) {
				$appid = $applistdb['item'][0]['app_id'];
			}
		}
		
		$listdb = $this->get_pushlist($appid);
		$this->assign('listdb', $listdb);
		
		$this->assign('search_action', RC_Uri::url('push/admin/init'));
		$this->assign('applistdb',$applistdb);
		
		if (!empty($appid)) {
			$this->assign('action_link', array('text' => RC_Lang::get('push::push.add_msg_push'), 'href'=> RC_Uri::url('push/admin/push_add', array('appid' => $appid))));
		}
		$this->assign('ur_here', RC_Lang::get('push::push.msg_record_list'));
	
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_record')));
	
		$this->assign('appid', $appid);
		$this->assign('search_action', RC_Uri::url('push/admin/init'));
	
		$this->display('push_send_history.dwt');
	}
					
	/**
	 * 发送消息页面
	 */
	public function push_add() {
		$this->admin_priv('push_message');
		$appid = isset($_GET['appid']) ? trim($_GET['appid']) : '';
		
		if (empty($appid)) {
			return $this->showmessage(RC_Lang::get('push::push.pls_push_app'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_push')));
		$this->assign('ur_here', RC_Lang::get('push::push.add_msg_push'));
		$this->assign('action_link', array('text' => RC_Lang::get('push::push.msg_record_list'), 'href' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		
		$device_list = $this->get_device_name();
		$this->assign('device_list', $device_list);
		$this->assign('action', 'add');
		$this->assign('appid', $appid);
		
		$extradata['open_type'] = 'main';
		$extradata['target'] = 0;
		
		$this->assign('extradata', $extradata);
		$this->assign('target', $extradata['target']);
		$this->assign('form_action', RC_Uri::url('push/admin/push_insert'));
		
		$this->display('push_send.dwt');
	}
	
	/**
	 *copy消息页面
	 */
	public function push_copy() {
		$this->admin_priv('push_message');
		
		$message_id = intval($_GET['message_id']);
		$appid = RC_Model::model('push/push_message_model')->where(array('message_id' => $message_id))->get_field('app_id');
		if (!$appid) {
			return $this->showmessage(RC_Lang::get('push::push.message_not_exists'));
		}
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('push::push.msg_push')));
		$this->assign('ur_here', RC_Lang::get('push::push.add_msg_push'));
		$this->assign('action_link', array('text' => RC_Lang::get('push::push.msg_record_list'), 'href' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		
		$device_list = $this->get_device_name();
		$this->assign('device_list', $device_list);
		
		$push = $this->db_push->find(array('message_id' => $message_id));
		
		$extradata = unserialize($push['extradata']);
		unset($push['extradata']);
		foreach ($extradata as $key => $val){
			$push[$key] = $val;
		}
		$this->assign('extradata', $push['extra_fields']);

		if ($push['extra_fields']['open_type'] == 'webview') {
			$push['url'] = $push['extra_fields']['url'];
		} elseif ($push['extra_fields']['open_type'] == 'search') {
			$push['keyword'] = $push['extra_fields']['keyword'];
		} elseif ($push['extra_fields']['open_type'] == 'goods_comment' || $push['extra_fields']['open_type'] == 'goods_detail') {
			$push['goods_id'] = $push['extra_fields']['goods_id'];
		} elseif ($push['extra_fields']['open_type'] == 'orders_detail') {
			$push['order_id'] = $push['extra_fields']['order_id'];
		} elseif ($push['extra_fields']['open_type'] == 'goods_list') {
			$push['category_id'] = $push['extra_fields']['category_id'];
		}

		$this->assign('push', $push);
		$this->assign('appid', $appid);
		$this->assign('form_action', RC_Uri::url('push/admin/push_insert'));

		$this->display('push_send.dwt');
	}
			
	/**
	 * 发送消息处理
	 * target 推送对象
	 * 所有人：0
	 * 单播：1
	 * 用户：2
	 * 管理员：3
	 * 
	 * action 推送行为
	 */
	public function push_insert() {
		$this->admin_priv('push_message', ecjia::MSGTYPE_JSON);
	
		$appid          = intval($_POST['appid']);
		if (empty($appid)) {
			return $this->showmessage(RC_Lang::get('push::push.pls_push_app'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
		}
		
		$app            = mobile_manage::make($appid);
		$device_client	= $app->getClient();
		$device_code	= $app->getCode();
		
		$title	        = trim($_POST['title']);
		$content		= trim($_POST['content']);
		$priority		= intval($_POST['priority']);
		$target		    = intval($_POST['target']);//推送对象
		$device_token   = $_POST['device_token'];//Device Token
		$user_id		= intval($_POST['user_id']);//用户id
		$admin_id	    = intval($_POST['admin_id']);//管理员id
		
		$action		    = $_POST['action'];//推送行为
		
		if ($action) {
		    $custom_fields = array('open_type' => $action);
		}
		
		if ($action == 'webview') {
			$url			= $_POST['url'];//网址
			if (empty($url)) {
				return $this->showmessage(RC_Lang::get('push::push.url_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['url'] = $url;
		} elseif ($action == 'search') {
			$keyword		= $_POST['keyword'];//关键字
			if (empty($keyword)) {
				return $this->showmessage(RC_Lang::get('push::push.keywords_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['keyword'] = $keyword;
		} elseif ($action == 'goods_list') {
			$category_id	= intval($_POST['category_id']);//商品分类ID
			if (empty($category_id)) {
				return $this->showmessage(RC_Lang::get('push::push.category_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['category_id'] = $category_id;
		} elseif ($action == 'goods_comment' || $action == 'goods_detail') {
			$goods_id		= intval($_POST['goods_id']);//商品ID
			if (empty($goods_id)) {
				return $this->showmessage(RC_Lang::get('push::push.goods_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['goods_id'] = $goods_id;
		} elseif ($action == 'orders_detail') {
			$order_id		= intval($_POST['order_id']);//订单ID
			if (empty($order_id)) {
				return $this->showmessage(RC_Lang::get('push::push.order_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['order_id'] = $order_id;
		} elseif ($action == 'seller') {
			$seller_category = intval($_POST['seller_category']);//店铺街分类
			if (!empty($seller_category)) {
				$custom_fields['category_id'] = $seller_category;
			}
		} elseif ($action == 'merchant' || $action == 'merchant_detail') {
			$merchant_id = intval($_POST['merchant_id']);
			if (empty($merchant_id)) {
				return $this->showmessage(RC_Lang::get('push::push.merchant_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['merchant_id'] = $merchant_id;
		} elseif ($action == 'merchant_goods_list') {
			$merchant_id = intval($_POST['merchant_id']);
			$goods_category_id = intval($_POST['goods_category_id']);
			if (empty($merchant_id)) {
				return $this->showmessage(RC_Lang::get('push::push.merchant_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} elseif (empty($goods_category_id)) {
				return $this->showmessage(RC_Lang::get('push::push.category_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['open_type']   = 'merchant';
			$custom_fields['merchant_id'] = $merchant_id;
			$custom_fields['category_id'] = $goods_category_id;
		} elseif ($action == 'merchant_suggest_list') {
			$merchant_id = intval($_POST['merchant_id']);
			$suggest_type = trim($_POST['suggest_type']);
			if (empty($merchant_id)) {
				return $this->showmessage(RC_Lang::get('push::push.merchant_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			} elseif (!in_array($suggest_type, array('best', 'new', 'hot'))) {
				return $this->showmessage(RC_Lang::get('push::push.suggest_type_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$custom_fields['open_type']   = 'merchant';
			$custom_fields['merchant_id'] = $merchant_id;
			$custom_fields['type']        = $suggest_type;
		}
		
		if ($target == 3 || $target == 2) {
		    if ($target == 3) {
		        if (empty($admin_id)) {
		            return $this->showmessage(RC_Lang::get('push::push.admin_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		        
		        $device_info = RC_Api::api('mobile', 'device_info', array('user_id' => $admin_id, 'user_type' => 'admin', 'device_code' => $device_code));
		        if (empty($device_info)) {
		            return $this->showmessage(RC_Lang::get('push::push.device_info_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    } elseif ($target == 2) {
		    	
		        if (empty($user_id)) {
		            return $this->showmessage(RC_Lang::get('push::push.user_id_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		        
		        $device_info = RC_Api::api('mobile', 'device_info', array('user_id' => $user_id, 'user_type' => 'user', 'device_code' => $device_code));
		        
		        if (empty($device_info)) {
		            return $this->showmessage(RC_Lang::get('push::push.device_info_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		    }
		    
		    if ($device_info['device_client'] == 'android') {
		    	$result = push_send::make($appid)->set_client(push_send::CLIENT_ANDROID)->set_field($custom_fields)->send($device_info['device_token'], $title, $content, 0, $priority);
		    } elseif ($device_info['device_client'] == 'iphone') {
		    	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPHONE)->set_field($custom_fields)->send($device_info['device_token'], $title, $content, 0, $priority);
		    } elseif($device_info['device_client'] == 'ipad') {
		    	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPAD)->set_field($custom_fields)->send($device_info['device_token'], $title, $content, 0, $priority);
		    }
		} else {
		    if (empty($device_client)) {
		        return $this->showmessage(RC_Lang::get('push::push.device_client_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		    } 
		    
		    if ($target == 1) {
		        if (empty($device_token)) {
		            return $this->showmessage(RC_Lang::get('push::push.device_token_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		        
		        $token_len = strlen($device_token);
		        if ($device_client == push_send::CLIENT_ANDROID && $token_len != 44) {
		            return $this->showmessage(RC_Lang::get('push::push.device_token_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        } elseif (($device_client == push_send::CLIENT_IPHONE && $token_len != 64) || ($device_client == push_send::CLIENT_IPAD && $token_len != 64)) {
		            return $this->showmessage(RC_Lang::get('push::push.device_token_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		        }
		        
		        if ($device_client == 'android') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_ANDROID)->set_field($custom_fields)->send($device_token, $title, $content, 0, $priority);
		        } elseif ($device_client == 'iphone') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPHONE)->set_field($custom_fields)->send($device_token, $title, $content, 0, $priority);
		        } elseif($device_client == 'ipad') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPAD)->set_field($custom_fields)->send($device_token, $title, $content, 0, $priority);
		        }
		    } else {
		    	if ($device_client == 'android') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_ANDROID)->set_field($custom_fields)->broadcast_send($title, $content, 0, $priority);
		        } elseif ($device_client == 'iphone') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPHONE)->set_field($custom_fields)->broadcast_send($title, $content, 0, $priority);
		        } elseif($device_client == 'ipad') {
		        	$result = push_send::make($appid)->set_client(push_send::CLIENT_IPAD)->set_field($custom_fields)->broadcast_send($title, $content, 0, $priority);
		        }
		    }
		}

		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage(RC_Lang::get('push::push.msg_push_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		}
	}
	
	/**
	 * 删除消息记录
	 */
	public function remove() {
		$this->admin_priv('push_delete', ecjia::MSGTYPE_JSON);

		$message_id = intval($_GET['message_id']);
		$this->db_push->push_message_remove($message_id);
		
		return $this->showmessage(RC_Lang::get('push::push.remove_msg_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 推送消息
	 */
	public function push() {
		$this->admin_priv('push_message', ecjia::MSGTYPE_JSON);
	
		$message_id = intval($_GET['message_id']);
		
		$appid = RC_Model::model('push/push_message_model')->where(array('message_id' => $message_id))->get_field('app_id');
		if (!$appid) {
			return $this->showmessage(RC_Lang::get('push::push.message_not_exists'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$result = push_send::make($appid)->resend($message_id);
	
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		} else {
			return $this->showmessage(RC_Lang::get('push::push.msg_push_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		}
	}
	
	/**
	 * 批量推送消息
	 */
	public function batch_resend() {
		$this->admin_priv('push_message', ecjia::MSGTYPE_JSON);
	
		$messageids = explode(",", $_POST['message_id']);
		$appid = $_GET['appid'];
		push_send::make($appid)->batch_resend($messageids);
		
		return $this->showmessage(RC_Lang::get('push::push.batch_push_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
	}
	
	/**
	 * 批量删除消息记录
	 */
	public function batch(){
		$this->admin_priv('push_delete', ecjia::MSGTYPE_JSON);
		
		$success = $this->db_push->in(array('message_id' => $_POST['message_id']))->delete();
		$appid = $_GET['appid'];
		if ($success) {
			return $this->showmessage(RC_Lang::get('push::push.batch_drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('push/admin/init', array('appid' => $appid))));
		}
	}
	
	/**
	 * 获取所有device_name
	 */
	private function get_device_name() {
		return array('Android', 'iPhone', 'iPad');
	}
	
	private function get_applist() {
		$arr = array();
		$umeng_push = 'umeng-push';
		$applist= mobile_manage::getMobileAppList($umeng_push);
	
		if (!empty($applist)) {
			foreach ($applist as $rows) {
				$arr[] = $rows;
			}
		}
		return array('item' => $arr);
	}
	
	/**
	 * 消息记录
	 */
	private function get_pushlist($appid) {
		$dbpush = RC_Model::model('push/push_message_model');
	
		$where = array();
	
		$filter['keywords'] = empty($_GET['keywords']) ? '' : trim($_GET['keywords']);
		$filter['appid'] = intval($appid);
		$status = isset($_GET['status']) ? intval($_GET['status']) : '';
		$filter['in_status'] = '';
		
		if(is_int($status) && $status >= 0){
			$where['in_status']   =  $status;
			$filter['in_status']  =  $status;
		}
	
		if ($filter['keywords']) {
			$where[] = "title LIKE '%" . mysql_like_quote($filter['keywords']) . "%'";
		}
	
		$where['app_id'] = $filter['appid'];
	
		$count = $dbpush->where($where)->count();
		RC_Loader::load_sys_class('ecjia_page', false);
		$page = new ecjia_page($count, 15, 6);
	
		$row = $dbpush->where($where)->order(array('add_time'=>'desc'))->limit($page->limit())->select();
	
		if (!empty($row)) {
			foreach ($row AS $key => $val) {
				$row[$key]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['add_time']);
				$row[$key]['push_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['push_time']);
			}
		}
	
		$arr = array('item' => $row, 'filter' => $filter, 'page' => $page->show(5), 'desc' => $page->page_desc());
		return $arr;
	}
}

//end