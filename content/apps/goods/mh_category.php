<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品分类管理程序
 */
class mh_category extends ecjia_merchant {
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('admin_goods');
		RC_Loader::load_app_func('merchant_goods');
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');

		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('uniform-aristo');
		
		RC_Script::enqueue_script('goods_category', RC_App::apps_url('statics/js/merchant_goods_category.js',__FILE__), array());
		RC_Script::localize_script('goods_category_list', 'js_lang', RC_Lang::get('goods::goods.js_lang'));

		RC_Script::enqueue_script('bootstrap-editable-script', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/js/bootstrap-editable.min.js', array());
		RC_Style::enqueue_style('bootstrap-editable-css', dirname(RC_App::app_dir_url(__FILE__)) . '/merchant/statics/assets/x-editable/bootstrap-editable/css/bootstrap-editable.css', array(), false, false);
		
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('商品管理', RC_Uri::url('goods/merchant/init')));
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.goods_category'), RC_Uri::url('goods/mh_category/init')));
		ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/mh_category.php');
	}

	/**
	 * 商品分类列表
	 */
	public function init() {
	    $this->admin_priv('merchant_category_manage');

		$cat_list = merchant_cat_list(0, 0, false);

		ecjia_merchant_screen::get_current_screen()->remove_last_nav_here();
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__(RC_Lang::get('goods::category.goods_category'))));

		$this->assign('ur_here', RC_Lang::get('goods::category.goods_category'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/add'), 'text' => RC_Lang::get('goods::category.add_goods_cat')));
		$this->assign('action_link1', array('href' => RC_Uri::url('goods/mh_category/move'), 'text' => RC_Lang::get('goods::category.move_goods')));
		$this->assign('cat_info', $cat_list);

		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::category.overview'),
            'content'	=> '<p>' . RC_Lang::get('goods::category.goods_category_help') . '</p>'
		));

		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::category.more_info') . '</strong></p>' .
            '<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品分类#.E5.95.86.E5.93.81.E5.88.86.E7.B1.BB.E5.88.97.E8.A1.A8" target="_blank">'. RC_Lang::get('goods::category.about_goods_category') .'</a>') . '</p>'
		);

		$this->display('category_list.dwt');
	}

	/**
	 * 添加商品分类
	 */
	public function add() {
	    $this->admin_priv('merchant_category_update');

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.add_goods_cat')));
		
		$this->assign('ur_here', RC_Lang::get('goods::category.add_goods_cat'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/init'), 'text' => RC_Lang::get('goods::category.goods_category')));
		
		$this->assign('attr_list', get_category_attr_list()); // 取得商品属性
		
		$this->assign('cat_select', merchant_cat_list(0, 0, true, 1));
		$this->assign('cat_info', array('is_show' => 1));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/insert'));

		$this->display('category_info.dwt');
	}

	/**
	 * 商品分类添加时的处理
	 */
	public function insert() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$cat['cat_id']       = !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])     : 0;
		$cat['parent_id']    = !empty($_POST['parent_id'])    ? intval($_POST['parent_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']           : '';
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])     : '';
		$cat['is_show']      = !empty($_POST['is_show'])      ? intval($_POST['is_show'])    : 0;
		$cat['store_id']	 = !empty($_SESSION['store_id'])  ? $_SESSION['store_id']		 : 0;
		
		if (merchant_cat_exists($cat['cat_name'], $cat['parent_id'])) {
		    return $this->showmessage(RC_Lang::get('goods::category.catname_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if ($cat['grade'] > 10 || $cat['grade'] < 0) {
			return $this->showmessage(RC_Lang::get('goods::category.grade_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		/* 入库的操作 */
		$cat_id = RC_DB::table('merchants_category')->insertGetId($cat);

		ecjia_merchant::admin_log($_POST['cat_name'], 'add', 'category');   // 记录管理员操作

		$link[0]['text'] = RC_Lang::get('goods::category.continue_add');
		$link[0]['href'] = RC_Uri::url('goods/mh_category/add');
            
		$link[1]['text'] = RC_Lang::get('goods::category.back_list');
		$link[1]['href'] = RC_Uri::url('goods/mh_category/init');
			
		return $this->showmessage(RC_Lang::get('goods::category.catadd_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'pjaxurl' => RC_Uri::url('goods/mh_category/edit', array('cat_id' => $cat_id))));
	}

	/**
	 * 编辑商品分类信息
	 */
	public function edit() {
		$this->admin_priv('merchant_category_update');

		$cat_id = intval($_GET['cat_id']);
		$cat_info = get_merchant_cat_info($cat_id);  // 查询分类信息数据
		if (empty($cat_info)) {
			return $this->showmessage('未检测到该商品分类', ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
		}

		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.category_edit')));
		$this->assign('ur_here',RC_Lang::get('goods::category.category_edit'));
		$this->assign('action_link', array('text' => RC_Lang::get('goods::category.goods_category'), 'href' => RC_Uri::url('goods/mh_category/init')));

		
		$this->assign('cat_info', $cat_info);
		$this->assign('cat_select', merchant_cat_list(0, $cat_info['parent_id'], true, 1));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/update'));

		$this->display('category_info.dwt');
	}

	public function add_category() {
	    $this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
	    
		$parent_id 	= empty($_REQUEST['parent_id'])	? 0		: intval($_REQUEST['parent_id']);
		$category 	= empty($_REQUEST['cat']) 		? '' 	: trim($_REQUEST['cat']);
		
		if (merchant_cat_exists($category, $parent_id)) {
			return $this->showmessage(RC_Lang::get('goods::category.catname_exist'));
		} else {
			$data = array(
				'cat_name' 	=> $category,
				'parent_id'	=> $parent_id,
				'is_show' 	=> '1',
			);
			$category_id = RC_DB::table('merchants_category')->insertGetId($data);
			
			$arr = array("parent_id" => $parent_id, "id" => $category_id, "cat" => $category);
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $arr));
		}
	}

	/**
	 * 编辑商品分类信息
	 */
	public function update() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);

		$cat_id           	= !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])     : 0;
		$cat['parent_id']	= !empty($_POST['parent_id'])    ? intval($_POST['parent_id'])  : 0;
		$cat['sort_order']	= !empty($_POST['sort_order'])   ? intval($_POST['sort_order']) : 0;
		$cat['cat_desc'] 	= !empty($_POST['cat_desc'])     ? $_POST['cat_desc']           : '';
		$cat['cat_name']  	= !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])     : '';
		$cat['is_show'] 	= !empty($_POST['is_show'])      ? intval($_POST['is_show'])    : 0;
		$cat['store_id']	= !empty($_SESSION['store_id'])  ? $_SESSION['store_id']		 : 0;
		
		/* 判断分类名是否重复 */
		if (merchant_cat_exists($cat['cat_name'], $cat['parent_id'], $cat_id)) {
			$link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
			return $this->showmessage(RC_Lang::get('goods::category.catname_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
		}

		/* 判断上级目录是否合法 */
		$children = array_keys(merchant_cat_list($cat_id, 0, false));     // 获得当前分类的所有下级分类
		if (in_array($cat['parent_id'], $children)) {
			/* 选定的父类是当前分类或当前分类的下级分类 */
			$link[] = array('text' => RC_Lang::get('system::system.go_back'), 'href' => 'javascript:history.back(-1)');
			return $this->showmessage(RC_Lang::get('goods::category.is_leaf_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('links' => $link));
		}

		RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($cat);

		ecjia_merchant::admin_log($cat['cat_name'], 'edit', 'category');
		
		return $this->showmessage(RC_Lang::get('goods::category.catedit_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_category/edit', array('cat_id' => $cat_id))));
	}

	/**
	 * 批量转移商品分类页面
	 */
	public function move() {
		$this->admin_priv('merchant_category_update');

		$cat_id = !empty($_REQUEST['cat_id']) ? intval($_REQUEST['cat_id']) : 0;
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::category.move_goods')));
		ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('goods::category.overview'),
			'content'	=> '<p>' . RC_Lang::get('goods::category.move_category_help') . '</p>'
		));
		
		ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('goods::category.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品分类#.E8.BD.AC.E7.A7.BB.E5.95.86.E5.93.81" target="_blank">'. RC_Lang::get('goods::category.about_move_category') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('goods::category.move_goods'));
		$this->assign('action_link', array('href' => RC_Uri::url('goods/mh_category/init'), 'text' => RC_Lang::get('goods::category.goods_category')));

		$this->assign('cat_select', merchant_cat_list(0, $cat_id, false));
		$this->assign('form_action', RC_Uri::url('goods/mh_category/move_cat'));

		$this->display('category_move.dwt');
	}

	/**
	 * 处理批量转移商品分类的处理程序
	 */
	public function move_cat() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);

		$cat_id        = !empty($_POST['cat_id'])        ? intval($_POST['cat_id'])        : 0;
		$target_cat_id = !empty($_POST['target_cat_id']) ? intval($_POST['target_cat_id']) : 0;

		/* 商品分类不允许为空 */
		if ($cat_id == 0 || $target_cat_id == 0) {
			return $this->showmessage(RC_Lang::get('goods::category.cat_move_empty'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		/* 更新商品分类 */
		$data = array('merchant_cat_id' => $target_cat_id);
		
		$new_cat_name = RC_DB::table('merchants_category')->where('cat_id', $target_cat_id)->pluck('cat_name');
		$old_cat_name = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->pluck('cat_name');
		
		RC_DB::table('goods')->where('merchant_cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->update($data);

		ecjia_merchant::admin_log('从'.$old_cat_name.'转移到'.$new_cat_name, 'move', 'category_goods');
		
		return $this->showmessage(RC_Lang::get('goods::category.move_cat_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = intval($_POST['value']);

		if (merchant_cat_update($id, array('sort_order' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.sort_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('goods/mh_category/init')));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.sort_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑数量单位
	 */
	public function edit_measure_unit() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = $_POST['value'];
		
		if (merchant_cat_update($id, array('measure_unit' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.number_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.number_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 编辑价格分级
	 */
	public function edit_grade() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['pk']);
		$val = !empty($_POST['val']) ? intval($_POST['value']) : 0;

		if ($val > 10 || $val < 0) {
			/* 价格区间数超过范围 */
			return $this->showmessage(RC_Lang::get('goods::category.grade_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}

		if (merchant_cat_update($id, array('grade' => $val))) {
			return $this->showmessage(RC_Lang::get('goods::category.grade_edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage(RC_Lang::get('goods::category.grade_edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 切换是否显示
	 */
	public function toggle_is_show() {
		$this->admin_priv('merchant_category_update', ecjia::MSGTYPE_JSON);
		
		$id = intval($_POST['id']);
		$val = intval($_POST['val']);
		$name = RC_DB::table('merchants_category')->where('cat_id', $id)->pluck('cat_name');
		
		if (merchant_cat_update($id, array('is_show' => $val))) {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}

	/**
	 * 删除商品分类
	 */
	public function remove() {
    	$this->admin_priv('merchant_category_delete', ecjia::MSGTYPE_JSON);

		$cat_id = intval($_GET['id']);
		
		$cat_name = RC_DB::table('merchants_category')->where('cat_id', $cat_id)->pluck('cat_name');
		$cat_count = RC_DB::table('merchants_category')->where('parent_id', $cat_id)->count();
		
		$goods_count = RC_DB::table('goods')->where('merchant_cat_id', $cat_id)->count();
		if ($cat_count == 0 && $goods_count == 0) {
			RC_DB::table('merchants_category')->where('cat_id', $cat_id)->where('store_id', $_SESSION['store_id'])->delete();
			
			ecjia_merchant::admin_log($cat_name, 'remove', 'category');
			return $this->showmessage(RC_Lang::get('goods::category.catdrop_succed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage($cat_name .' '. RC_Lang::get('goods::category.cat_isleaf'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
}

// end