<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 文章自动发布管理
 *  @author songqian
 */
class admin_article_auto extends ecjia_admin {
    private $db_article_view;
    private $db_article;
    private $db_auto_manage;
    private $db_crons;
    
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_article');
		RC_Loader::load_app_func('global');
		assign_adminlog_contents();
		
		$this->db_article_view 	= RC_Loader::load_app_model('article_viewmodel');
		$this->db_article		= RC_Loader::load_app_model('article_model');
		$this->db_auto_manage	= RC_Loader::load_app_model('auto_manage_model');
		
		/*加载全局JS及CSS*/
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('moment.min', RC_Uri::admin_url('statics/lib/moment_js/moment.min.js'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		RC_Script::enqueue_script('article_auto', RC_App::apps_url('statics/js/article_auto.js', __FILE__));
		RC_Script::localize_script('article_auto', 'js_lang', RC_Lang::get('article::article.js_lang'));
	}

	public function init() {
		$this->admin_priv('article_auto_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('article::article.article_auto_release')));
		
		$this->assign('ur_here', RC_Lang::get('article::article.article_auto_release'));
		$this->assign('search_action', RC_Uri::url('article/admin_article_auto/init'));
	
		$crons_enable = RC_Api::api('cron', 'cron_info', array('cron_code' => 'cron_auto_manage'));
		$this->assign('crons_enable', $crons_enable['enable']);
		
		$list = $this->get_auto_articles();
		$this->assign('list', $list);

		$this->display('article_auto.dwt');
	}
	
	public function batch() {
		$this->admin_priv('article_auto_manage', ecjia::MSGTYPE_JSON);
		
		$type         = !empty($_GET['type'])         ? $_GET['type']         : '';
		$article_id   = !empty($_POST['article_id'])  ? $_POST['article_id']  : '';
		$time 		  = !empty($_POST['select_time']) ? RC_Time::local_strtotime($_POST['select_time']) : '';
		
		if (empty($article_id)) {
			return $this->showmessage(RC_Lang::get('article::article.select_article_msg'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
			
		if (empty($time)) {
			return $this->showmessage(RC_Lang::get('article::article.choose_time'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($type == 'batch_start') {
			$message	= RC_Lang::get('article::article.batch_start_succeed');
			$time_type 	= 'starttime';
		} elseif ($type == 'batch_end') {
			$message 	= RC_Lang::get('article::article.batch_end_succeed');
			$time_type 	= 'endtime';
		}
		
		$article_list = $this->db_auto_manage->auto_manage_field(array('type' => 'article'), 'item_id', true);
		$id_arr = explode(',', $article_id);
		
		if (!empty($id_arr)) {
			foreach ($id_arr as $k => $v) {
				$data = array(
					'item_id' 	=> $v,
					'type'	  	=> 'article',
					$time_type	=> $time
				);
				if (!empty($article_list)) {
					if (in_array($v, $article_list)) {
						$this->db_auto_manage->auto_manage($data, array('item_id' => $v, 'type' => 'article'));
					} else {
						$this->db_auto_manage->auto_manage($data);
					}
				} else {
					$this->db_auto_manage->auto_manage($data);
				}
			}
			$title_list = $this->db_article->article_field(array('article_id' => $id_arr), 'title', true);
		}
		
		if (!empty($title_list)) {
			foreach ($title_list as $v) {
				ecjia_admin::admin_log(RC_Lang::get('article::article.article_name_is').$v, $type, 'article');
			}
		}
		return $this->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_article_auto/init')));
	}
	
	//撤销
	public function del() {
		$this->admin_priv('article_auto_manage', ecjia::MSGTYPE_JSON);
		
		$id       = !empty($_GET['id']) ? intval($_GET['id']) : 0;
		$title    = $this->db_article->article_field(array('article_id' => $id), 'title');
		
		$this->db_auto_manage->auto_manage_delete(array('item_id' => $id , 'type' => 'article'));
		
		ecjia_admin::admin_log(RC_Lang::get('article::article.article_name_is').$title, 'cancel', 'article_auto');
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	public function edit_starttime() {
		$this->admin_priv('article_auto_manage', ecjia::MSGTYPE_JSON);
		
		$id		= !empty($_POST['pk']) 		? intval($_POST['pk']) 	: 0;
		$value 	= !empty($_POST['value']) 	? trim($_POST['value']) : '';
		
		$val = '';
		if (!empty($value)) {
			$val = RC_Time::local_strtotime($value);
		}
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) || $value == '0000-00-00' || $val <= 0) {
			return $this->showmessage(RC_Lang::get('article::article.time_format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$count = $this->db_auto_manage->is_only(array('item_id' => $id, 'type' => 'article'));
		
		$data = array(
			'item_id'	=> $id,
			'type'		=> 'article',
			'starttime' => $val
		);
		
		if ($count == 0) {
            $this->db_auto_manage->auto_manage($data);
		} else {
            $this->db_auto_manage->auto_manage($data, array('item_id' => $id, 'type' => 'article'));
		}
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_article_auto/init')));
	}
	
	public function edit_endtime() {
		$this->admin_priv('article_auto_manage', ecjia::MSGTYPE_JSON);
		
		$id		= !empty($_POST['pk'])       ? intval($_POST['pk'])  : 0;
		$value 	= !empty($_POST['value'])    ? trim($_POST['value']) : '';
		
		$val = '';
		if (!empty($value)) {
			$val = RC_Time::local_strtotime($value);
		}
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value) || $value == '0000-00-00' || $val <= 0) {
			return $this->showmessage(RC_Lang::get('article::article.time_format_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$count = $this->db_auto_manage->is_only(array('item_id' => $id, 'type' => 'article'));
		
		$data = array(
			'item_id'    => $id,
			'type'		 => 'article',
			'endtime'    => $val
		);
		
		if ($count == 0) {
            $this->db_auto_manage->auto_manage($data);
		} else {
            $this->db_auto_manage->auto_manage($data, array('item_id' => $id, 'type' => 'article'));
		}
		return $this->showmessage(RC_Lang::get('article::article.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('article/admin_article_auto/init')));
	}
	
	/**
	 * 获取自动发布文章
	 * @return array
	 */
	private function get_auto_articles() {
		$db_article_view = RC_Loader::load_app_model('article_viewmodel');
		
		$keywords = !empty($_GET['keywords']) ? trim(htmlspecialchars($_GET['keywords'])) : '';
		$where = '';
	
		if ($keywords) {
			$where['a.title'] = array('like' => "%". mysql_like_quote($keywords). "%" );
		}
	
		$count = $db_article_view->article_count($where);
		$page = new ecjia_page($count, 10, 5);
		$order = array('a.add_time' => 'desc');
		$limit = $page->limit();
		
		$option = array(
			'table'	=> 'auto_manage',
			'field'	=> 'a.*, am.starttime, am.endtime',
			'where'	=> $where,
			'order'	=> $order,
			'limit'	=> $limit
		);
		$data = $db_article_view->article_select($option);
	
		$list = array();
		if (!empty($data)) {
			foreach ($data as $rt) {
				if (!empty($rt['starttime'])) {
					$rt['starttime'] = RC_Time::local_date('Y-m-d', $rt['starttime']);
				}
				if (!empty($rt['endtime'])) {
					$rt['endtime'] = RC_Time::local_date('Y-m-d', $rt['endtime']);
				}
				$list[] = $rt;
			}
		}
		return array('item' => $list, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end