<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商家公告
 */
class admin_notice extends ecjia_admin {
	
	public function __construct() {
		parent::__construct();
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js') , array(), false, false);
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'), array(), false, false);
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		RC_Script::enqueue_script('store_notice', RC_App::apps_url('statics/js/store_notice.js', __FILE__), array(), false, true);
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商家公告', RC_Uri::url('store/admin_notice/init')));
	}
	
	/**
	 * 商家公告文章列表
	 */
	public function init() {
		$this->admin_priv('store_notice_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('商家公告'));
		
		$this->assign('ur_here', '商家公告');
		$this->assign('action_link', array('text' => '发布商家公告', 'href'=> RC_Uri::url('store/admin_notice/add')));
		$this->assign('list', $this->get_notice_list());
		
		$this->display('store_notice_list.dwt');
	}
	
	/**
	 * 添加商家公告
	 */
	public function add() {
		$this->admin_priv('store_notice_update');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('发布商家公告'));
		
		$this->assign('ur_here', '发布商家公告');
		$this->assign('action_link', array('text' => '商家公告', 'href'=> RC_Uri::url('store/admin_notice/init')));
		
		$this->assign('form_action', RC_Uri::url('store/admin_notice/insert'));
		$this->display('store_notice_info.dwt');
	}
	
	public function insert() {
		$this->admin_priv('store_notice_update', ecjia::MSGTYPE_JSON);
		
		$title    	= !empty($_POST['title'])       ? trim($_POST['title'])         : '';
		$content  	= !empty($_POST['content'])     ? trim($_POST['content'])       : '';
		$keywords	= !empty($_POST['keywords'])    ? trim($_POST['keywords'])      : '';
		$desc    	= !empty($_POST['description']) ? trim($_POST['description'])   : '';
		$file		= !empty($_FILES['file']) 		? $_FILES['file'] 				: '';
		
 		$is_only = RC_DB::table('article as a')
     			->leftJoin('article_cat as ac', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('ac.cat_id'))
     			->where('title', $title)
     			->where(RC_DB::raw('ac.cat_type'), 6)
     			->count();
 			
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$file_name = '';
		//判断用户是否选择了文件
		if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
			$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
			$upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
			$upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg'));
			$image_info = $upload->upload($file);
			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$file_name = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		$cat_id = RC_DB::table('article_cat')->where('cat_type', 6)->pluck('cat_id');
		
		$data = array(
			'title' 	   	=> $title,
			'cat_id'   		=> $cat_id,
			'content'  		=> $content,
			'keywords'  	=> $keywords,
			'file_url'		=> $file_name,
			'description'  	=> $desc,
			'add_time' 		=> RC_Time::gmtime(),
		);
		$id = RC_DB::table('article')->insertGetId($data);

		ecjia_admin::admin_log($title, 'add', 'merchant_notice');
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.articleadd_succeed'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 编辑商家公告
	 */
	public function edit() {
		$this->admin_priv('store_notice_update');
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('编辑商家公告'));
		
		$this->assign('ur_here', '编辑商家公告');
		$this->assign('action_link', array('text' => '商家公告', 'href'=> RC_Uri::url('store/admin_notice/init')));
		
		$id   = intval($_GET['id']);
		$info = RC_DB::table('article')->where('article_id', $id)->first();

		if (!empty($info['content'])) {
			$info['content'] = stripslashes($info['content']);
		}

		if (!empty($info['file_url']) && file_exists(RC_Upload::upload_path($info['file_url']))) {
			$info['image_url'] = RC_Upload::upload_url($info['file_url']);
		} else {
			$info['image_url'] = RC_Uri::admin_url('statics/images/nopic.png');
		}
		$this->assign('article', $info);
		$this->assign('form_action', RC_Uri::url('store/admin_notice/update'));
		
		$this->display('store_notice_info.dwt');
	}
	
