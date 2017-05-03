<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 在线升级
 */
class upgrade extends ecjia_admin {
	private $db;
	private $nav_tabs;
	
	public function __construct() {
		parent::__construct();
		$this->db = RC_Loader::load_model('shop_config_model');
		
		RC_Script::enqueue_script('jquery-dataTables');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('ecjia-admin_upgrade');
		RC_Style::enqueue_style('fontello-animation', RC_Uri::admin_url() . '/statics/lib/fontello/css/animation.css', array('fontello'));
		
		$admin_upgrade_jslang = array(
				'checking'	=> __('正在检查，请耐心等待。'),
		);
		RC_Script::localize_script('ecjia-admin_upgrade', 'admin_upgrade_lang', $admin_upgrade_jslang );
		
		$this->nav_tabs = array(
			array(
				'title' => __('可用更新'),
				'key'	=> 'init',
				'url'	=> RC_Uri::url('@upgrade/init'),
			),
// 			array(
// 				'title' => __('文件校验'),
// 				'key' 	=> 'check_file_md5',
// 				'url'	=> RC_Uri::url('@upgrade/check_file_md5'),
// 			),
			array(
				'title' => __('文件权限检测'),
				'key'	=> 'check_file_priv',
				'url'	=> RC_Uri::url('@upgrade/check_file_priv'),
			),
		);
	}


