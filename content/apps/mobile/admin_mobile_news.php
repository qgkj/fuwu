<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia今日热点管理控制器
 */
class admin_mobile_news extends ecjia_admin {
	private $db_mobile_news;

	public function __construct() {
		parent::__construct();

		$this->db_mobile_news = RC_Model::model('mobile/mobile_news_model');

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		
		RC_Style::enqueue_style('mobile_news', RC_App::apps_url('statics/css/mobile.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('mobile_news', RC_App::apps_url('statics/js/mobile_news.js', __FILE__), array(), false, false);
		
		RC_Script::localize_script('mobile_news', 'js_lang', RC_Lang::get('mobile::mobile.js_lang'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_news'), RC_Uri::url('mobile/admin_mobile_news/init')));
	}

	/**
	 * 今日热点页面加载
	 */
	public function init () {
		$this->admin_priv('mobile_news_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.mobile_news')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.mobile_news_list'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.add_mobile_news'), 'href' => RC_Uri::url('mobile/admin_mobile_news/add')));
		
		$mobile_news = $this->get_mobile_news_list();
		$this->assign('mobile_news', $mobile_news);
		
		$this->display('mobile_news.dwt');
	}

	/**
	 * 添加展示页面
	 */
	public function add() {
		$this->admin_priv('mobile_news_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.add_mobile_news')));
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.add_mobile_news'));
		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/insert'));
		
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 添加执行
	 */
	public function insert() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$post = $_POST;
		if (!empty($post)) {
			$group_id = 0;
			foreach ($post['title'] as $key => $val) {
				$image_url = '';
				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
						'name'		=> $_FILES['image_url']['name'][$key],
						'type'		=> $_FILES['image_url']['type'][$key],
						'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
						'error'		=> $_FILES['image_url']['error'][$key],
						'size'		=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
						$image_url = $upload->get_position($info);
					} else {
						return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				} else {
					return $this->showmessage(RC_Lang::get('mobile::mobile.upload_file_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}

				$data = array (
					'group_id'		=> $group_id,
					'title'			=> $post['title'][$key],
					'description'	=> $post['description'][$key],
					'content_url'	=> $post['content_url'][$key],
					'image'			=> $image_url,
					'type'			=> 'article',
					'create_time'	=> RC_Time::gmtime(),
				);

				if ($key == 0) {
					$group_id = $this->db_mobile_news->mobile_news_manage($data);
				} else {
					$this->db_mobile_news->mobile_news_manage($data);
				}
				ecjia_admin::admin_log($data['title'], 'add', 'mobile_news');
			}
		}

		$links[] = array('text' => RC_Lang::get('mobile::mobile.return_mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		return $this->showmessage(RC_Lang::get('mobile::mobile.add_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', 'id='.$group_id)));
	}

	/**
	 * 编辑显示页面
	 */
	public function edit() {
		$this->admin_priv('mobile_news_update');
		
		$this->assign('ur_here', RC_Lang::get('mobile::mobile.edit_mobile_news'));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('mobile::mobile.edit_mobile_news')));
		
		$id = $_GET['id'];
		$mobile_news = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->orderby('id', 'asc')->get();

		if (!empty($mobile_news)) {
			foreach ($mobile_news as $key => $val) {
				if ($val['group_id'] == 0) {
					$mobile_news_status = $val['status'];
				}
				if (substr($val['image'], 0, 4) != 'http') {
					$mobile_news[$key]['image'] = RC_Upload::upload_url() . '/' . $val['image'];
				}
			}
		}

		$this->assign('action_link', array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init')));
		$this->assign('form_action', RC_Uri::url('mobile/admin_mobile_news/update'));
		$this->assign('mobile_news', $mobile_news);
		$this->assign('mobile_news_id', $id);
		$this->assign('mobile_news_status', $mobile_news_status);
		
		$this->display('mobile_news_edit.dwt');
	}

	/**
	 * 编辑及提交处理
	 */
	public function update() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$post 		= $_POST;
		$group_id 	= !empty($_POST['group_id']) 	? $_POST['group_id'] 	: 0;
		$id 		= !empty($_POST['id']) 			? intval($_POST['id']) 	: 0;
		
		$group_news = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->lists('id');
		
		if (!empty($post)) {
			foreach ($post['title'] as $key => $val) {
				$data = array (
					'group_id'		=> $key == $id ? 0 : $id,
					'title'			=> $post['title'][$key],
					'description'	=> $post['description'][$key],
					'content_url'	=> $post['content_url'][$key],
					'type'			=> 'article',
				);

				/* 处理上传的LOGO图片 */
				if ((isset($_FILES['image_url']['error'][$key]) && $_FILES['image_url']['error'][$key] == 0) ||(!isset($_FILES['image_url']['error'][$key]) && isset($_FILES['image_url']['tmp_name'][$key]) && $_FILES['image_url']['tmp_name'][$key] != 'none')) {
					$upload = RC_Upload::uploader('image', array('save_path' => 'data/mobile_news', 'auto_sub_dirs' => false));
					$file = array(
						'name'		=> $_FILES['image_url']['name'][$key],
						'type'		=> $_FILES['image_url']['type'][$key],
						'tmp_name'	=> $_FILES['image_url']['tmp_name'][$key],
						'error'		=> $_FILES['image_url']['error'][$key],
						'size'		=> $_FILES['image_url']['size'][$key]
					);
					$info = $upload->upload($file);
					if (!empty($info)) {
						$image = $this->db_mobile_news->mobile_news_field(array('id' => $key), 'image');
						$upload->remove($image);
						$image_url 		= $upload->get_position($info);
						$data['image'] 	= $image_url;
					} else {
						return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
				}

				if (in_array($key, $group_news)) {
					$this->db_mobile_news->mobile_news_manage($data, array('id' => $key));
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				} else {
					$data['create_time'] = RC_Time::gmtime();
					$this->db_mobile_news->mobile_news_manage($data);
					ecjia_admin::admin_log($data['title'], 'edit', 'mobile_news');
				}
			}
		}
		$links[] = array('text' => RC_Lang::get('mobile::mobile.mobile_news_list'), 'href' => RC_Uri::url('mobile/admin_mobile_news/init'));
		return $this->showmessage(RC_Lang::get('mobile::mobile.edit_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}

	/**
	 * 删除今日热点
	 */
	public function remove() {
		$this->admin_priv('mobile_news_delete', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$info = RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->get();
		
		foreach ($info as $v) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path() . $v['image']);
		}
		$title = $this->db_mobile_news->mobile_news_field(array('id' => $id), 'title');
		
		RC_DB::table('mobile_news')->where('id', $id)->orWhere('group_id', $id)->delete();

		ecjia_admin::admin_log($title, 'remove', 'mobile_news');
		return $this->showmessage(RC_Lang::get('mobile::mobile.remove_mobile_news_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 发布
	 */
	public function issue() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);

		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$this->db_mobile_news->mobile_news_manage(array('status' => 1), array('id' => $id, 'group_id' => 0));
		
		return $this->showmessage(RC_Lang::get('mobile::mobile.issue_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}

	/**
	 * 取消发布
	 */
	public function unissue() {
		$this->admin_priv('mobile_news_update', ecjia::MSGTYPE_JSON);
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$this->db_mobile_news->mobile_news_manage(array('status' => 0), array('id' => $id, 'group_id'=> 0));
		
		return $this->showmessage(RC_Lang::get('mobile::mobile.cancel_issue_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('mobile/admin_mobile_news/edit', array('id' => $id))));
	}
	
	/**
	 * 获取今日热点列表
	 * @return array
	 */
	private function get_mobile_news_list() {
		$db_mobile_news = RC_Model::model('mobile/mobile_news_model');
		
		$db_mobile_news = RC_DB::table('mobile_news');
		$db_mobile_news->where('group_id', 0)->where('type', 'article');
		
		$count  = $db_mobile_news->count();
		$page   = new ecjia_page($count, 10, 5);
		$result = $db_mobile_news->orderby('id', 'asc')->take(10)->skip($page->start_id-1)->get();
		
	
		$mobile_news = array();
		if (!empty($result)) {
			foreach ($result as $key => $val) {
				$db_mobile_child = RC_DB::table('mobile_news');
				if (!empty($val['image'])) {
					if (substr($val['image'], 0, 4) != 'http') {
						$val['image'] = RC_Upload::upload_url() . '/' . $val['image'];
					}
				}
				$mobile_news[$key] = array(
					'id'			=> $val['id'],
					'title'			=> $val['title'],
					'description' 	=> $val['description'],
					'image'		  	=> $val['image'],
					'content_url' 	=> $val['content_url'],
					'create_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $val['create_time']),
				);
			
				$child_result = $db_mobile_child->where('group_id', $val['id'])->where('type', 'article')->orderby('id', 'asc')->get();
				
				if (!empty($child_result)) {
					foreach ($child_result as $v) {
						if (!empty($v['iamge'])) {
							if (substr($v['image'], 0, 4) != 'http') {
								$v['image'] = RC_Upload::upload_url() . '/' . $v['image'];
							}
						}
						$mobile_news[$key]['children'][] = array(
							'id'			=> $v['id'],
							'title'			=> $v['title'],
							'description' 	=> $v['description'],
							'image'		  	=> $v['image'],
							'content_url' 	=> $v['content_url'],
							'create_time' 	=> RC_Time::local_date(ecjia::config('time_format'), $v['create_time']),
						);
					}
				}
			}
		}
		return array('item' => $mobile_news, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
}

// end
