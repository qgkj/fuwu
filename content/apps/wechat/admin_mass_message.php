<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA群发消息
 */
class admin_mass_message extends ecjia_admin {
	private $wm_db;
	private $wechat_tag;
	private $wechat_user_db;
	private $wechat_mass;
	private $db_platform_account;
	
	public function __construct() {
		parent::__construct();
		
		RC_Lang::load('wechat');
		
		$this->wm_db = RC_Loader::load_app_model('wechat_media_model');
		$this->wechat_tag = RC_Loader::load_app_model('wechat_tag_model');
		$this->wechat_user_db = RC_Loader::load_app_model('wechat_user_model');
		$this->wechat_mass = RC_Loader::load_app_model('wechat_mass_history_model');
		
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
				
		RC_Script::enqueue_script('admin_mass_message', RC_App::apps_url('statics/js/admin_mass_message.js', __FILE__));
		RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/css/admin_material.css', __FILE__));
		
		RC_Script::localize_script('admin_mass_message', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.mass_message')));
	}

	public function init() {
		$this->admin_priv('wechat_message_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_message')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.send_message'));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			//查找所有标签 不包括黑名单
			$list = $this->wechat_tag->where(array('wechat_id' => $wechat_id))->where(array('tag_id' => array('neq' => 1)))->order(array('tag_id' => 'asc'))->select();

			$this->assign('list', $list);
			$this->assign('form_action', RC_Uri::url('wechat/admin_mass_message/mass_message'));
		}
		
		$this->assign_lang();
		$this->display('wechat_mass_message.dwt');
	}
	