	public function init() {
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('可用更新')));
		$this->assign('ur_here', __('可用更新'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台更新页面，在此可以进行对版本的更新。') . '</p>'
		) );
		 
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:可用更新" target="_blank">关于可用更新帮助文档</a>') . '</p>'
		);

		$last_check_upgrade_time = $this->db->where(array('code'=>'last_check_upgrade_time'))->get_field('value');
		$last_check_upgrade_time = $last_check_upgrade_time ? RC_Time::local_date('Y年m月d日 H:i:s', $last_check_upgrade_time) : '2015年03月24日 23:00:00';
	
		$this->assign('check_upgrade_time', $last_check_upgrade_time);
		$this->assign('nav_tabs', $this->nav_tabs);
		
		$this->display('upgrade.dwt');
	}


	public function check_update() {
		$last_check_upgrade_time = RC_Time::gmtime();
		if ($this->db->where(array('code'=>'last_check_upgrade_time'))->count()) {
			$this->db->where(array('code'=>'last_check_upgrade_time'))->update(array('value' => $last_check_upgrade_time));
		} else {
			$this->db->insert(array('code'=>'last_check_upgrade_time', 'value' => $last_check_upgrade_time, 'parent_id' => 6, 'sort_order' => 1));
		}
		return $this->showmessage(__('暂无可用更新！'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('@upgrade/init')));
	}
	
	/**
	 * 文件校验，是否变动
	 */
	public function check_file_md5() {
		$this->admin_priv('file_check');
		
		if ($_GET['step'] == 2) {
			$files = RC_Loader::load_sys_config('md5files');
			if (!$files) {
				return $this->showmessage(__('不存在校验文件，无法进行此操作'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR);
			}
			
			@set_time_limit(0);
			
			$check_exts = '\.php|\.js|\.css|\.png|\.gif|\.jpg|\.json|\.html|\.txt|\.eot|\.svg|\.ttf|\.woff|\.map|\.cur';
			$md5data = array();
			$md5data = RC_File::get_md5_files(SITE_SYSTEM_PATH, $check_exts, 1, 'md5files.cfg.php');
			$md5datanew = array();
			foreach ($files as $md5 => $file) {
				$md5datanew[$file] = $md5;
				if ($md5datanew[$file] != $md5data[$file]) {
					$modifylist[$file] = $md5data[$file];
				}
				$md5datanew[$file] = $md5data[$file];
			}
	
			$weekbefore = time() - 604800;  //一周前的时间
			$addlist 	= array_diff_assoc($md5data, $md5datanew);
			$dellist 	= array_diff_assoc($md5datanew, $md5data);
			$modifylist = array_diff_assoc($modifylist, $dellist);
			$showlist 	= array_merge($md5data, $md5datanew);
			
			$result = $dirlog = array();
			foreach ($showlist as $file => $md5) {
				$dir = dirname($file);
				$statusf = $statust = 1;
				//统计“被修改”的文件
				if (array_key_exists($file, $modifylist)) {
					$status = __('<span class="stop_color"><i class="fontello-icon-attention-circled"></i>被修改</span>');
					if (!isset($dirlog[$dir]['modify']))
					{
						$dirlog[$dir]['modify'] = '';
					}
					$dirlog[$dir]['modify']++;  
					$dirlog[$dir]['marker'] = substr(md5($dir),0,3);
				}
				//统计“被删除”的文件
				elseif (array_key_exists($file, $dellist)) {
					$status = __('<span class="error_color"><i class="fontello-icon-minus-circled"></i>被删除</span>');
					if (!isset($dirlog[$dir]['del']))
					{
						$dirlog[$dir]['del'] = '';
					}
					$dirlog[$dir]['del']++;     
					$dirlog[$dir]['marker'] = substr(md5($dir),0,3);
				}
				//统计“未知”的文件
				elseif (array_key_exists($file, $addlist)) {
					$status = __('<span class="ok_color"><i class="fontello-icon-help-circled"></i>未知</span>');
					if (!isset($dirlog[$dir]['add']))
					{
						$dirlog[$dir]['add'] = '';
					}
					$dirlog[$dir]['add']++;     
					$dirlog[$dir]['marker'] = substr(md5($dir),0,3);
				}
				else {
					$status = __('<span class="ok_color"><i class="fontello-icon-ok-circled"></i>正确</span>');
					$statusf = 0;
				}
			
				//对一周之内发生修改的文件日期加粗显示
				$filemtime = filemtime(SITE_ROOT . $file);
				if ($filemtime > $weekbefore) {
					$filemtime = '<b>'.date("Y-m-d H:i:s", $filemtime).'</b>';
				} else {
					$filemtime = date("Y-m-d H:i:s", $filemtime);
					$statust = 0;
				}
			
				if ($statusf) {
					$filelist[$dir][] = array('file' => basename($file), 'size' => file_exists(SITE_ROOT . $file) ? number_format(filesize(SITE_ROOT . $file)).' Bytes' : '', 'filemtime' => $filemtime, 'status' => $status);
				}
			}
			
			$result[__('<span class="stop_color"><i class="fontello-icon-attention-circled"></i>被修改</span>')] = count($modifylist);
			$result[__('<span class="error_color"><i class="fontello-icon-minus-circled"></i>被删除</span>')] = count($dellist);
			$result[__('<span class="ok_color"><i class="fontello-icon-help-circled"></i>未知</span>')] = count($addlist);
	
			$this->assign('result',     $result);
			$this->assign('dirlog',     $dirlog);
			$this->assign('filelist',   $filelist);
			$this->assign('ur_here', __('校验结果'));
			$this->assign('action_link', array('text' => __('返回重新校验'), 'href' => RC_Uri::url('@upgrade/check_file_md5', 'step=1')));
		}

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('文件校验')));
		$this->assign('ur_here', __('文件校验'));

		$this->assign('nav_tabs', $this->nav_tabs);
		
		$this->display('check_file_md5.dwt');
	}
	
	/**
	 * 文件权限检测
	 */
	public function check_file_priv() {
		$this->admin_priv('file_priv');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('文件权限检测')));
		$this->assign('ur_here',	__('文件权限检测'));
		
		$Upload_Current_Path		= str_replace(SITE_ROOT, '', RC_Upload::upload_path());
		$Cache_Current_Path			= str_replace(SITE_ROOT, '', SITE_CACHE_PATH);

		$dir['content/configs']		        = str_replace(SITE_ROOT, '', SITE_CONTENT_PATH) . 'configs';
		$dir['content/uploads']	            = $Upload_Current_Path;
		$dir['content/caches']		        = $Cache_Current_Path;
		
		$list = array();
		/* 检查目录 */
		foreach ($dir AS $key => $val) {
			$mark = RC_File::file_mode_info(SITE_ROOT . $val);
			$list[] = array('item' => $key . __('目录'), 'r' => $mark&1, 'w' => $mark&2, 'm' => $mark&4);
		}
		
		/* 检查smarty的缓存目录和编译目录及image目录是否有执行rename()函数的权限 */
		$tpl_list   = array();
		$tpl_dirs[] = $Cache_Current_Path . 'temp/template_caches';
		$tpl_dirs[] = $Cache_Current_Path . 'temp/template_compiled';
		$tpl_dirs[] = $Cache_Current_Path . 'temp/template_compiled/admin';

		foreach ($tpl_dirs AS $dir) {
			$mask = RC_File::file_mode_info(SITE_ROOT .$dir);
			if (($mask & 4) > 0) {
				/* 之前已经检查过修改权限，只有有修改权限才检查rename权限 */
				if (($mask & 8) < 1) {
					$tpl_list[] = $dir;
				}
			}
		}
		$tpl_msg = implode(', ', $tpl_list);
		$this->assign('list',		$list);
		$this->assign('tpl_msg',	$tpl_msg);
		$this->assign('nav_tabs',	$this->nav_tabs);
		
		$this->display('check_file_priv.dwt');
	}

}

// end