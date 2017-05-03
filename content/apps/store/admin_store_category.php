<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺分类管理
 */
class admin_store_category extends ecjia_admin {
	private $seller_category_db;
	private $seller_shopinfo_db;
	
	public function __construct() {
		
		parent::__construct();
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		RC_Loader::load_app_func('merchant_store_category', 'store');
		
		//全局JS和CSS
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-editable.min',RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		
		RC_Script::enqueue_script('jquery.toggle.buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/jquery.toggle.buttons.js'));
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url('statics/lib/toggle_buttons/bootstrap-toggle-buttons.css'));
		
		RC_Script::enqueue_script('store_category', RC_App::apps_url('statics/js/store_category.js', __FILE__), array(), false, true);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺分类'), RC_Uri::url('seller/admin_store_category/init')));
	}
	
	/**
	 * 店铺分类列表
	 */
	public function init() {
	    $this->admin_priv('store_category_manage');
		
	    ecjia_screen::get_current_screen()->remove_last_nav_here();
	    ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('店铺分类')));
	   
	    $cat_list = cat_list(0, 0, false);
	    $this->assign('cat_info', $cat_list);
	    $this->assign('ur_here',__('店铺分类'));
	    $this->assign('action_link', array('text' => __('添加分类'),'href'=>RC_Uri::url('store/admin_store_category/add')));
	    $this->display('store_category_list.dwt');
	}
	
	/**
	 * 添加店铺分类
	 */
	public function add() {
	    $this->admin_priv('store_category_manage');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('添加店铺分类')));
		$this->assign('ur_here', __('添加分类'));
		$this->assign('action_link',  array('href' => RC_Uri::url('store/admin_store_category/init'), 'text' => __('店铺分类')));
		
		$this->assign('cat_select', cat_list(0, 0, true));
		$this->assign('form_action', RC_Uri::url('store/admin_store_category/insert'));

		$this->display('store_category_info.dwt');
	}

	/**
	 * 店铺分类添加时的处理
	 */
	public function insert() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
		
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])        : '';
		$cat['parent_id'] 	 = !empty($_POST['store_cat_id']) ? intval($_POST['store_cat_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order'])    : 0;
		$cat['is_show'] 	 = isset($_POST['is_show'])       ? 1                               : 0;
		$cat['keywords']     = !empty($_POST['keywords'])     ? trim($_POST['keywords'])        : '';
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']              : '';
	
		if (cat_exists($cat['cat_name'], $cat['parent_id'])) {
			return $this->showmessage('已存在相同的分类名称!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/*分类图片上传*/
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/store_category', 'auto_sub_dirs' => true));
		if (isset($_FILES['cat_image']) && $upload->check_upload_file($_FILES['cat_image'])) {
			$image_info = $upload->upload($_FILES['cat_image']);
			if (empty($image_info)) {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$cat['cat_image'] = $upload->get_position($image_info);
		}
		
		/* 入库的操作 */
		$insert_id = RC_DB::table('store_category')->insertGetId($cat);
		if ($insert_id) {
			ecjia_admin::admin_log($_POST['cat_name'], 'add', 'store_category');   // 记录管理员操作
			/*添加链接*/
			$links[] = array('text' => '店铺分类列表', 'href'=> RC_Uri::url('store/admin_store_category/init'));
			$links[] = array('text' => '继续添加分类', 'href'=> RC_Uri::url('store/admin_store_category/add'));
			return $this->showmessage('添加店铺分类成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links ,'pjaxurl' => RC_Uri::url('store/admin_store_category/edit', array('cat_id' => $insert_id))));
		} else {
			return $this->showmessage('添加店铺分类失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	
	/**
	 * 编辑店铺分类信息
	 */
	public function edit() {
		$this->admin_priv('store_category_manage');
		$cat_id = intval($_GET['cat_id']);
		$cat_info = get_cat_info($cat_id);  // 查询分类信息数据
		
		if(!empty($cat_info['cat_image'])) {
			$cat_info['cat_image'] =  RC_Upload::upload_url($cat_info['cat_image']);
		} else {
			$cat_info['cat_image'] = '';
		}
	
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('编辑店铺分类')));
		$this->assign('ur_here', __('编辑店铺分类'));
		$this->assign('action_link', array('text' => __('编辑店铺分类'), 'href' => RC_Uri::url('store/admin_store_category/init')));

		$this->assign('cat_info', $cat_info);
		$this->assign('cat_select', cat_list(0, $cat_info['parent_id'], true));
		
		$this->assign('form_action', RC_Uri::url('store/admin_store_category/update'));

		$this->display('store_category_info.dwt');
	}
	
	/**
	 * 编辑商品分类信息
	 */
	public function update() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
		
		$cat_id              = !empty($_POST['cat_id'])       ? intval($_POST['cat_id'])        : 0;
		$cat['cat_name']     = !empty($_POST['cat_name'])     ? trim($_POST['cat_name'])        : '';
		$cat['parent_id']	 = !empty($_POST['store_cat_id']) ? intval($_POST['store_cat_id'])  : 0;
		$cat['sort_order']   = !empty($_POST['sort_order'])   ? intval($_POST['sort_order'])    : 0;
		$cat['is_show'] 	 = isset($_POST['is_show'])       ? 1                               : 0;
		$cat['keywords']     = !empty($_POST['keywords'])     ? trim($_POST['keywords'])        : '';
		$cat['cat_desc']     = !empty($_POST['cat_desc'])     ? $_POST['cat_desc']              : '';
		
		$old_cat_name     	 = !empty($_POST['old_cat_name '])     ? trim($_POST['old_cat_name '])     : '';
		
		/* 判断分类名是否重复 */
		if ($cat['cat_name'] != $old_cat_name) {
			if (cat_exists($cat['cat_name'], $cat['parent_id'], $cat_id)) {
				return $this->showmessage('已存在相同的分类名称!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}	
		/* 判断上级目录是否合法 */
		$children = array_keys(cat_list($cat_id, 0, false));     // 获得当前分类的所有下级分类
		if (in_array($cat['parent_id'], $children)) {
			/* 选定的父类是当前分类或当前分类的下级分类 */
			return $this->showmessage(__('所选择的上级分类不能是当前分类或者当前分类的下级分类!'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 更新分类图片 */
		$upload = RC_Upload::uploader('image', array('save_path' => 'data/category', 'auto_sub_dirs' => true));
		
		if (isset($_FILES['cat_image']) && $upload->check_upload_file($_FILES['cat_image'])) {
			$image_info = $upload->upload($_FILES['cat_image']);
			if (empty($image_info)) {
				return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
			$cat['cat_image'] = $upload->get_position($image_info);
		}
		RC_DB::table('store_category')
						->where('cat_id', $cat_id)
						->update($cat);
		/*记录log */
		ecjia_admin::admin_log($_POST['cat_name'], 'edit', 'store_category');
		$link[] = array('text' => __('返回店铺分类列表'), 'href' => RC_Uri::url('store/admin_store_category/init'));
		return $this->showmessage('编辑店铺分类成功！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $link, 'id' => $cat_id));
	}
	
	/**
	 * 删除店铺分类
	 */
	public function remove() {
		$this->admin_priv('store_category_drop', ecjia::MSGTYPE_JSON);
		/* 初始化分类ID并取得分类名称 */
		$cat_id   = intval($_GET['id']);

		$cat_name = RC_DB::table('store_category')->where('cat_id', $cat_id)->pluck('cat_name');

		/* 当前分类下是否有子分类 */
		$cat_count = RC_DB::table('store_category')->where('parent_id', $cat_id)->count();
		
		/* 当前分类下是否存在店铺 */
		$franchisee_count = RC_DB::table('store_franchisee')->where('cat_id', $cat_id)->count();
		$preaudit_count   = RC_DB::table('store_preaudit')->where('cat_id', $cat_id)->count();
		
		/* 如果不存在下级子分类和商品，则删除之 */
		if ($cat_count == 0 && $franchisee_count == 0 && $preaudit_count == 0) {
			/* 删除分类 */
			RC_DB::table('store_category')->where('cat_id', $cat_id)->delete();
			//记录log
			ecjia_admin::admin_log($cat_name, 'remove', 'store_category');
			return $this->showmessage(__('删除店铺分类成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		} else {
			return $this->showmessage($cat_name .' '. '不是末级分类或者此分类下还存在有店铺，您不能删除!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 切换是否显示
	 */
	public function toggle_is_show() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
	
		$id = intval($_POST['id']);
		$val = intval($_POST['val']);
		
		$cat_name = RC_DB::table('store_category')->where('cat_id', $id)->pluck('cat_name');
		if (cat_update($id, array('is_show' => $val))) {
			//记录log
			ecjia_admin::admin_log($cat_name, 'edit', 'store_category');
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $val));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 编辑排序序号
	 */
	public function edit_sort_order() {
		$this->admin_priv('store_category_manage', ecjia::MSGTYPE_JSON);
	
		$id       = intval($_POST['pk']);
		$val      = intval($_POST['value']);
		$cat_name = RC_DB::table('store_category')->where('cat_id', $id)->pluck('cat_name');
		if (cat_update($id, array('sort_order' => $val))) {
			//记录log
			ecjia_admin::admin_log($cat_name, 'edit', 'store_category');
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('store/admin_store_category/init')));
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('store_category_drop', ecjia::MSGTYPE_JSON);	
		$cat_id     = trim($_GET['cat_id']);
	
		$cat_image = RC_DB::table('store_category')->where('cat_id', $cat_id)->select('cat_image')->first();
		$disk = RC_Filesystem::disk();
		if (!empty($cat_image['cat_image'])) {
			$disk->delete(RC_Upload::upload_path() . $cat_image['cat_image']);
		}
		
		ecjia_admin::admin_log('', 'remove', 'store_category');
		RC_DB::table('store_category')->where('cat_id', $cat_id)->update(array('cat_image' => ''));
		return $this->showmessage(RC_Lang::get('store::store.del_store_cat_img_ok') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

//end