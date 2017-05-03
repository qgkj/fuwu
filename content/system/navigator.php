<?php
  
/**
 * ECJIA 程序说明
 */
defined('IN_ECJIA') or exit('No permission resources.');

class navigator extends ecjia_admin {
	private $db_nav;
	public function __construct() {
		parent::__construct();

		$this->db_nav = RC_Loader::load_model('nav_model');

		if (!ecjia::config('navigator_data',2)) {
			ecjia_config::instance()->insert_config('hidden', 'navigator_data', serialize(array(array('type'=>'top','name'=>'顶部'),array('type'=>'middle','name'=>'中间'),array('type'=>'bottom','name'=>'底部'))), array('type' => 'hidden'));
		}
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');

		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
	}


	/**
	 * 菜单列表
	 */
	public function init() {
	    $this->admin_priv('navigator');

		$type = !empty($_GET['type'])?strip_tags(htmlspecialchars($_GET['type'])):'';
		$showstate = !empty($_GET['showstate'])?strip_tags(htmlspecialchars($_GET['showstate'])):'';

		RC_Script::enqueue_script('ecjia-admin_nav');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('菜单管理')));
		$this->assign('ur_here', __('菜单管理'));

		$admin_nav_jslang = array(
				'confirm_delete_menu'	=> __('确定要移除这个菜单项吗？'),
				'ok'					=> __('确定'),
				'cancel'				=> __('取消')
		);
		RC_Script::localize_script('ecjia-admin_nav', 'admin_nav_lang', $admin_nav_jslang );



		$this->assign('full_page',  1);
		$this->assign('showstate', $showstate);
		$this->assign('_FILE_STATIC', RC_Uri::admin_url('statics/'));

		$nav_list = unserialize(ecjia::config('navigator_data'));

		// 获取菜单名称
		$nav_name = '';
		if (!empty($nav_list)) {
			foreach ($nav_list as $v) {
				if (empty($type)) {
					$type = $v['type'];
					$nav_name = $v['name'];
					break;
				}
				if ($v['type'] == $type) {
				    $nav_name = $v['name'];
				}
			}
		} else {
			$this->add_nav_list();die;
		}

		//如果菜单不存在，报错
		if (empty($nav_name)) {
		    die(__('没有这个菜单'));
		}

		$navdb = $this->get_nav();
		$tmp_navdb = array();
		foreach ($navdb['navdb'] as $v) {
			if ($v['type'] == $type) {
			    $tmp_navdb[] = $v;
			}
		}

		$pagenav = $this->get_pagenav();
		// $categorynav = $this->get_categorynav();

		$this->assign('nav_list',     $nav_list);
		$this->assign('nav_type',     $type);
		$this->assign('nav_name',     $nav_name);
		$this->assign('navdb',        $tmp_navdb);
		$this->assign('pagenav',      $pagenav);
		// $this->assign('categorynav',  $categorynav);
		$this->assign('filter',       $navdb['filter']);
		$this->assign('record_count', $navdb['record_count']);
		$this->assign('page_count',   $navdb['page_count']);

		$this->display('navigator.dwt');
	}

	/**
	 * 添加菜单列表
	 */
	public function add_nav_list() {
		$this->admin_priv('navigator');

		RC_Script::enqueue_script('ecjia-admin_nav');

		$pagenav = $this->get_pagenav();
		// $categorynav = $this->get_categorynav();
		$this->assign('pagenav',      $pagenav);
		// $this->assign('categorynav',  $categorynav);
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('菜单管理')));
		$this->assign('ur_here', __('菜单管理'));

		$this->assign('nav_list',     unserialize(ecjia::config('navigator_data')));
		$this->assign('form_action',     RC_Uri::url('@navigator/init'));

		$this->display('navigator_addlist.dwt');
	}

	/**
	 * 执行添加菜单栏列表
	 */
	public function update_nav_list() {
		$name = strip_tags(htmlspecialchars($_GET['nav_name']));
		$list = unserialize(ecjia::config('navigator_data'));

		if (empty($name))die(__('菜单名不能为空'));

		//判断是否重复
		foreach ($list as $v) {
			if ($name == $v['name'])die(__('重复了'));
		}

		//插入新菜单
		$tmp = 'nav'.substr(time(),-5).rand(0, 99);
		$list[] = array('type'=>$tmp,'name'=>$name);

		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			$_GET['type'] = $tmp;
			$this->init();
		} else {
			echo __('失败');
		}

	}

	/**
	 * 编辑菜单内容
	 */
	public function edit_nav() {
		$navlist_del = strip_tags ( htmlspecialchars($_POST ['navlist_del']) );
		if (! empty ( $navlist_del )) {
			$nav_del = explode ( ',', $navlist_del );
			foreach ( $nav_del as $v ) {
				if (!empty($v)) $this->db_nav->where ('id='.$v.'')->delete();
			}
		}

		$navlist = $_POST['nav_list'];
		if (!empty($navlist)) {
			foreach ($navlist as $k=>$v) {
				if ($v['id'] == 'new') {
					unset($v['id']);
					$v['type'] = $_POST['nav_type'];
					$this->db_nav->insert($v);
				} else {
					$this->db_nav->where('id = '.$v['id'].'')->update($v);
				}
			}
		}

		$navlist_name = strip_tags(htmlspecialchars($_POST['navlist_name']));
		$type = strip_tags(htmlspecialchars($_POST['nav_type']));
		$list = unserialize(ecjia::config('navigator_data'));

		if (empty($type)) {
		    die(__('菜单名不能为空'));
		}

		//判断是否重复
		foreach ($list as $k => $v) {
			if ($type == $v['type'])$list[$k]['name'] = $navlist_name;
			if ($type == $v['name'] && $type != $v['type'])die(__('重复了'));
		}

		//插入新菜单
		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			echo 1;
		} else {
			echo 0;
		}
	}

	/**
	 * 删除菜单内容
	 */
	public function del_nav() {
		$id = intval($_POST['del_id']);
		if (empty($id))die('0');
		$this->db_nav->where('id = '.$id.'')->delete();
		echo 1;
	}

	/**
	 * 删除菜单
	 */
	public function del_navlist() {
		$type = strip_tags(htmlspecialchars($_GET['del_type']));
		$list = unserialize(ecjia::config('navigator_data'));

		//直接删除
		foreach ($list as $k => $v) {
			if ($v['type'] == $type)unset($list[$k]);
		}

		if (empty($list)) {
		    ecjia_config::instance()->write_config('navigator_data', '');
		}
		if (ecjia_config::instance()->write_config('navigator_data', serialize($list))) {
			$this->db_nav->where("type = '".$type."'")->delete();
			$this->init();
		} else {
			echo 0;
		}

	}

	/**
	 * 菜单栏列表Ajax
	 */
	public function query() {
		global $ecs, $db, $_CFG, $sess;

		$navdb = $this->get_nav();

		$this->assign('navdb',    $navdb['navdb']);
		$this->assign('filter',       $navdb['filter']);
		$this->assign('record_count', $navdb['record_count']);
		$this->assign('page_count',   $navdb['page_count']);

        return $this->showmessage($this->fetch_string('navigator.dwt'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('filter' => $navdb['filter'], 'page_count' => $navdb['page_count']));
	}

	/**
	 * 菜单栏删除
	 */
	public function del() {
		$id = intval($_GET['id']);

		$row = $this->db_nav->field('ctype,cid,type')->find(array('id' => $id));
		if ($row['type'] == 'middle' && $row['ctype'] && $row['cid']) {
			$this->set_show_in_nav($row['ctype'], $row['cid'], 0);
		}

		$this->db->where('id='.$id.'')->delete();
		return $this->redirect(RC_Uri::url('@navigator/init'));
	}

	/**
	 * 编辑排序
	 */
	public function edit_sort_order() {
		$this->admin_priv('nav', ecjia::MSGTYPE_JSON);

		$id    = intval($_POST['id']);
		$order = trim($_POST['val']);
	}

	private function get_nav() {
    	$db = RC_Loader::load_model('nav_model');
    	$filter['sort_by']      = empty($_REQUEST['sort_by']) ? 'type DESC, vieworder' : 'type DESC, '.trim($_REQUEST['sort_by']);
    	$filter['sort_order']   = empty($_REQUEST['sort_order']) ? 'ASC' : trim($_REQUEST['sort_order']);
    	$count = $db->count();
    	$filter['record_count'] = $count;
    	$sql = $db->field('id, name, ifshow, vieworder, opennew, url, type')->order($filter['sort_by'] . ' ' . $filter['sort_order'])->select();
    	$navdb = $sql;
    	$type = "";
    	$navdb2 = array();
    	if (!empty($navdb)) {
    		foreach($navdb as $k=>$v) {
    			if (!empty($type) && $type != $v['type']) {
    				$navdb2[] = array();
    			}
    			$navdb2[] = $v;
    			$type = $v['type'];
    		}
    	}

    	$arr = array('navdb' => $navdb2, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);

    	return $arr;
    }

    /**
     * 获得页面列表
     * @return multitype:multitype:string  multitype:string Ambigous <string, mixed>
     */
    private function get_pagenav() {
        return $sysmain = array(
            array(__('查看购物车'), 'flow.php'),
            array(__('选购中心'), 'pick_out.php'),
            array(__('团购商品'), 'group_buy.php'),
            array(__('夺宝奇兵'), 'snatch.php'),
            array(__('标签云'), 'tag_cloud.php'),
            array(__('用户中心'), 'user.php'),
            array(__('批发'), 'wholesale.php'),
            array(__('优惠活动'), 'activity.php'),
            array(__('配送方式'), 'myship.php'),
            array(__('留言板'), 'message.php'),
            array(__('报价单'), 'quotation.php'),
        );
    }

    /**
     * 获得分类列表
     * @return multitype:unknown mixed
     */
    private function get_categorynav() {
        RC_Loader::load_app_func('category','goods');
        RC_Loader::load_app_func('article','article');
        $cat_list = cat_list(0, 0, false) ? cat_list(0, 0, false) : array();
        $article_cat_list = article_cat_list(0, 0, false) ? article_cat_list(0, 0, false) : array();

        $catlist = array_merge($cat_list, $article_cat_list);
        if (!empty($catlist)) {
            foreach($catlist as $key => $val) {
                $val['view_name'] = $val['cat_name'];
                for($i=0;$i<$val['level'];$i++) {
                    $val['view_name'] = '&nbsp;&nbsp;&nbsp;&nbsp;' . $val['view_name'];
                }
                $val['url'] = str_replace( '&amp;', '&', $val['url']);
                $val['url'] = str_replace( '&', '&amp;', $val['url']);
                $sysmain[] = array($val['cat_name'], $val['url'], $val['view_name']);
            }
        }
        return $sysmain;
    }

    /**
     * 列表项修改
     * @param number $id
     * @param array $args
     * @return boolean
     */
    private function nav_update($id, $args) {
        $db = RC_Loader::load_model('nav_model');
        if (empty($args) || empty($id)) {
            return false;
        }
        return  $db->where('id = '.$id.'')->update($args);
    }

    /**
     * 根据URI对导航栏项目进行分析，确定其为商品分类还是文章分类
     * @param string $uri
     * @return multitype:string Ambigous <> |multitype:string multitype: |boolean
     */
    function analyse_uri($uri) {
        $uri = strtolower(str_replace('&amp;', '&', $uri));
        $arr = explode('-', $uri);
        switch ($arr[0]) {
        	case 'category' :
        	    return array('type' => 'c', 'id' => $arr[1]);
        	    break;
        	case 'article_cat' :
        	    return array('type' => 'a', 'id' => $arr[1]);
        	    break;
        	default:
        	    break;
        }

        list($fn, $pm) = explode('?', $uri);

        if (strpos($uri, '&') === false) {
            $arr = array($pm);
        } else {
            $arr = explode('&', $pm);
        }
        switch ($fn) {
        	case 'category.php' :
        	    //商品分类
        	    foreach ($arr as $k => $v) {
        	        list($key, $val) = explode('=', $v);
        	        if ($key == 'id') {
        	            return array('type' => 'c', 'id' => $val);
        	        }
        	    }
        	    break;
        	case 'article_cat.php'  :
        	    //文章分类
        	    foreach($arr as $k => $v) {
        	        list($key, $val) = explode('=', $v);
        	        if ($key == 'id') {
        	            return array('type' => 'a', 'id'=> $val);
        	        }
        	    }
        	    break;
        	default:
        	    //未知
        	    return false;
        	    break;
        }

    }

    /**
     * 是否显示
     * @param string $type
     * @param number $id
     */
    private function is_show_in_nav($type, $id) {
        if ($type == 'c') {
            $db = RC_Loader::load_app_model('category_model','goods');
        } else {
            $db = RC_Loader::load_app_model('article_cat_model','article');
        }

        return  $db->field('show_in_nav')->find('cat_id = '.$id.'');
    }

    /**
     * 设置是否显示
     * @param string $type
     * @param int $id
     * @param string $val
     */
    function set_show_in_nav($type, $id, $val) {
        if ($type == 'c') {
            $db = RC_Loader::load_app_model('category_model','goods');
        } else {
            $db = RC_Loader::load_app_model('article_cat_model','article');
        }
        $db->where('cat_id = '.$id.'')->update(array('show_in_nav' => $val));
    }
}

// end