	/**
	 * 群发消息处理
	 */
	public function mass_message() {
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_platform_first'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$tag_id 		= isset($_POST['tag_id']) 		? $_POST['tag_id'] 				: 0;
		$mass_type 		= isset($_POST['mass_type']) 	? $_POST['mass_type']			: '';
		$id				= isset($_POST['media_id']) 	? intval($_POST['media_id']) 	: 0;
		$content_type 	= isset($_POST['content_type']) ? $_POST['content_type'] 		: '';
		$content 		= isset($_POST['content']) 		? $_POST['content'] 			: '';
		
		$msg_data['type'] = $content_type;
		$field = 'media_id';
		
		if ($content_type == 'news') {
			$content_type = 'mpnews';
		} elseif ($content_type == 'video') {
			$content_type = 'mpvideo';
		} elseif ($content_type == 'image') {
			$field = 'thumb';
		}
		
		$type = 'media_id';
		//发送文本
		if ($content_type == 'text') {
			if (empty($content)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.text_must_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$media_id = $content;
			$type = 'content';
			$msg_data['content'] = $content;
		} else {
			if (empty($id)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.pls_select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$media_id = $this->wm_db->where(array('wechat_id' => $wechat_id, 'id' => $id))->get_field($field);
		}
		if ($mass_type == 'all') {
			//按全部用户群发
			$massmsg = array(
				'filter' => array('is_to_all' => true),
				$content_type => array(
					$type => $media_id
				),
				'msgtype' => $content_type
			);
		} else {
			//按标签进行群发
			$massmsg = array(
				'filter' => array(
					'is_to_all' => false,
					'tag_id'	=> $tag_id,
				),
				$content_type => array(
					$type => $media_id
				),
				'msgtype' => $content_type,
			);
		}
		$rs = $wechat->sendallMass($massmsg);
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		// 数据处理
		$msg_data['wechat_id'] 	= $wechat_id;
		$msg_data['media_id'] 	= $id;
		$msg_data['send_time'] 	= RC_Time::gmtime();
		$msg_data['msg_id'] 	= $rs['msg_id'];
		$mass_id = $this->wechat_mass->insert($msg_data);
		return $this->showmessage(RC_Lang::get('wechat::wechat.mass_task_info'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_mass_message/init')));
	}
	
	public function get_material_list() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$list = array();
		} else {
			$filter = $_GET['JSON'];
			$filter = (object)$filter;
			$type = isset($filter->type) ? $filter->type : '';
			
			if ($type == 'image') {
				$where[] = "(file is NOT NULL and (type = 'image' or type = 'news')) and wechat_id = $wechat_id and thumb != ''";
			} elseif ($type == 'news') {
				$where[] = "type = '$type' and parent_id = 0 and wechat_id = $wechat_id and media_id != ''";
			} else {
				$where[] = "(file is NOT NULL and type = '$type') and wechat_id = $wechat_id";
			}
			
			$list = $this->wm_db->where($where)->select();

			if (!empty($list)) {
				foreach ($list as $key => $val) {
					if ($type == 'news') {
						$list[$key]['children'] = $this->get_article_list($val['id'], $val['type']);
						$list[$key]['add_time'] =  RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $val['add_time']);
						$list[$key]['file'] = RC_Upload::upload_url($val['file']);
					} else {
						if (empty($val['file']) || $type == 'voice' || $type == 'video') {
							if (empty($val['file'])) {
								$list[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
							} elseif ($type == 'voice') {
								$list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
							} elseif ($type == 'video') {
								$list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
							}
						} else {
							$list[$key]['file'] = RC_Upload::upload_url($val['file']);
						}
						if (!empty($val['add_time'])) {
							$list[$key]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $val['add_time']);
						}
						if (empty($val['title'])) {
							$list[$key]['title'] = '';
						}
						if (!empty($val['size'])) {
							if ($val['size'] > (1024 * 1024)) {
								$list[$key]['size'] = round(($val['size'] / (1024 * 1024)), 1) . 'MB';
							} else {
								$list[$key]['size'] = round(($val['size'] / 1024), 1) . 'KB';
							}
						} else {
							$list[$key]['size'] = '';
						}
					}
					$list[$key]['type'] = $type;
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
	}
	
	public function get_material_info() {
		$filter = $_GET['JSON'];
		$filter = (object)$filter;
		$id     = $filter->id;
		$type   = $filter->type;
		
		$info = $this->wm_db->where(array('id' => $id))->find();
		$info['type'] = isset($info['type']) ? $info['type'] : '';
		
		if (empty($info['file']) || $info['type'] == 'voice' || $info['type'] == 'video') {
			if (empty($info['file'])) {
				$info['file'] = RC_Uri::admin_url('statics/images/nopic.png');
			} elseif ($info['type'] == 'voice') {
				$info['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
			} elseif ($info['type'] == 'video') {
				$info['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
			}
		} else {
			$info['file'] = RC_Upload::upload_url($info['file']);
		}
		
		$info['id'] = $id;
		if (isset($info['add_time'])) {
			$info['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $info['add_time']);
		}
		$content = !empty($info['digest']) ? strip_tags(html_out($info['digest'])) : strip_tags(html_out($info['content']));
			
		if (strlen($content) > 100) {
			$info['content'] = msubstr($content, 100);
		} else {
			$info['content'] = $content;
		}
		
		$is_articles = $this->wm_db->where(array('parent_id' => $id))->count();
		if ($type == 'news' && $is_articles != 0) {
			$info = $this->get_article_list($id, $info['type']);
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
	}
	
	/**
	 * 群发消息列表
	 */
	public function mass_list() {
		$this->admin_priv('wechat_message_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.send_record')));
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.send_record'));
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$this->assign('warn', 'warn');
			
			$type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('type', $type);
			$this->assign('type_error', sprintf(RC_Lang::get('wechat::wechat.notice_certification_info'), RC_Lang::get('wechat::wechat.wechat_type.'.$type)));
			
			$list = $this->get_mass_history_list();
			$this->assign('list', $list);
		}
		$this->assign_lang();
		$this->display('wechat_mass_list.dwt');
	}
	
	/**
	 * 群发消息删除 1发送成功 2发送失败 3发送错误 4已删除
	 */
	public function mass_del() {
		$this->admin_priv('wechat_message_manage', ecjia::MSGTYPE_JSON);

		$uuid             = platform_account::getCurrentUUID('wechat');
		$wechat           = wechat_method::wechat_instance($uuid);
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id        = $platform_account->getAccountID();
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$msg_id = $this->wechat_mass->where(array('id' => $id))->get_field('msg_id');
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.add_platform_first'));
		} else {
			$uuid = platform_account::getCurrentUUID('wechat');
			$wechat = wechat_method::wechat_instance($uuid);
			if (!empty($msg_id)) {
				$rs = $wechat->deleteMass($msg_id);
				if (RC_Error::is_error($rs)) {
					return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			$this->wechat_mass->where(array('id' => $id))->update(array('status' => '4'));
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
		
	/**
	 * 获取多图文信息
	 */
	private function get_article_list($id, $type) {
		$filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);
		$where[] = "type = '$type'";
		if ($id) {
			$where[] .= "parent_id = '$id' or id = '$id'";
		}
		$data = $this->wm_db->where($where)->order(array('id' => 'asc'))->select();
		$article['id'] = $id;
		
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				$article['ids'][$k] = $v['id'];
					
				if (!empty($v['file'])) {
					$article['file'][$k]['file'] = RC_Upload::upload_url($v['file']);
				} else {
					$article['file'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
				}
				$article['file'][$k]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_ymd'), $v['add_time']);
				$article['file'][$k]['title'] = strip_tags(html_out($v['title']));
				$article['file'][$k]['id'] = $v['id'];
				if (!empty($v['size'])) {
					if ($v['size'] > (1024 * 1024)) {
						$article['file'][$k]['size'] = round(($v['size'] / (1024 * 1024)), 1) . 'MB';
					} else {
						$article['file'][$k]['size'] = round(($v['size'] / 1024), 1) . 'KB';
					}
				} else {
					$article['file'][$k]['size'] = '';
				}
			}
		}
		return $article;
	}
	
	private function get_mass_history_list(){
		$mass_history = RC_Loader::load_app_model('wechat_mass_history_model');
		$media_model = RC_Loader::load_app_model('wechat_media_model');
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$count = $mass_history->count();
		$page = new ecjia_page($count, 10, 5);
		$list = $mass_history->where(array('wechat_id' => $wechat_id))->order('send_time DESC')->limit($page->limit())->select();
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				if ($val['type'] == 'news') {
					$list[$key]['children'] = $this->get_article_list($val['media_id'], $val['type']);
				} else {
					$info = $this->wm_db->find(array('wechat_id' => $wechat_id, 'id' => $val['media_id']));
					
					$list[$key]['file_name'] = $info['file_name'];
					if ($val['type'] == 'voice') {
						$list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
					} elseif ($val['type'] == 'video') {
						$list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
					} elseif ($val['type'] == 'image') {
						if (!empty($info['file'])) {
							$list[$key]['file'] = RC_Upload::upload_url($info['file']);
						}
					}
				}
				$list[$key]['send_time'] = RC_Time::local_date(ecjia::config('time_format'), $val['send_time']);
			}
		}
		return array ('list' => $list, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

//end