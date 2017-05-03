<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA素材
 */
class admin_material extends ecjia_admin {
	private $wm_db;
	private $wr_db;
	private $db_platform_account;
	
	public function __construct() {
		parent::__construct();
		$this->wm_db = RC_Loader::load_app_model('wechat_media_model');
		$this->wr_db = RC_Loader::load_app_model('wechat_reply_model');
		$this->db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
		
		RC_Lang::load('wechat');
		RC_Loader::load_app_class('platform_account', 'platform', false);
		RC_Loader::load_app_class('wechat_method', 'wechat', false);
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-imagesloaded');
		RC_Script::enqueue_script('jquery-colorbox');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url('/statics/lib/dropper-upload/jquery.fs.dropper.js'));
		RC_Script::enqueue_script('admin_material', RC_App::apps_url('statics/js/admin_material.js', __FILE__));
		RC_Style::enqueue_style('admin_material', RC_App::apps_url('statics/css/admin_material.css', __FILE__));
		RC_Script::localize_script('admin_material', 'js_lang', RC_Lang::get('wechat::wechat.js_lang'));
		
	}

	/**
	 * 素材列表
	 */
	public function init() {
		$this->admin_priv('wechat_material_manage');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage')));
		
		$type = isset($_GET['type']) ? $_GET['type'] : '';
		$form_action = '';
		$action_link = '';
		
		if ($type == 'news') {
			$action_link = array('text' => RC_Lang::get('wechat::wechat.add_images'), 'href'=> RC_Uri::url('wechat/admin_material/add'));
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('wechat::wechat.overview'),
				'content'	=>
				'<p>' . RC_Lang::get('wechat::wechat.welcome_material_manage'). '</p>'
			));
			
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E5.9B.BE.E6.96.87.E7.AE.A1.E7.90.86" target="_blank">'.RC_Lang::get('wechat::wechat.material_manage_help').'</a>') . '</p>'
			);
		} elseif ($type == 'image') {
			$form_action = RC_Uri::url('wechat/admin_material/picture_insert');
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('wechat::wechat.overview'),
				'content'	=>
				'<p>' . RC_Lang::get('wechat::wechat.welcome_images_manage') . '</p>'
			));
			
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E5.9B.BE.E7.89.87.E7.AE.A1.E7.90.86" target="_blank">'.RC_Lang::get('wechat::wechat.images_manage_help').'</a>') . '</p>'
			);
		} elseif ($type == 'voice') {
			$form_action = RC_Uri::url('wechat/admin_material/voice_insert');
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('wechat::wechat.overview'),
				'content'	=>
				'<p>' . RC_Lang::get('wechat::wechat.welcome_voice_manage') . '</p>'
			));
				
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E8.AF.AD.E9.9F.B3.E7.AE.A1.E7.90.86" target="_blank">'.RC_Lang::get('wechat::wechat.voice_manage_help').'</a>') . '</p>'
			);
		} elseif ($type == 'video') {
			$action_link = array('text' => RC_Lang::get('wechat::wechat.add_video'), 'href'=> RC_Uri::url('wechat/admin_material/video_add'));
			ecjia_screen::get_current_screen()->add_help_tab(array(
				'id'		=> 'overview',
				'title'		=> RC_Lang::get('wechat::wechat.overview'),
				'content'	=>
				'<p>' . RC_Lang::get('wechat::wechat.welcome_video_manage') . '</p>'
			));
				
			ecjia_screen::get_current_screen()->set_help_sidebar(
				'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
				'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E8.A7.86.E9.A2.91.E7.AE.A1.E7.90.86" target="_blank">'.RC_Lang::get('wechat::wechat.video_manage_help').'</a>') . '</p>'
			);
		}
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.material_manage'));
		$this->assign('action_link', $action_link);
		$this->assign('form_action', $form_action);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
		} else {
			$this->assign('warn', 'warn');
				
			$wechat_type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('wechat_type', $wechat_type);
			
			$lists = $this->get_all_material();
			$this->assign('lists', $lists);
		}
		
		$this->assign_lang();
		$this->display('wechat_material.dwt');
	}
	
	/**
	 * 图文添加
	 */
	public function add() {
		$this->admin_priv('wechat_material_add');
		
		$material  = !empty($_GET['material']) ? 1 : 0;
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/admin_material/init', array('type' => 'news', 'material' => $material))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_images')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('wechat::wechat.welcome_add_images') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E6.B7.BB.E5.8A.A0.E5.9B.BE.E6.96.87" target="_blank">'.RC_Lang::get('wechat::wechat.images_meterial_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_images'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href'=> RC_Uri::url('wechat/admin_material/init', array('type'=> 'news', 'material' => $material))));
		$this->assign('form_action', RC_Uri::url('wechat/admin_material/insert'));
		$this->assign('action', 'article_add');
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
		} else {
			$this->assign('warn', 'warn');
			
			$wechat_type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('wechat_type', $wechat_type);
			$this->assign('material', $material);
		}
		
		$this->assign_lang();
		$this->display('wechat_material_add.dwt');
	}
	
	/**
	 * 图文添加数据插入
	 */
	public function insert() {
		$this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$title 		= !empty($_POST['title']) 	? trim($_POST['title']) 	: '';
		$author 	= !empty($_POST['author']) 	? trim($_POST['author']) 	: '';
		$is_show 	= !empty($_POST['is_show']) ? $_POST['is_show'] 		: '';
		$digest 	= !empty($_POST['digest']) 	? $_POST['digest'] 			: '';
		$link 		= !empty($_POST['link']) 	? trim($_POST['link']) 		: '';
		$content 	= !empty($_POST['content']) ? $_POST['content'] 		: '';
		$sort 		= !empty($_POST['sort']) 	? $_POST['sort'] 			: '';
		
		if (empty($title)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.enter_images_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (!empty($_POST)) {
			if ((isset($_FILES['image_url']['error']) && $_FILES['image_url']['error'] == 0) ||(!isset($_FILES['image_url']['error']) && isset($_FILES['image_url']['tmp_name']) && $_FILES['image_url']['tmp_name'] != 'none')) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/material/article_pic', 'auto_sub_dirs' => false));
				$file = array(
					'name'		=> $_FILES['image_url']['name'],
					'type'		=> $_FILES['image_url']['type'],
					'tmp_name'	=> $_FILES['image_url']['tmp_name'],
					'error'		=> $_FILES['image_url']['error'],
					'size'		=> $_FILES['image_url']['size']
				);
				$info = $upload->upload($file);
				if (!empty($info)) {
					$image_url = $upload->get_position($info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				return $this->showmessage(RC_Lang::get('wechat::wechat.upload_images_cover'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			if (empty($content)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$data = array(
				'wechat_id' 	=> $wechat_id,
				'title' 		=> $title,
				'author' 		=> $author,
				'is_show' 		=> $is_show,
				'digest' 		=> $digest,
				'link' 			=> $link,
				'content'		=> $content,
				'sort'			=> $sort,
				'file' 			=> $image_url,
				'size'			=> $file['size'],
				'file_name' 	=> $file['name'],
				'add_time'  	=> RC_Time::gmtime(),
				'type'			=> 'news',
				'is_material'   => 'material'
			);
			if ($id) {
				$data['parent_id'] = $id;
			}
			$rs = $wechat->addMaterialFile('image', RC_Upload::upload_path().$image_url);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$articles[0] = array(
				'title'             	=> $title,
				'thumb_media_id'    	=> $rs['media_id'],
				'author'           	 	=> $author,
				'digest'            	=> $digest,
				'show_cover_pic'    	=> $is_show,
				'content'           	=> $content,
				'content_source_url'	=> $link
			);
			$article_list = array('articles' => $articles);
			$rs1 = $wechat->addMaterialNews($article_list);
			if (RC_Error::is_error($rs1)) {
				return $this->showmessage(wechat_method::wechat_error($rs1->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			//封面图片素材id
			$data['thumb']       = $rs['media_id'];
			$data['media_url']   = $rs['url'];
			//图文消息的id
			$data['media_id']    = $rs1['media_id'];
			
			$id = $this->wm_db->insert($data);
			ecjia_admin::admin_log($title, 'add', 'article_material');
		}
		$links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href'=> RC_Uri::url('wechat/admin_material/init', array('type' => 'news', 'material' => 1)));
		$links[] = array('text' => RC_Lang::get('wechat::wechat.continue_material_manage'), 'href'=> RC_Uri::url('wechat/admin_material/add', array('material' => 1)));
		return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/admin_material/edit', array('id' => $id, 'material' => 1))));
	}
	
	/**
	 * 素材编辑
	 */
	public function edit() {
		$this->admin_priv('wechat_material_update');
		
		$material = !empty($_GET['material']) ? 1 : 0;
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/admin_material/init', array('type' => 'news', 'material' => $material))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_material')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('wechat::wechat.welcome_edit_material') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E7.BC.96.E8.BE.91.E5.9B.BE.E6.96.87" target="_blank">'.RC_Lang::get('wechat::wechat.edit_material_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$this->assign('ur_here',RC_Lang::get('wechat::wechat.edit_material'));
		$this->assign('form_action', RC_Uri::url('wechat/admin_material/update', array('id' => $_GET['id'], 'material' => $material)));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/admin_material/init', array('type'=>'news', 'material' => $material))));
		$this->assign('action', 'article_add');
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
		} else {
			$this->assign('warn', 'warn');
				
			$wechat_type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('wechat_type', $wechat_type);
			
			$article = $this->wm_db->where(array('id' => $_GET['id'], 'type' => 'news'))->find();
			if (!empty($article['file'])) {
				$article['file'] = RC_Upload::upload_url($article['file']);
			}
			$article['articles'][0] = $article;
			$data = $this->wm_db->where(array('parent_id' => $article['id']))->order(array('id' => 'asc'))->select();
			if (!empty($data)) {
				foreach ($data as $k => $v) {
					$article['articles'][$k+1] = $v;
					if (!empty($v['file'])) {
						$article['articles'][$k+1]['file'] = RC_Upload::upload_url($v['file']);
					}
				}
			}
			$this->assign('article', $article);
		}
		$this->assign_lang();
		$this->display('wechat_material_edit.dwt');
	}
	
	public function update() {
		$this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$parent_id = $_GET['id'];
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$title 		= !empty($_POST['title']) 	? trim($_POST['title']) 	: '';
		$author 	= !empty($_POST['author']) 	? trim($_POST['author']) 	: '';
		$is_show 	= !empty($_POST['is_show']) ? $_POST['is_show'] 		: '';
		$digest 	= !empty($_POST['digest']) 	? $_POST['digest'] 			: '';
		$link 		= !empty($_POST['link']) 	? trim($_POST['link']) 		: '';
		$content 	= !empty($_POST['content']) ? $_POST['content'] 		: '';
		$sort 		= !empty($_POST['sort']) 	? $_POST['sort'] 			: '';
		$id			= !empty($_POST['id'])		? intval($_POST['id'])		: 0;
		
		$index = !empty($_POST['index']) ? intval($_POST['index']) : 0;
		if (!empty($_POST)) {
			if ((isset($_FILES['image_url']['error']) && $_FILES['image_url']['error'] == 0) ||(!isset($_FILES['image_url']['error']) && isset($_FILES['image_url']['tmp_name']) && $_FILES['image_url']['tmp_name'] != 'none')) {
				$upload = RC_Upload::uploader('image', array('save_path' => 'data/material/article_pic', 'auto_sub_dirs' => false));
				$file = array(
					'name'		=> $_FILES['image_url']['name'],
					'type'		=> $_FILES['image_url']['type'],
					'tmp_name'	=> $_FILES['image_url']['tmp_name'],
					'error'		=> $_FILES['image_url']['error'],
					'size'		=> $_FILES['image_url']['size']
				);
				$info = $upload->upload($file);
				if (!empty($info)) {
					$image_url = $upload->get_position($info);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$rs = $wechat->addMaterialFile('image', RC_Upload::upload_path().$image_url);
				if (RC_Error::is_error($rs)) {
					return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			} else {
				if (empty($_POST['id'])) {
					return $this->showmessage(RC_Lang::get('wechat::wechat.upload_images_cover'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			if (empty($content)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.enter_main_body'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			
			$data = array(
				'wechat_id' 	=> $wechat_id,
				'title' 		=> $title,
				'author' 		=> $author,
				'is_show' 		=> $is_show,
				'digest' 		=> $digest,
				'content'		=> $content,
				'link' 			=> $link,
				'sort'			=> $sort,
				'type'			=> 'news',
				'is_material'   => 'material'
			);
			if (!empty($image_url)) {
				$data['file'] 		= $image_url;
				$data['file_name'] 	= $file['name'];
				$data['size'] 		= $file['size'];
				
				//封面图片素材id
				$data['thumb']      = $rs['media_id'];
				$data['media_url']  = $rs['url'];
			}
			if (!empty($id)) {
				//更新永久图文素材
				$arr = $this->wm_db->where(array('id' => $id))->find();
				$articles = array('articles' => array(
					'title' 				=> $title,
					'thumb_media_id'		=> $arr['thumb'],
					'author' 				=> $author,
					'digest' 				=> $digest,
					'show_cover_pic' 		=> $is_show,
					'content' 				=> $content,
					'content_source_url' 	=> $link
				));
				
				if ($index != 0) {
					$articles['articles']['digest'] = '';
				}
				if (isset($data['thumb'])) {
					$articles['articles']['thumb_media_id'] = $data['thumb'];
				}
				if (empty($arr['media_id'])) {
					$arr['media_id'] = $this->wm_db->where(array('id' => $arr['parent_id']))->get_field('media_id');
				}
				$rs1 = $wechat->updateMaterialNews($arr['media_id'], $index, $articles);
				if (RC_Error::is_error($rs1)) {
					return $this->showmessage(wechat_method::wechat_error($rs1->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$data['edit_time'] = RC_Time::gmtime();
				$this->wm_db->where(array('id' => $id))->update($data);
			} else {
				//添加多图文素材
				$arr = $this->get_article_list($parent_id);
				
				if (!empty($arr)) {
					$count = count($arr);
					foreach ($arr as $k => $v) {
						$articles[$k] = array(
							'title'             	=> $v['title'],
							'thumb_media_id'    	=> $v['thumb'],
							'author'           	 	=> $v['author'],
							'digest'            	=> $v['digest'],
							'show_cover_pic'    	=> $v['is_show'],
							'content'           	=> $v['content'],
							'content_source_url'	=> $v['link']
						);
						if (!empty($v['media_id'])) {
							//删除原素材
							$rs2 = $wechat->deleteMaterial($v['media_id']);
							if (RC_Error::is_error($rs2)) {
								return $this->showmessage(wechat_method::wechat_error($rs2->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
							}
						}
					}
				} else {
					$count = 0;
				}
				
				$articles[$count] = array(
					'title' 				=> $title,
					'thumb_media_id' 		=> $rs['media_id'],
					'author' 				=> $author,
					'digest' 				=> $digest,
					'show_cover_pic' 		=> $is_show,
					'content' 				=> $content,
					'content_source_url' 	=> $link
				);
				$article_list = array('articles' => $articles);
				
				$rs1 = $wechat->addMaterialNews($article_list);
				if (RC_Error::is_error($rs1)) {
					return $this->showmessage(wechat_method::wechat_error($rs1->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
				$this->wm_db->where(array('id' => $parent_id))->update(array('media_id' => $rs1['media_id']));

				$data['parent_id'] = $parent_id;
				$data['add_time'] = RC_Time::gmtime();
 				$id = $this->wm_db->insert($data);
			}
			$title = $this->wm_db->where(array('id' => $parent_id))->get_field('title');
			ecjia_admin::admin_log($title, 'edit', 'article_material');
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_material/edit', array('id' => $parent_id, 'material' => 1))));
	}
	
	/**
	 * 删除图文封面图片
	 */
	public function remove_file() {
		$this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);
		
		$id = $_GET['id'];
		$info = $this->wm_db->find(array('id' => $id));
		//删除图片
		if (!empty($info['file'])) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path().$info['file']);
		}
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if ($info['media_id'] && $info['is_material'] == 'material') {
			//删除永久素材
			$rs = $wechat->deleteMaterial($info['thumb']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		$this->wm_db->where(array('id' => $id))->update(array('file' => ''));
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 删除图文素材
	 */
	public function remove() {
		$this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		if (empty($id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//判断素材是否正在被使用
		$count = $this->wr_db->where(array('wechat_id' => $wechat_id, 'media_id' => $id))->count();
		if ($count != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.images_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$where = "id = ".$id." or parent_id=".$id;
		$info = $this->wm_db->where($where)->select();
		
		if (!empty($info)) {
			$ids = array();
			foreach ($info as $k => $v) {
				if ($v['parent_id'] == 0) {
					ecjia_admin::admin_log($v['title'], 'remove', 'article_material');
				}
				if (!empty($v['media_id']) && $v['is_material'] == 'material') {
					//删除永久素材
					$rs = $wechat->deleteMaterial($v['media_id']);
					if (RC_Error::is_error($rs)) {
						return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
					}
					$this->wm_db->where(array('id' => $id))->update(array('media_id' => ''));
				}
				if (empty($v['thumb'])) {
					$ids[] = $v['id'];
				}
			}
			if (!empty($ids)) {
				$this->wm_db->where(array('id' => $ids))->delete();
			}
		}
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 添加图片素材
	 */
	public function picture_insert() {
		$this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.upload_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/material/image', 'auto_sub_dirs' => false));
		if (!$upload->check_upload_file($_FILES['img_url'])) {
			return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$image_info = $upload->upload($_FILES['img_url']);
		if (empty($image_info)) {
			return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$file_path = $upload->get_position($image_info);
		$material = !empty($_GET['material']) ? 1 : 0;
		
		$data = array(
			'title' 	=> '',
			'author' 	=> '',
			'is_show' 	=> 0,
			'link' 		=> '',
			'sort' 		=> 0,
			'digest' 	=> '',
			'content' 	=> '',
			'file' 		=> $file_path,
			'type'		=> 'image',
			'file_name' => $_FILES['img_url']['name'],
			'add_time'  => RC_Time::gmtime(),
			'size'		=> $_FILES['img_url']['size'],
			'wechat_id' => $wechat_id,
		);
		if ($material) {
			$data['is_material'] = 'material';
		}
		$rs['url'] = '';
		//临时素材
		if ($material == 0) {
			$rs = $wechat->uploadFile('image', RC_Upload::upload_path().$file_path);
		} elseif ($material == 1) {
			//新增其他类型永久素材
			$rs = $wechat->addMaterialFile('image', RC_Upload::upload_path().$file_path);
		}
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if ($material == 1) {
			$data['media_url'] = $rs['url'];
		}
		$data['thumb'] = $rs['media_id'];
		
		$id = $this->wm_db->insert($data);
		ecjia_admin::admin_log($_FILES['img_url']['name'], 'add', 'picture_material');
		return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_material/init', array('type' => 'image', 'material' => $material))));
	}
	
	/**
	 * 删除图片
	 */
	public function picture_remove() {
		$this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);
	
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		if (empty($id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//判断素材是否正在被使用
		$count = $this->wr_db->where(array('wechat_id' => $wechat_id, 'media_id' => $id))->count();
		if ($count != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.images_beused'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$info = $this->wm_db->where(array('id' => $id))->find();
		
		if (!empty($info['thumb']) && $info['is_material'] == 'material') {
			//删除微信端图片素材
			$rs = $wechat->deleteMaterial($info['thumb']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		//图片素材
		if ($info['type'] == 'image') {
			//删除图片
			if (!empty($info['file']) && file_exists(RC_Upload::upload_path($info['file']))) {
				$disk = RC_Filesystem::disk();
				$disk->delete(RC_Upload::upload_path($info['file']));
			}
			
			$this->wm_db->where(array('id' => $id))->delete();
		} elseif ($info['type'] == 'news') {
			$this->wm_db->where(array('id' => $id))->update(array('thumb' => ''));
			
			if (empty($info['parent_id']) && empty($info['media_id'])) {
				$this->wm_db->where(array('id' => $id))->delete();
			} elseif (!empty($info['parent_id'])) {
				$media_id = $this->wm_db->where(array('id' => $info['parent_id']))->get_field('media_id');
				if (empty($media_id)) {
					$this->wm_db->where(array('id' => $id))->delete();
				}
			}
		}
		
		ecjia_admin::admin_log($info['file_name'], 'remove', 'picture_material');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 语音添加
	 */
	public function voice_insert() {
		$this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.upload_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$upload = RC_Upload::uploader('file', array('save_path' => 'data/material/voice', 'auto_sub_dirs' => false));
		$upload->allowed_type('mp3');//暂时不用amr
		$upload->allowed_mime('audio/mp3');
		$upload->allowed_size('2097152');
		
		$image_info = $upload->upload($_FILES['img_url']);
		if (empty($image_info)) {
			return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		$file_path = $upload->get_position($image_info);
		$material = !empty($_GET['material']) ? 1 : 0;
		
		$data = array(
			'title' 	=> '',
			'author' 	=> '',
			'is_show' 	=> '',
			'link' 		=> '',
			'sort' 		=> 0,
			'digest' 	=> '',
			'content' 	=> '',
			'file' 		=> $file_path,
			'type'		=> 'voice',
			'file_name' => $_FILES['img_url']['name'],
			'add_time'  => RC_Time::gmtime(),
			'size'		=> $_FILES['img_url']['size'],
			'wechat_id' => $wechat_id,
		);
		if ($material) {
			$data['is_material'] = 'material';
		}
		
		if ($material == 0) {
			//临时素材
			$rs = $wechat->uploadFile('voice', RC_Upload::upload_path().$file_path);
		} elseif ($material == 1) {
			//永久素材
			$rs = $wechat->addMaterialFile('voice', RC_Upload::upload_path().$file_path);
		}
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data['media_id'] = $rs['media_id'];
		
		$id = $this->wm_db->insert($data);
		ecjia_admin::admin_log($_FILES['img_url']['name'], 'add', 'voice_material');
		return $this->showmessage(RC_Lang::get('wechat::wechat.upload_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_material/init', array('type' => 'voice', 'material' => $material))));
	}
	
	/**
	 * 删除语音
	 */
	public function voice_remove() {
		$this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);
	
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		if (empty($id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//判断素材是否正在被使用
		$count = $this->wr_db->where(array('wechat_id' => $wechat_id, 'media_id' => $id))->count();
		if ($count != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.voice_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$info = $this->wm_db->find(array('id' => $id));
		
		if (!empty($info['media_id']) && $info['is_material'] == 'material') {
			//删除永久素材
			$rs = $wechat->deleteMaterial($info['media_id']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		//删除语音
		if (!empty($info['file']) && file_exists(RC_Upload::upload_path($info['file']))) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path($info['file']));
		}
		$this->wm_db->where(array('id' => $id))->delete();
		
		ecjia_admin::admin_log($info['file_name'], 'remove', 'voice_material');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	public function video_add() {
		$this->admin_priv('wechat_material_add');
		
		$material  = !empty($_GET['material']) ? 1 : 0;
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/admin_material/init', array('type' => 'video', 'material' => $material))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.add_video')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('wechat::wechat.welcome_add_video') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E6.B7.BB.E5.8A.A0.E8.A7.86.E9.A2.91" target="_blank">'.RC_Lang::get('wechat::wechat.add_video_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.add_video'));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href'=> RC_Uri::url('wechat/admin_material/init', array('type'=>'video', 'material' => $material))));
		$this->assign('form_action', RC_Uri::url('wechat/admin_material/video_insert', array('material' => $material)));
		$this->assign('action', 'video_add');
		$this->assign('button_type', 'add');
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
		} else {
			$this->assign('warn', 'warn');
				
			$wechat_type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('wechat_type', $wechat_type);
			
			$this->assign('material', $material);
		}
		$this->assign_lang();
		$this->display('wechat_material_add.dwt');
	}
	
	public function video_insert() {
		$this->admin_priv('wechat_material_add', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$title    = !empty($_POST['video_title'])     ? trim($_POST['video_title']) : '';
		$digest   = !empty($_POST['video_digest'])    ? $_POST['video_digest']      : '';
		$material = !empty($_GET['material'])         ? 1                           : 0;
		
		if (empty($title)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		if (empty($_FILES['video'])) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.upload_viedo'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($material == 1) {
			if (empty($digest)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.video_intro'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		$upload = RC_Upload::uploader('file', array('save_path' => 'data/material/video', 'auto_sub_dirs' => false));
		$upload->allowed_type('mp4');
		$upload->allowed_mime('video/mp4');
		$upload->allowed_size('10485760');
		
		if ((isset($_FILES['video']))) {
			$image_info = $upload->upload($_FILES['video']);
			if (!empty($image_info)) {
				$file_path = $upload->get_position($image_info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			$file_path = '';
		}

		$data = array(
			'title' 	=> $title,
			'digest' 	=> $digest,
			'is_show'	=> 0,
			'file' 		=> $file_path,
			'file_name'	=> $_FILES['video']['name'],
			'add_time'  => RC_Time::gmtime(),
			'type'		=> 'video',
			'size'		=> $_FILES['video']['size'],
			'wechat_id' => $wechat_id,
		);
		
		if ($material) {
			$data['is_material'] = 'material';
		}
		
		if ($material == 0) {
			//临时素材
			$rs = $wechat->uploadFile('video', RC_Upload::upload_path().$file_path);
		} elseif ($material == 1) {
			$description = array('title' => $title, 'introduction' => $digest);
			//永久素材
			$rs = $wechat->addMaterialFile('video', RC_Upload::upload_path().$file_path, $description);
		}
		
		if (RC_Error::is_error($rs)) {
			return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$data['media_id'] = $rs['media_id'];
		$id = $this->wm_db->insert($data);
		
		ecjia_admin::admin_log($title, 'add', 'video_material');
		if ($id) {
			$links[] = array('text' => RC_Lang::get('wechat::wechat.return_material_manage'), 'href'=> RC_Uri::url('wechat/admin_material/init', array('type'=>'video', 'material' => $material)));
			$links[] = array('text' => RC_Lang::get('wechat::wechat.continue_add_video'), 'href'=> RC_Uri::url('wechat/admin_material/video_add', array('material' => $material)));
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('wechat/admin_material/init', array('type' => 'video', 'material' => $material))));
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 素材编辑
	 */
	public function video_edit() {
		$this->admin_priv('wechat_material_update');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.material_manage'), RC_Uri::url('wechat/admin_material/init', array('type' => 'video'))));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('wechat::wechat.edit_material')));
		
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('wechat::wechat.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('wechat::wechat.welcome_edit_video') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('wechat::wechat.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia公众平台:素材管理#.E7.BC.96.E8.BE.91.E8.A7.86.E9.A2.91" target="_blank">'.RC_Lang::get('wechat::wechat.edit_video_help').'</a>') . '</p>'
		);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$material = !empty($_GET['material']) ? 1 : 0;
		$this->assign('ur_here', RC_Lang::get('wechat::wechat.edit_video'));
		$this->assign('form_action', RC_Uri::url('wechat/admin_material/video_update', array('material' => $material)));
		$this->assign('action_link', array('text' => RC_Lang::get('wechat::wechat.material_manage'), 'href' => RC_Uri::url('wechat/admin_material/init', array('type'=>'video', 'material' => $material))));
		$this->assign('action', 'video_add');
		
		if (is_ecjia_error($wechat_id)) {
			$this->assign('errormsg', RC_Lang::get('wechat::wechat.operate_before_pub'));
		} else {
			$this->assign('warn', 'warn');
			
			$wechat_type = $this->db_platform_account->where(array('id' => $wechat_id))->get_field('type');
			$this->assign('wechat_type', $wechat_type);
			
			$article = $this->wm_db->where(array('id' => $_GET['id']))->find();
			if (!empty($article['file'])) {
				$article['files'] = RC_Uri::admin_url('statics/images/ecjiafile.png');
			}
			$this->assign('article', $article);
		}
		$this->assign_lang();
		$this->display('wechat_material_add.dwt');
	}
	
	/**
	 * 视频素材更新
	 */
	public function video_update() {
		$this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();

		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		if (is_ecjia_error($wechat_id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.add_failed_operate'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$title    = !empty($_POST['video_title'])     ? trim($_POST['video_title'])   : '';
		$digest   = !empty($_POST['video_digest'])    ? $_POST['video_digest']        : '';
		$id       = !empty($_POST['id'])              ? intval($_POST['id'])          : 0;
		$material = !empty($_GET['material'])         ? 1                             : 0;
		
		if (empty($title)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$medias = $this->wm_db->find(array('id' => $id));
		if (empty($medias['file'])) {
			if (empty($_FILES['video'])) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.upload_viedo'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		if ($material == 1) {
			if (empty($digest)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.video_intro'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		if ((isset($_FILES['video']['error']) && $_FILES['video']['error'] == 0) || (!isset($_FILES['video']['error']) && isset($_FILES['video']['tmp_name']) && $_FILES['video']['tmp_name'] != 'none')) {
			$upload = RC_Upload::uploader('file', array('save_path' => 'data/material/video', 'auto_sub_dirs' => true));
			$upload->allowed_type('mp4');
			$upload->allowed_size('10485760');
			$upload->allowed_mime('video/mp4');
			
			$info = $upload->upload($_FILES['video']);
			if (!empty($info)) {
				if (!empty($medias['file'])){
					$upload->remove($medias['file']);
				}
				$file = $upload->get_position($info);
			} else {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		} else {
			if (!empty($medias['file'])){
				$file = $medias['file'];
			} else {
				$disk = RC_Filesystem::disk();
				$disk->delete(RC_Upload::upload_path().$medias['file']);
			}
		}
		$data = array(
			'title' 	=> $title,
			'is_show' 	=> 0,
			'digest' 	=> $digest,
			'file' 		=> $file,
			'type'		=> 'video',
			'edit_time' => RC_Time::gmtime(),
			'size'		=> $_FILES['video']['size']
		);
		$info_update = $this->wm_db->where(array('id' => $id))->update($data);
	
		ecjia_admin::admin_log($title, 'edit', 'video_material');
		if ($info_update) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('wechat/admin_material/video_edit', array('id' => $id, 'material' => $material))));
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除视频素材
	 */
	public function video_remove() {
		$this->admin_priv('wechat_material_delete', ecjia::MSGTYPE_JSON);
	
		$uuid = platform_account::getCurrentUUID('wechat');
		$wechat = wechat_method::wechat_instance($uuid);
		
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		if (empty($id)) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.select_material'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		//判断素材是否正在被使用
		$count = $this->wr_db->where(array('wechat_id' => $wechat_id, 'media_id' => $id))->count();
		if ($count != 0) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.video_used'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$info = $this->wm_db->where(array('id' => $id))->find();
	
		if (!empty($info['media_id']) && $info['is_material'] == 'material') {
			//删除永久素材
			$rs = $wechat->deleteMaterial($info['media_id']);
			if (RC_Error::is_error($rs)) {
				return $this->showmessage(wechat_method::wechat_error($rs->get_error_code()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		//删除视频
		if (!empty($info['file']) && file_exists(RC_Upload::upload_path($info['file']))) {
			$disk = RC_Filesystem::disk();
			$disk->delete(RC_Upload::upload_path($info['file']));
		}
	
		$this->wm_db->where(array('id' => $id))->delete();
		
		ecjia_admin::admin_log($info['title'], 'remove', 'video_material');
		return $this->showmessage(RC_Lang::get('wechat::wechat.remove_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 编辑素材名称或文件名称
	 */
	public function edit_file_name() {
		$this->admin_priv('wechat_material_update', ecjia::MSGTYPE_JSON);
		
		$id   = isset($_GET['id'])    ? intval($_GET['id'])   : 0;
		$val  = isset($_GET['val'])   ? $_GET['val']          : '';
		$type = isset($_GET['type'])  ? $_GET['type']         : '';
		if ($type == 'voice' || $type == 'picture') {
			if (empty($val)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.enter_filename'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$update = $this->wm_db->where(array('id' => $id))->update(array('file_name' => $val));
			if ($type == 'voice') {
				ecjia_admin::admin_log($val, 'edit', 'voice_material');
			} elseif ($type == 'picture') {
				ecjia_admin::admin_log($val, 'edit', 'picture_material');
			}
		} else {
			if (empty($val)) {
				return $this->showmessage(RC_Lang::get('wechat::wechat.enter_title'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$update = $this->wm_db->where(array('id' => $id))->update(array('title' => $val));
			ecjia_admin::admin_log($val, 'edit', 'article_material');
		}
		if ($update) {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('wechat::wechat.edit_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	public function search() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$keyword = !empty($_POST['keyword']) ? trim($_POST['keyword']) : '';
		$arr = $this->wm_db
            		->field('id, file')
            		->where(array('wechat_id' => $wechat_id, 'type' => 'news', 'title' => array('like' => "%".mysql_like_quote($keyword)."%")))
            		->select();
		
		if (empty($arr)) {
			$arr = array(0 => array(
				'id'   => 0,
				'file' => RC_Lang::get('wechat::wechat.nosearch_record')
			));
		} else {
			foreach ($arr as $key => $item) {
				if (!empty($item['file'])) {
					$arr[$key]['file'] = RC_Upload::upload_url($item['file']);
				}
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr) );
	}
	
	public function get_material_list() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$filter   = $_GET['JSON'];
		$filter   = (object)$filter;
		$type     = isset($filter->type)      ? $filter->type : '';
		$material = !empty($_GET['material']) ? 'material'    : '';
		
		if ($type == 'image') {
			$where = "(file is NOT NULL and (type = 'image' or type = 'news')) and wechat_id = $wechat_id";
		} elseif ($type == 'news') {
			$where = "(article_id is NULL and type = '$type') and wechat_id = $wechat_id";
		} else {
			$where = "(file is NOT NULL and type = '$type') and wechat_id = $wechat_id";
		}
		$where .= " and is_material = '$material'";
	
		$list = $this->wm_db->field('id, file, title, size, add_time, type, file_name')->where($where)->select();
	
		if (!empty($list)) {
			foreach ($list as $key => $val) {
				$val['type'] = isset($val['type']) ? $val['type'] : '';
				if (empty($val['file']) || $val['type'] == 'voice' || $val['type'] == 'video') {
					if (empty($val['file'])) {
						$list[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
					} elseif ($val['type'] == 'voice') {
						$list[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
					} elseif ($val['type'] == 'video') {
						$list[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
					}
				} else {
					$list[$key]['file'] = RC_Upload::upload_url($val['file']);
				}
				if (isset($val['add_time'])) {
					$list[$key]['add_time'] = RC_Time::local_date('Y-m-d H:i:s', $val['add_time']);
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
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $list));
	}
	
	public function get_material_info() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
		
		$id = $_GET['id'];
		$info = $this->wm_db->where(array('id' => $id, 'wechat_id' => $wechat_id))->find();
		
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
		$info['href'] = RC_Uri::url('wechat/admin_material/remove_file', array('id' => $id));
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $info));
	}
	
	/**
	 * 获取所有素材列表
	 */
	private function get_all_material() {
		$platform_account = platform_account::make(platform_account::getCurrentUUID('wechat'));
		$wechat_id = $platform_account->getAccountID();
	
		$filter['type'] = empty($_GET['type']) ? '' : trim($_GET['type']);
		$type = $filter['type'];
		
		$where = '';
		if ($type == 'image') {
			$where = "(file != '' and (type = 'image' or type = 'news')) and wechat_id = $wechat_id and thumb != ''";
		} elseif ($type == 'news') {
			$where = "(type = 'news') and wechat_id = $wechat_id and media_id != '' and parent_id = 0";
		} else {
			$where = "type = '$type' and wechat_id = $wechat_id";
		}
	
		$material = !empty($_GET['material']) ? 'material' : '';
		$where .= " and is_material = '$material'";
	
		$count = $this->wm_db->field("SUM(type='news' and parent_id = 0 and media_id != '') AS news, SUM(file != '' and (type = 'image' or type = 'news') and thumb != '') AS image, SUM(type='voice') AS voice, SUM(type='video') AS video")->where(array('wechat_id' => $wechat_id, 'is_material' => $material))->select();
		foreach ($count as $v) {
			if (empty($v['news']) && empty($v['image']) && empty($v['voice']) && empty($v['video'])) {
				$v['news'] 	= 0;
				$v['image'] = 0;
				$v['voice'] = 0;
				$v['video'] = 0;
			}
			$filter['count'] = $v;
		}
		$count = $this->wm_db->where($where)->count();
	
		$page = new ecjia_page($count, 12, 5);
		$limit = $page->limit();

		$data = $this->wm_db->limit($limit)->where($where)->order(array('sort' => 'asc', 'id' => 'desc'))->select();
		
		if (!empty($data)) {
			foreach ($data as $key => $val) {
				if (isset($val['add_time'])) {
					$data[$key]['add_time'] = RC_Time::local_date(RC_Lang::get('wechat::wechat.date_nj'), $val['add_time']);
				}
			
				if (empty($val['file']) || $val['type'] == 'voice' || $val['type'] == 'video') {
					if (empty($val['file'])) {
						$data[$key]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
					} elseif ($val['type'] == 'voice') {
						$data[$key]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
					} elseif ($val['type'] == 'video') {
						$data[$key]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
					}
				} else {
					$data[$key]['file'] = RC_Upload::upload_url($val['file']);
				}
				$content = !empty($val['digest']) ? strip_tags(html_out($val['digest'])) : strip_tags(html_out($val['content']));
				if (strlen($content) > 100) {
					$data[$key]['content'] = msubstr($content, 100);
				} else {
					$data[$key]['content'] = $content;
				}
				
				if ($type == 'news') {
					$datas = $this->wm_db->where(array('parent_id' => $val['id']))->order(array('id' => 'asc'))->select();
					if (!empty($datas)) {
						foreach ($datas as $k => $v) {
							if (!empty($v['file'])) {
								$data[$key]['articles'][$k]['file'] = RC_Upload::upload_url($v['file']);
							} else {
								if (empty($val['file'])) {
									$data[$key]['articles'][$k]['file'] = RC_Uri::admin_url('statics/images/nopic.png');
								} elseif ($val['type'] == 'voice') {
									$data[$key]['articles'][$k]['file'] = RC_App::apps_url('statics/images/voice.png', __FILE__);
								} elseif ($val['type'] == 'video') {
									$data[$key]['articles'][$k]['file'] = RC_App::apps_url('statics/images/video.png', __FILE__);
								}
							}
							$data[$key]['articles'][$k]['id'] = $v['id'];
							$data[$key]['articles'][$k]['title'] = $v['title'];
							$data[$key]['articles'][$k]['file_name'] = $v['file_name'];
						}
					}
				}
			}
		}
		$arr = array('item' => $data, 'desc' => $page->page_desc(), 'page'=>$page->show(5), 'filter' => $filter);
		return $arr;
	}
	
	/**
	 * 获取多图文信息
	 */
	private function get_article_list($id) {
		if ($id) {
			$where = "type = 'news' and parent_id = '$id' or id = '$id'";
		}
		$data = $this->wm_db->where($where)->order(array('id' => 'asc'))->select();
		return $data;
	}
}

//end