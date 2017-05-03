<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 会员等级管理程序
*/
class admin_rank extends ecjia_admin {
	private $db_user;
	private $db_user_rank;
	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('admin_user');
		RC_Loader::load_app_func('global', 'goods');
		$this->db_user		= RC_Model::model('user/users_model');
		$this->db_user_rank	= RC_Model::model('user/user_rank_model');
		
		/* 加载全局js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-editable.min', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('user_info', RC_App::apps_url('statics/js/user_info.js', __FILE__));
		$rank_jslang = array(
			'rank_name_required'	=> RC_Lang::get('user::user_rank.rank_name_confirm'),
			'min_points_required'	=> RC_Lang::get('user::user_rank.min_points_confirm'),
			'max_points_required'	=> RC_Lang::get('user::user_rank.max_points_confirm'),
			'discount_required'		=> RC_Lang::get('user::user_rank.discount_required_confirm'),
		);
		RC_Script::localize_script('user_info', 'rank_jslang', $rank_jslang );
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_rank.rank'), RC_Uri::url('user/admin_rank/init')));
	}

	/**
	 * 会员等级列表
	 */
	public function init() {
		$this->admin_priv('user_rank');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_rank.rank')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.user_rank_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info')  . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级" target="_blank">'.RC_Lang::get('user::users.about_user_rank').'</a>') . '</p>'
		);
		$this->assign('ur_here',		RC_Lang::get('system::system.05_user_rank_list'));
		$this->assign('action_link',	array('text' => RC_Lang::get('user::user_rank.add_user_rank'), 'href' => RC_Uri::url('user/admin_rank/add')));
		
		$ranks = RC_DB::table('user_rank')->orderBy('rank_id', 'desc')->get();
		$this->assign('user_ranks', $ranks);
		
		$this->display('user_rank_list.dwt');
	}
	
	/**
	 * 添加会员等级
	 */
	public function add() {
		$this->admin_priv('user_rank');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('user::user_rank.add_user_rank')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('user::users.overview'),
			'content'	=>
			'<p>' . RC_Lang::get('user::users.add_rank_help'). '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('user::users.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级#.E6.B7.BB.E5.8A.A0.E4.BC.9A.E5.91.98.E7.AD.89.E7.BA.A7" target="_blank">'.RC_Lang::get('user::users.about_add_rank').'</a>') . '</p>'
		);

		$this->assign('ur_here',		RC_Lang::get('user::user_rank.add_user_rank'));
		$this->assign('action_link',	array('text' => RC_Lang::get('system::system.05_user_rank_list'), 'href' => RC_Uri::url('user/admin_rank/init')));
		
		$rank['rank_special']	= 0;
		$rank['show_price']		= 1;
		$rank['min_points']		= 0;
		$rank['max_points']		= 0;
		$rank['discount']		= 100;
		
		$this->assign('rank',			$rank);
		$this->assign('form_action',	RC_Uri::url('user/admin_rank/insert'));
		
		$this->display('user_rank_edit.dwt');
	}
	
	/**
	 * 增加会员等级到数据库
	 */
	public function insert() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		$rank_name		= trim($_POST['rank_name']);
		$special_rank	= isset($_POST['special_rank'])		? intval($_POST['special_rank']) : 0;
		$min_points		= empty($_POST['min_points'])		? 0 : intval($_POST['min_points']);
		$max_points		= empty($_POST['max_points'])		? 0 : intval($_POST['max_points']);
		$discount		= empty($_POST['discount'])			? 0 : intval($_POST['discount']);
		$show_price		= empty($_POST['show_price'])		? 0 : intval($_POST['show_price']);
		
		/* 检查是否存在重名的会员等级 */
		if (RC_DB::table('user_rank')->where('rank_name', $rank_name)->count() != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.rank_name_exists'), $rank_name), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 非特殊会员组检查积分的上下限是否合理 */
		if ($min_points >= $max_points && $special_rank == 0) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_max_small'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 特殊等级会员组不判断积分限制 */
		if ($special_rank == 0) {
			/* 检查下限制有无重复 */
			if (RC_DB::table('user_rank')->where('min_points', $min_points)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_min_exists'), $min_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			/* 检查上限有无重复 */
			if (RC_DB::table('user_rank')->where('max_points', $max_points)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_max_exists'), $max_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		/* 折扣验证 (0-100) */
		if ($discount > 100 || $discount < 0 || !is_numeric($discount) || empty($discount)) {
			return $this->showmessage(RC_Lang::get('user::user_rank.notice_discount'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'rank_name'		=> $rank_name,
			'min_points'	=> $min_points,
			'max_points'	=> $max_points,
			'discount'		=> $discount,
			'special_rank'	=> $special_rank,
			'show_price'	=> $show_price,
		);
		$new_id = RC_DB::table('user_rank')->insertGetId($data);
		
		ecjia_admin::admin_log($rank_name, 'add', 'user_rank');
		$links[] = array('text' => RC_Lang::get('user::user_rank.back_list'), 'href' => RC_Uri::url('user/admin_rank/init'));
		$links[] = array('text' => RC_Lang::get('user::user_rank.add_continue'), 'href' => RC_Uri::url('user/admin_rank/add'));
		return $this->showmessage(RC_Lang::get('user::user_rank.rank')."[ ". $rank_name ."]".RC_Lang::get('user::user_rank.add_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_rank/edit', array('id' => $new_id))));

	}
	
	/**
	 * 编辑会员等级
	 */
	public function edit() {
		$this->admin_priv('user_rank');

	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑会员等级')));
	    ecjia_screen::get_current_screen()->add_help_tab(array(
		    'id'		=> 'overview',
		    'title'		=> RC_Lang::get('user::users.overview'),
		    'content'	=>
		    '<p>' . RC_Lang::get('user::users.edit_rank_help') . '</p>'
	    ));
	    
	    ecjia_screen::get_current_screen()->set_help_sidebar(
	    	'<p><strong>' . RC_Lang::get('user::users.more_info') . '</strong></p>' .
	   	 	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:会员等级#.E7.BC.96.E8.BE.91.E4.BC.9A.E5.91.98.E7.AD.89.E7.BA.A7" target="_blank">'.RC_Lang::get('user::users.about_edit_rank').'</a>') . '</p>'
	    );
	    $this->assign('ur_here',		RC_Lang::get('user::user_rank.edit_user_rank'));
	    $this->assign('action_link',	array('text' => RC_Lang::get('system::system.05_user_rank_list'), 'href' => RC_Uri::url('user/admin_rank/init')));
	    
	    $id = $_REQUEST['id'];
		$rank = RC_DB::table('user_rank')->where('rank_id', $id)->first();

	    $this->assign('rank',			$rank);
	    $this->assign('form_action',	RC_Uri::url('user/admin_rank/update'));
	    
	    $this->display('user_rank_edit.dwt');
	}
	
	/**
	 * 更新会员等级到数据库
	 */
	public function update() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		$id				= $_POST['id']; 
		$rank_name		= trim($_POST['rank_name']);
		$special_rank	= isset($_POST['special_rank'])		? intval($_POST['special_rank']) : 0;
		$min_points		= empty($_POST['min_points'])		? 0 : intval($_POST['min_points']);
		$max_points		= empty($_POST['max_points'])		? 0 : intval($_POST['max_points']);
		$discount		= empty($_POST['discount'])			? 0 : intval($_POST['discount']);
		$show_price		= empty($_POST['show_price'])		? 0 : intval($_POST['show_price']);
		
		/* 验证名称 是否重复  */
		$old_name 		= $_POST['old_name'];
		$old_min 		= $_POST['old_min'];
		$old_max 		= $_POST['old_max'];
		
		if ($rank_name != $old_name) {
			if (RC_DB::table('user_rank')->where('rank_name', $rank_name)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.rank_name_exists'), htmlspecialchars($rank_name)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		
		/* 非特殊会员组检查积分的上下限是否合理 */
		if ($min_points >= $max_points && $special_rank == 0) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_max_small'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 特殊等级会员组不判断积分限制 */
		if ($special_rank == 0) {
			if ($min_points != $old_min) {
				/* 检查下限有无重复 */
				if (RC_DB::table('user_rank')
					->where('min_points', $min_points)
					->where('rank_id', $id)
					->count() != 0) {
					return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_min_exists'), $min_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
			if ($max_points != $old_max) {
				/* 检查上限有无重复 */
				if (RC_DB::table('user_rank')
					->where('max_points', $max_points)
					->where('rank_id', $id)
					->count() != 0) {
					return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_max_exists'), $max_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}

		/* 折扣验证 (0-100) */
		if ($discount > 100 || $discount < 0 || !is_numeric($discount) || empty($discount)) {
			return $this->showmessage(RC_Lang::get('user::user_rank.notice_discount'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$data = array(
			'rank_name'		=> $rank_name,
			'min_points'	=> $min_points,
			'max_points'	=> $max_points,
			'discount'		=> $discount,
			'special_rank'	=> $special_rank,
			'show_price'	=> $show_price,
		);
		RC_DB::table('user_rank')->where('rank_id', $id)->update($data);
		
		
		ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');
		$links[] = array('text' => RC_Lang::get('user::user_rank.back_list'), 'href' => RC_Uri::url('user/admin_rank/init'));
		return $this->showmessage(RC_Lang::get('user::user_rank.rank')."[ ". $rank_name ."]".RC_Lang::get('user::user_rank.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('user/admin_rank/edit', "id=$id")));
	}
		
	/**
	 * 删除会员等级
	 */
	public function remove() {

		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		$rank_id = intval($_GET['id']);
		$rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->delete()) {
			/* 更新会员表的等级字段 */
			RC_DB::table('users')->where('user_rank', $rank_id)->update(array('user_rank' => 0));
			
			ecjia_admin::admin_log($rank_name, 'remove', 'user_rank');	
			return $this->showmessage(RC_Lang::get('user::user_rank.rank')."[ ".$rank_name." ]".RC_Lang::get('user::user_rank.delete_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 编辑会员等级名称
	 */
	public function edit_name() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$rank_id = intval($_POST['pk']);
		$val	 = trim($_POST['value']);

		/* 验证名称 ,根据id获取之前的名字  */
		$old_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');

		if (empty($val)) {
			return $this->showmessage(RC_Lang::get('user::user_rank.rank_name_confirm'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($val != $old_name) {
			if (RC_DB::table('user_rank')->where('rank_name', $val)->count() != 0) {
				return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.rank_name_exists'), htmlspecialchars($val)), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}

		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('rank_name' => $val))) {
			ecjia_admin::admin_log('等级名是 '.$val, 'edit', 'user_rank');
			
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * ajax编辑积分下限
	 */
	public function edit_min_points() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		$rank_id = intval($_REQUEST['pk']);
		$val	 = intval($_REQUEST['value']);
		
		/* 验证参数有效性  */
		if (!is_numeric($val) || empty($val) || $val <= 0 || strpos($val, '.') > 0) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_min_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查找该ID 对应的积分上限值,验证是否大于上限  */
		$max_points = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('max_points');

		if ($val >= $max_points ) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_max_small'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 验证是否存在 */
		if (RC_DB::table('user_rank')->where('min_points', $val)->where('rank_id', '!=', $rank_id)->count() != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_min_exists'), $val), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('min_points' => $val))) {

			$rank_name =RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
			ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');
			
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * ajax修改积分上限
	 */
	public function edit_max_points() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		$rank_id	= intval($_REQUEST['pk']);
		$val		= intval($_REQUEST['value']);
		
		/* 验证参数有效性  */
		if (!is_numeric($val) || empty($val) || $val <= 0 ) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_min_invalid'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 查找该ID 对应的积分下限值,验证是否大于上限  */
		$min_points =RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('min_points');
		if ($val <= $min_points ) {
			return $this->showmessage(RC_Lang::get('user::user_rank.js_languages.integral_max_small'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 验证是否存在 */
		if (RC_DB::table('user_rank')->where('max_points', $val)->where('rank_id', '!=', $rank_id)->count() != 0) {
			return $this->showmessage(sprintf(RC_Lang::get('user::user_rank.integral_max_exists'), $val), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('max_points' => $val))) {
			$rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
			
			ecjia_admin::admin_log($rank_name, 'edit', 'user_rank');
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 修改折扣率
	 */
	public function edit_discount() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$rank_id	= intval($_REQUEST['pk']);
		$val		= intval($_REQUEST['value']);
		
		/* 验证参数有效性  */
		if ($val < 1 || $val > 100 || !is_numeric($val) || empty($val)) {
			return $this->showmessage(RC_Lang::get('user::user_rank.notice_discount'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('discount' => $val))) {
			$rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
			
			ecjia_admin::admin_log(addslashes($rank_name), 'edit', 'user_rank');
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换是否是特殊会员组
	 */
	public function toggle_special() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$rank_id	= intval($_POST['id']);
		$is_special	= intval($_POST['val']);
		
		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('special_rank' => $is_special))) {
			$rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
			
			if ($is_special == 1) {
				ecjia_admin::admin_log($rank_name.'，'.RC_Lang::get('user::user_rank.show_price_short'), 'edit', 'user_rank');
			} else {
				ecjia_admin::admin_log($rank_name.'，'.RC_Lang::get('user::user_rank.hide_price_short'),  'edit', 'user_rank');
			}
			
			return $this->showmessage(RC_Lang::get('user::user_rank.change_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_show, 'pjaxurl' => RC_Uri::url('user/admin_rank/init')));
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换是否显示价格
	 */
	public function toggle_showprice() {
		$this->admin_priv('user_rank', ecjia::MSGTYPE_JSON);
		
		if (!empty($_SESSION['ru_id'])) {
			return $this->showmessage(RC_Lang::get('user::user_account.merchants_notice'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$rank_id	= intval($_POST['id']);
		$is_show	= intval($_POST['val']);

		if (RC_DB::table('user_rank')->where('rank_id', $rank_id)->update(array('show_price' => $is_show))) {
			$rank_name = RC_DB::table('user_rank')->where('rank_id', $rank_id)->pluck('rank_name');
			if ($is_show == 1) {
				ecjia_admin::admin_log($rank_name.'，'.RC_Lang::get('user::user_rank.join_group'), 'edit', 'user_rank');
			} else {
				ecjia_admin::admin_log($rank_name.'，'.RC_Lang::get('user::user_rank.remove_group'),  'edit', 'user_rank');
			}
			return $this->showmessage(RC_Lang::get('user::user_rank.change_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $is_special, 'pjaxurl' => RC_Uri::url('user/admin_rank/init')));
		} else {
			return $this->showmessage(RC_Lang::get('user::user_rank.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end 