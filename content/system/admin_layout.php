<?php
  
/**
 * ECJIA 管理中心模版管理程序
 */
use Ecjia\System\Theme\ThemeWidget;

defined('IN_ECJIA') or exit('No permission resources.');

class admin_layout extends ecjia_admin {

	/**
	 * 当前主题对象
	 * 
	 * @var \Ecjia\System\Theme\Theme;
	 */
	private $theme;

	/**
	 * 当前模板对象
	 * 
	 * @var \Ecjia\System\Theme\ThemeTemplate;
	 */
	private $template;
	
	/**
	 * 当前模板文件名
	 * 
	 * @var string
	 */
	private $template_file;

	public function __construct() {
		parent::__construct();

		$this->theme = Ecjia_ThemeManager::driver();

		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-uniform');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('外观'), RC_Uri::url('@admin_template/init')));
		
		$this->template_file  = array_get($_GET, 'template_file', array_get($_POST, 'template_file', 'index'));
		$this->template = new \Ecjia\System\Theme\ThemeTemplate($this->theme, $this->template_file.'.dwt.php');
	}

	/**
	 * 设置模板的内容
	 */
	public function init() {
		$this->admin_priv('template_setup');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('布局管理')));
		$this->assign('ur_here', __('布局管理'));

		RC_Script::enqueue_script('ecjia-admin_template_setup');
		RC_Style::enqueue_style('ecjiaui_template_setup', RC_Uri::admin_url() . '/statics/styles/ecjia.ui.widget.css');

		$template_files = $this->theme->getAllowSettingTemplates();

		if (!empty($template_files)) {

		    // 如果默认模板文件index不存在，则取模板文件数组第一个元素
		    if ( ! in_array($this->template_file, array_keys($template_files))) {
		        reset($template_files);
		        $this->template_file = key($template_files);
		        $this->template = new \Ecjia\System\Theme\ThemeTemplate($this->theme, $this->template_file.'.dwt.php');
		    }

			$page_libs = $this->template->getAllowSettingLibraries();

			$editable_regions   = $this->template->getEditableRegions();
            
			$data = $this->template->getDBSettedLibraries();

			/* 获取数据库中数据，并跟模板中数据核对,并设置动态内容 */
			/* 固定内容 */
			$available_widgets   = array();
			if (!empty($page_libs)) {
			    foreach ($page_libs as $lib) {
			        /* 先排除动态内容 */
			        if (!in_array($lib, $this->template->getDynamicLibraries())) {
			            $widget = $this->template->getEditableSettedLibrary($lib);
			            $widget->setAddType(ThemeWidget::ADDTYPESINGLE);

			            $available_widgets[$lib] = $widget;
			        }
			    }
			}
			
			//移除已经设置过的Widget对象
			$db_widgets = $this->template->getWidgetMethod()->readWidgets();
			foreach ($db_widgets as $widget) {
			    $type = $widget->getType();
			    if ($available_widgets[$type]) 
			        unset($available_widgets[$type]);
			}
			
			$available_region_libs = array();
			foreach ($editable_regions as $region) 
			{
			    $region_name = $region['name'];
			    if (isset($data[$region_name])) 
			    {
			        $available_region_libs[$region_name] = $data[$region_name];
			        
			    }
			    else 
			    {
			        foreach ($available_widgets as $key => $widget) 
			        {
			            if ($widget->getRegion() == $region_name) 
			            {
			                $available_region_libs[$region_name][] = $widget;
			            }
			        }
			    }
			}

			$inactive_sidebar = array();
			$inactive_sidebar = array_get($data, 'inactive', array());


// 			_dump($data,1);
// 			$temp_dyna_libs = array();
// 		    if (!empty($data)) {
// 			    foreach ($data as $row) {
// 					if ($row['type'] > 0) {
// 						/* 动态内容 */
// 						$temp_dyna_libs[$row['region']][$row['library']][] = array('id' => $row['id'], 'number' => $row['number'], 'type' => $row['type']);
// 					} else {
// 						/* 固定内容 */
// 						$lib = basename(strtolower(substr($row['library'], 0, strpos($row['library'], '.'))));
// 						if (isset($lib)) {
// 							$temp_options[$lib]['number'] = $row['number'];
// 						}
// 					}
// 				}
// 		    }

// 			$widget_list = ecjia_widget::get_list_widgets();
// 			foreach ($widget_list as $widget) {
// 			    $lib = $widget['callback'][0]->id_base;
// 			    $val = '/library/' . $lib . '.lbi';
// 			    $temp_dyna_libs[$lib]                   = $template->getEditableSettedLibraries($val);
// 			    $temp_dyna_libs[$lib]['name']           = $widget['name'];
// 			    $temp_dyna_libs[$lib]['desc']           = $widget['description'];
// 			    $temp_dyna_libs[$lib]['library']        = $val;
// 			    $temp_dyna_libs[$lib]['type']           = $lib;
// 			    $temp_dyna_libs[$lib]['add_new']        = 'multi';
// 			}
		} 

		
		$this->assign('temp_dyna_libs'            , $temp_dyna_libs);
		
		$this->assign('template_file',            $this->template_file);
		
		$this->assign('available_widgets',        $available_widgets);
		$this->assign('inactive_sidebar',         $inactive_sidebar);
		$this->assign('available_region_libs',    $available_region_libs);
		$this->assign('editable_regions',         $editable_regions);
		$this->assign('template_files',           $template_files);

		$this->assign('form_action', RC_Uri::url('admincp/admin_layout/save_widget'));
		$this->assign('remove_action', RC_Uri::url('admincp/admin_layout/remove_widget'));
		$this->assign('sort_action', RC_Uri::url('admincp/admin_layout/sort_widget'));
		
		$this->display('template_layout.dwt');
	}
	
	
	public function save_widget()
	{
	    $this->admin_priv('template_setup');
	    
        switch ($_POST['widget-type']) {

        	default:
        	    
        	    $widget = $this->template->getWidgetMethod();

        	    //插入或者更新
        	    $id = array_get($_POST, 'widget-id', 0);
        	    
        	    $data = array(
        	        'region'       => $_POST['widget-region'],
        	        'type'         => $_POST['widget-type'],
        	        'library'      => $_POST['widget-library'],
        	        'sort_order'   => $_POST['widget-sort'],
        	        'title'        => $_POST['widget-title'],
        	        'widget_config' => $_POST['widget-config'],
        	    );
        	    	
        	    $widget->insertOrUpdateWidget($id, $data); 
        }
        
        $back_url = RC_Uri::url('@admin_layout/init', 'template_file=' . $this->template_file);
        return $this->showmessage(__('设置小工具内容成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' =>$back_url));
	}
	
	public function remove_widget()
	{
	    $this->admin_priv('template_setup');
	    
	    switch ($_POST['widget-type']) {
	        
	        default:
	            $widget = $this->template->getWidgetMethod();
	            
	            $id = array_get($_POST, 'widget-id', 0);
	            
	            $widget->deleteWidget($id);
	            
	            $back_url = RC_Uri::url('@admin_layout/init', 'template_file=' . $this->template_file);
	            return $this->showmessage(__('移除小工具成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' =>$back_url));
	    }
	}
	
	public function sort_widget()
	{
	    $this->admin_priv('template_setup');
	    
	    $widget = $this->template->getWidgetMethod(); 

	    $sidebars = array_get($_POST, 'sidebars');
	    if ($sidebars) 
	    {
	        foreach ($sidebars as $key => $sidebar)
	        {
	            $sidebar_arr = explode(',', $sidebar);
	            if (!empty($sidebar_arr)) 
	            {
                    $widget->sortWidget($key, $sidebar_arr);
	            }
	        }
	    }
	    
	}


	/**
	 * 提交模板内容设置
	 */
	public function setting() {
		$this->admin_priv('template_setup');

		$curr_template = RC_Hook::apply_filters('ecjia_theme_template', ecjia::config($this->template_code));

		$this->db_template->where(array('remarks' => '', 'filename' => $_POST['template_file'], 'theme' => $curr_template))->delete();

		/* 先处理固定内容 */
		foreach ($_POST['regions'] AS $key => $val) {
			$number = isset($_POST['number'][$key]) ? intval($_POST['number'][$key]) : 0;
			if ((isset($_POST['display'][$key]) AND $_POST['display'][$key] == 1 OR $number > 0)) {
				$data = array(
						'theme'       => $curr_template,
						'filename'    => $_POST[template_file],
						'region'      => $val,
						'library'     => $_POST['map'][$key],
						'sort_order'  => $_POST['sort_order'][$key],
						'number'      => $number,
				);
				$this->db_template->insert($data);
			}
		}

		/* 分类的商品 */
		if (isset($_POST['regions']['cat_goods'])) {
			foreach ($_POST['regions']['cat_goods'] AS $key => $val) {
				if ($_POST['categories']['cat_goods'][$key] != '' && intval($_POST['categories']['cat_goods'][$key]) > 0) {
					$data = array(
							'theme'      => $curr_template,
							'filename'   => $_POST[template_file],
							'region'     => $val,
							'library'    => '/library/cat_goods.lbi',
							'sort_order' => $_POST['sort_order']['cat_goods'][$key],
							'type'       => 1,
							'id'         => $_POST['categories']['cat_goods'][$key],
							'number'     => $_POST['number']['cat_goods'][$key],
					);
					$this->db_template->insert($data);
				}
			}
		}

		/* 品牌的商品 */
		if (isset($_POST['regions']['brand_goods'])) {
			foreach ($_POST['regions']['brand_goods'] AS $key => $val) {
				if ($_POST['brands']['brand_goods'][$key] != '' && intval($_POST['brands']['brand_goods'][$key]) > 0) {
					$data = array(
							'theme'      => $curr_template,
							'filename'   => $_POST[template_file],
							'region'     => $val,
							'library'    => '/library/brand_goods.lbi',
							'sort_order' => $_POST['sort_order']['brand_goods'][$key],
							'type'       => 2,
							'id'         => $_POST['brands']['brand_goods'][$key],
							'number'     => $_POST['number']['brand_goods'][$key],
					);
					$this->db_template->insert($data);
				}
			}
		}

		/* 文章列表 */
		if (isset($_POST['regions']['cat_articles'])) {
			foreach ($_POST['regions']['cat_articles'] AS $key => $val) {
				if ($_POST['article_cat']['cat_articles'][$key] != '' && intval($_POST['article_cat']['cat_articles'][$key]) > 0) {
					$data = array(
							'theme'      => $curr_template,
							'filename'   => $_POST[template_file],
							'region'     => $val,
							'library'    => '/library/cat_articles.lbi',
							'sort_order' => $_POST['sort_order']['cat_articles'][$key],
							'type'       => 3,
							'id'         => $_POST['article_cat']['cat_articles'][$key],
							'number'     => $_POST['number']['cat_articles'][$key],
					);
					$this->db_template->insert($data);
				}
			}
		}

		/* 广告位 */
		if (isset($_POST['regions']['ad_position'])) {
			foreach ($_POST['regions']['ad_position'] AS $key => $val) {
				if ($_POST['ad_position'][$key] != '' && intval($_POST['ad_position'][$key]) > 0) {
					$data = array(
							'theme'      => $curr_template,
							'filename'   => $_POST[template_file],
							'region'     => $val,
							'library'    => '/library/ad_position.lbi',
							'sort_order' => $_POST['sort_order']['ad_position'][$key],
							'type'       => 4,
							'id'         => $_POST['ad_position'][$key],
							'number'     => $_POST['number']['ad_position'][$key],
					);
					$this->db_template->insert($data);
				}
			}
		}

		/* 对提交内容进行处理 */
		$post_regions = array();
		foreach ($_POST['regions'] AS $key => $val) {
			switch ($key) {
				case 'cat_goods':
					if(!empty($val)){
						foreach ($val AS $k => $v) {
							if (intval($_POST['categories']['cat_goods'][$k]) > 0) {
								$post_regions[] = array('region'     => $v,
										'type'       => 1,
										'number'     => $_POST['number']['cat_goods'][$k],
										'library'    => '/library/' .$key. '.lbi',
										'sort_order' => $_POST['sort_order']['cat_goods'][$k],
										'id'         => $_POST['categories']['cat_goods'][$k]
								);
							}
						}
					}
					break;
				case 'brand_goods':
					foreach ($val AS $k => $v) {
						if (intval($_POST['brands']['brand_goods'][$k]) > 0) {
							$post_regions[] = array('region'     => $v,
									'type'       => 2,
									'number'     => $_POST['number']['brand_goods'][$k],
									'library'    => '/library/' .$key. '.lbi',
									'sort_order' => $_POST['sort_order']['brand_goods'][$k],
									'id'         => $_POST['brands']['brand_goods'][$k]
							);
						}
					}
					break;
				case 'cat_articles':
					foreach ($val AS $k => $v) {
						if (intval($_POST['article_cat']['cat_articles'][$k]) > 0) {
							$post_regions[] = array('region'     => $v,
									'type'       => 3,
									'number'     => $_POST['number']['cat_articles'][$k],
									'library'    => '/library/' .$key. '.lbi',
									'sort_order' => $_POST['sort_order']['cat_articles'][$k],
									'id'         => $_POST['article_cat']['cat_articles'][$k]
							);
						}
					}
					break;
				case 'ad_position':
					foreach ($val AS $k => $v) {
						if (intval($_POST['ad_position'][$k]) > 0) {
							$post_regions[] = array('region'     => $v,
									'type'       => 4,
									'number'     => $_POST['number']['ad_position'][$k],
									'library'    => '/library/' .$key. '.lbi',
									'sort_order' => $_POST['sort_order']['ad_position'][$k],
									'id'         => $_POST['ad_position'][$k]
							);
						}
					}
					break;
				default:
					if (!empty($_POST['display'][$key])) {
						$post_regions[] = array('region'     => $val,
								'type'       => 0,
								'number'     => 0,
								'library'    => $_POST['map'][$key],
								'sort_order' => $_POST['sort_order'][$key],
								'id'         => 0
						);
					}

			}
		}

		/* 排序 */
		usort($post_regions, array('ecjia_sort', 'array_sort'));

		/* 修改模板文件 */
		$template_file    = SITE_PATH . 'themes/' . $curr_template . '/' . $_POST['template_file'] . '.dwt';
		$template_content = file_get_contents($template_file);
		$template_content = str_replace("\xEF\xBB\xBF", '', $template_content);
		$org_regions      = $this->theme->get_template_region($curr_template, $_POST['template_file'].'.dwt', false);

		$region_content   = '';
		$pattern          = '/(<!--\\s*TemplateBeginEditable\\sname="%s"\\s*-->)(.*?)(<!--\\s*TemplateEndEditable\\s*-->)/s';
		$replacement      = "\\1\n%s\\3";
		$lib_template     = "<!-- #BeginLibraryItem \"%s\" -->\n%s\n <!-- #EndLibraryItem -->\n";

		foreach ($org_regions AS $region) {
			$region_content = ''; // 获取当前区域内容
			foreach ($post_regions AS $lib) {
				if ($lib['region'] == $region) {
					if (!file_exists(SITE_PATH . 'themes/' . $curr_template . $lib['library'])) {
						continue;
					}
					$lib_content     = file_get_contents(SITE_PATH . 'themes/' . $curr_template . $lib['library']);
					$lib_content     = preg_replace('/<meta\\shttp-equiv=["|\']Content-Type["|\']\\scontent=["|\']text\/html;\\scharset=.*["|\']>/i', '', $lib_content);
					$lib_content     = str_replace("\xEF\xBB\xBF", '', $lib_content);
					$region_content .= sprintf($lib_template, $lib['library'], $lib_content);
				}
			}

			/* 替换原来区域内容 */
			$template_content = preg_replace(sprintf($pattern, $region), sprintf($replacement , $region_content), $template_content);
		}

		if (file_put_contents($template_file, $template_content)) {
			$lnk[] = array('text' => __('返回上一页'), 'href'=>RC_Uri::url('@system_template/setup', 'template_file='.$_POST['template_file']));
			return $this->showmessage(__('设置模板内容成功。'), 0, $lnk);
		} else {
			return $this->showmessage(sprintf(__('模板文件 %s 无法修改'), 'themes/' . $curr_template. '/' . $_POST['template_file'] . '.dwt'), 1, null, false);
		}
	}

}

// end
