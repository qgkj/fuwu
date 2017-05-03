<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 地区列表管理文件
 */
class admin_area_manage extends ecjia_admin {
	private $db;
	public function __construct() {
		parent::__construct();

		$this->db = RC_Loader::load_model('region_model');		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		$this->assign('_FILE_STATIC', RC_Uri::admin_url('statics/'));
		RC_Script::enqueue_script('admin_region', RC_App::apps_url('statics/js/admin_region.js', __FILE__), array(), false, true);
		
	}

	/**
	 * 列出某地区下的所有地区列表
	 */
	public function init() {
		$this->admin_priv('area_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('地区列表')));
		$this->assign('ur_here', __('地区列表'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台地区设置页面，用户可以在此进行设置地区。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E5.9C.B0.E5.8C.BA.E5.88.97.E8.A1.A8" target="_blank">关于地区设置帮助文档</a>') . '</p>'
		);

		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		$region_arr = $this->db->where(array('parent_id'=>$id))->select();
		if ($id == 0) {
			$region_type = 0;
		} else {
			$region_type = $this->db->where(array('region_id'=>$id))->get_field('region_type');
			$region_type++;
		}
		$this->assign('region_arr',   $region_arr);
		$this->assign('parent_id',    $id);
		$this->assign('region_type',  $region_type);

		if (!empty($id)) {
			$parent_id = $this->db->where(array('region_id'=>$id))->get_field('parent_id');
			$this->assign('action_link',	array('href'=>RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id), 'text' => __('返回上级')));
		}

		$this->display('area_list.dwt');
	}


	public function area_info(){
		$id         = intval($_POST['id']);
		$region_arr = ecjia_area::area_list('parent_id ='.$id);

		header('Content-type: text/json');
		echo json_encode($region_arr);die;
	}

	/**
	 * 添加新的地区
	 */
	public function add_area() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$parent_id      = intval($_POST['parent_id']);
		$region_name    = trim($_POST['region_name']);
		$region_type    = intval($_POST['region_type']);
		
		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		/* 查看区域是否重复 */		
		$is_only = $this->db->where(array('region_name' => $region_name, 'parent_id'=>$parent_id))->count();
		if ($is_only) {
			 $this->showmessage(__('抱歉，已经有相同的地区名存在！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$data = array(
				'parent_id'   => $parent_id,
				'region_name' => $region_name,
				'region_type' => $region_type,
			);
			
			$region_id = $this->db->insert($data);
			
			if ($region_id) {
				$region_href=RC_Uri::url('setting/admin_area_manage/drop_area',array('id' => $region_id));
				ecjia_admin::admin_log($region_name, 'add','area');
				$this->showmessage(__('添加新地区成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id)));
			} else {
				$this->showmessage(__('添加新地区失败！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 编辑区域名称
	 */
	public function edit_area_name() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$id          = intval($_POST['id']);
		$region_name = trim($_POST['region_name']);
		if (empty($region_name)) {
			$this->showmessage(__('区域名称不能为空！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
        $old =$this->db->field('region_name,parent_id')->where(array('region_id' => $id))->find();
		$parent_id = $old['parent_id'];
		$old_name = $old['region_name'];
		
		/* 查看区域是否重复 */
		$is_only = $this->db->where(array('region_name' => $region_name, 'parent_id'=>$parent_id))->count();
		if ($is_only) {
			$this->showmessage(__('抱歉，已经有相同的地区名存在！'),ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {		
			if ($this->db->where(array('region_id' => $id))->update(array('region_name' => $region_name))) {
				ecjia_admin::admin_log(sprintf(__('更新地区名称为 %s'), $region_name), 'edit', 'area');
				$this->showmessage(__('修改名称成功！'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('setting/admin_area_manage/init', 'id='.$parent_id)));
			} else {
				$this->showmessage($this->db->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
	}

	/**
	 * 删除区域
	 */
	public function drop_area() {
		$this->admin_priv('area_manage', ecjia::MSGTYPE_JSON);

		$id = intval($_REQUEST['id']);

		$region = $this->db->where('region_id = '.$id.'')->find();

		$region_type_max = $this->db->max('region_type');
		$region_type     =$region['region_type'];
		$regionname      =$region['region_name'];
		$delete_region[] =$id;
		$new_region_id   =$id;

		for ($i=0; $i<=$region_type_max-$region_type; $i++) {
			$new_region_id = $this->new_region_id($new_region_id);
			if(count($new_region_id)) {
				$delete_region = array_merge($delete_region, $new_region_id);
			} else {
				continue;
			}
		}

		$this->db->in(array('region_id' => $delete_region))->delete();

		ecjia_admin::admin_log(addslashes($regionname), 'remove', 'area');

		$this->showmessage(sprintf(__('成功删除地区 %s'), $regionname), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	private function new_region_id($region_id) {
	    $db = RC_Loader::load_model('region_model');

	    $regions_id = array();
	    if (empty($region_id)) {
	        return $regions_id;
	    }

	    $result = $db->field('region_id')->in(array('parent_id' => $region_id))->select();

	    if (!empty($result)) {
	        foreach($result as $val) {
	            $regions_id[]=$val['region_id'];
	        }
	    }
	    return $regions_id;
	}


	/**
	 * 格式化地区
	 * @param array $list
	 * @param number $pid
	 * @return multitype:unknown
	 */
	private function formart_area(&$list, $pid = 0) {
	    $tree = array();
	    foreach ($list as $v) {
	        if ($v['parent_id'] == $pid) {
	            //是否有子项
	            $v['has_child'] = 1;
	            $v['child'] = $this->formart_area($list, $v['region_id']);
	            $tree[] = $v;
	        }
	    }
	    return $tree;
	}


	/**
	 * 格式化出HTML的地区
	 * @param unknown $list
	 * @param number $pid
	 * @return string
	 */
	private function formart_html(&$list, $pid = 0) {
	    $html = '';
	    foreach ($list as $v) {
	        if ($v['parent_id'] == $pid) {
	            $html .= '<div style="padding-left:10px;">';
	            $html .= '<p class="pid'. $v['parent_id'] .' id'. $v['region_id'] .' type'. $v['region_type'] .'">' . $v['region_name'] . '</p>';
	            $html .= $this->formart_html($list, $v['region_id']);
	            $html .= '</div>';
	        }
	    }
	    return $html;
	}
}

// end