	public function update() {
		$this->admin_priv('store_notice_update', ecjia::MSGTYPE_JSON);
		
		$title    	= !empty($_POST['title'])       ? trim($_POST['title'])         : '';
		$content  	= !empty($_POST['content'])     ? trim($_POST['content'])       : '';
		$keywords 	= !empty($_POST['keywords'])    ? trim($_POST['keywords'])      : '';
		$desc     	= !empty($_POST['description']) ? trim($_POST['description'])   : '';
		$id       	= !empty($_POST['id'])          ? intval($_POST['id'])          : 0;
		$file		= !empty($_FILES['file']) 		? $_FILES['file'] 				: '';

		$is_only = RC_DB::table('article as a')
			->leftJoin('article_cat as ac', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('ac.cat_id'))
			->where('title', $title)
			->where(RC_DB::raw('ac.cat_type'), 6)
			->where(RC_DB::raw('a.article_id'), '!=', $id)
			->count();
		
		if ($is_only != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.title_exist'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$old_file_name = RC_DB::table('article')->where('article_id', $id)->pluck('file_url');
		//判断用户是否选择了文件
		if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
			$upload = RC_Upload::uploader('file', array('save_path' => 'data/article', 'auto_sub_dirs' => true));
			$upload->allowed_type(array('jpg', 'jpeg', 'png', 'gif', 'bmp'));
			$upload->allowed_mime(array('image/jpeg', 'image/png', 'image/gif', 'image/x-png', 'image/pjpeg'));
			$image_info = $upload->upload($file);

			/* 判断是否上传成功 */
			if (!empty($image_info)) {
				$file_name = $upload->get_position($image_info);
				$upload->remove($old_file_name);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$file_name = $old_file_name;
		}

		$data = array(
			'title'       	=> $title,
			'content'     	=> $content,
			'keywords'    	=> $keywords,
			'file_url'		=> $file_name,
			'description' 	=> $desc,
			'add_time'    	=> RC_Time::gmtime()
		);

		RC_DB::table('article')->where('article_id', $id)->update($data);
		ecjia_admin::admin_log($title, 'edit', 'merchant_notice');
		
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.articleedit_succeed'), stripslashes($title)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('store/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 删除网店信息
	 */
	public function remove() {
		$this->admin_priv('store_notice_delete', ecjia::MSGTYPE_JSON);
		
		$id   = intval($_GET['id']);
		$info = RC_DB::table('article')->where('article_id', $id)->first();
		
		if (RC_DB::table('article')->where('article_id', $id)->delete()) {
			if (!empty($info['file_url']) && file_exists(RC_Upload::upload_path() . $info['file_url'])) {
				$disk = RC_Filesystem::disk();
				$disk->delete(RC_Upload::upload_path() . $info['file_url']);
			}
			ecjia_admin::admin_log(addslashes($info['title']), 'remove', 'merchant_notice');
		}
		return $this->showmessage(sprintf(RC_Lang::get('article::shopinfo.remove_success'), $info['title']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除附件
	 */
	public function del_file() {
		$this->admin_priv('store_notice_update', ecjia::MSGTYPE_JSON);
	
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$old_url = RC_DB::table('article')->where('article_id', $id)->pluck('file_url');
	
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $old_url);
	
		$data = array(
			'file_url'    => '',
		);
		RC_DB::table('article')->where('article_id', $id)->update($data);
	
		return $this->showmessage(RC_Lang::get('article::article.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_notice/edit', array('id' => $id))));
	}
	
	/**
	 * 获取网店信息文章
	 */
	private function get_notice_list($cat_id = 0) {
	    $data = RC_DB::table('article as a')
     			->leftJoin('article_cat as ac', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('ac.cat_id'))
     			->where(RC_DB::raw('ac.cat_type'), 6)
     			->get();
	    
	    $list = array();
	    if (!empty($data)) {
	        foreach ($data as $rows) {
	            $rows['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $rows['add_time']);
	            $list[] = $rows;
	        }
	    }
	    return $list;
	}
}

// end