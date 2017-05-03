<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_theme {

	public $curr_theme;
    public $theme_styles = array();

	private $theme_dir;
	private $library_dir;

	private $theme_root_url;
	private $theme_curr_url;

	private static $library_bak_dir;

	private static $instance = null;

	/**
	 * 返回当前终级类对象的实例
	 *
	 * @param $cache_config 缓存配置
	 * @return object
	 */
	public static function instance() {
	    if (self::$instance === null) {
	        self::$instance = new ecjia_theme();
	    }
	    return self::$instance;
	}

	/**
	 * 动态库项目
	 * @var array
	 */
	public $dyna_libs = array(
        'cat_goods',
        'brand_goods',
        'cat_articles',
        'ad_position',
    );

	public function __construct($theme_name = '') {
		$this->curr_theme 		= $theme_name ? $theme_name : (ecjia::config('template') ? ecjia::config('template') : RC_Config::get('system.tpl_style'));
		$this->theme_dir 		= SITE_THEME_PATH . $this->curr_theme . DIRECTORY_SEPARATOR;
		$this->library_dir  	= $this->theme_dir . 'library' . DIRECTORY_SEPARATOR;
		$this->theme_root_url 	= RC_Theme::get_theme_root_uri() .'/';
		$this->theme_curr_url 	= RC_Theme::get_theme_root_uri()  .'/'. $this->curr_theme . '/';
        $this->theme_styles 	= $this->read_theme_style(2);


		self::$library_bak_dir 	= SITE_CACHE_PATH . 'backup' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;

		if(!is_dir(self::$library_bak_dir))mkdir(self::$library_bak_dir, 0777, true);
	}


	/**
	 * 可以设置内容的模板
	 * @return array
	 */
	public function get_template_files() {
	    $arr_template = array();

	    $template_handle = opendir($this->theme_dir);
	    if($template_handle){
		    while (false != ($file = readdir($template_handle))) {
		        if (substr($file, -7) == 'dwt.php') {
		        	$filename = substr($file, 0, -8);
		        	$template_data = $this->get_template_info($this->theme_dir . $file);

		        	if (!empty($template_data['Libraries'])) {
		        	    $arr_template[$filename]['File'] = $file;
		        	    $arr_template[$filename]['Name'] = $template_data['Name'];
		        	    $arr_template[$filename]['Description'] = $template_data['Description'];
		        	}

		        }
		    }
	    }
	    closedir($template_handle);

	    return $arr_template;
	}

	/**
	 * 每个模板允许设置的库项目
	 */
	public function get_page_libs($filename) {
	    $filename .= '.dwt.php';
	    $template_data = $this->get_template_info($this->theme_dir . $filename);
	    $page_libs = array();
	    if (!empty($template_data['Libraries'])) {
	        $page_libs = explode(',', $template_data['Libraries']);
	    }
	    return $page_libs;
	}

	/**
	 * 读取库项目列表
	 */
	public function get_libraries() {
		$arr_library   = array();

		$library_handle = is_dir($this->library_dir) ? opendir($this->library_dir) : 0;
		if($library_handle){
			while (false !== ($file = readdir($library_handle))) {
				if (substr($file, -7) == 'lbi.php') {
					$filename      			= substr($file, 0, -8);
					$library_data = $this->get_library_info($this->library_dir . $file);
	                $arr_library[$filename]['File'] = $file;
	                $arr_library[$filename]['Name'] = $library_data['Name'];
	                $arr_library[$filename]['Description'] = $library_data['Description'];
				}
			}
    		closedir($library_handle);
		}

		return $arr_library;
	}


	public function get_library_info($file) {
	    $default_headers = array(
	        'Name' => 'Name',
	        'Description' => 'Description',
	    );

	    $library_data = RC_File::get_file_data( $file, $default_headers, 'library' );

	    return $library_data;
	}


	public function get_template_info($file) {
	    $default_headers = array(
	        'Name' => 'Name',
	        'Description' => 'Description',
	        'Libraries' => 'Libraries',
	    );

	    $template_data = RC_File::get_file_data( $file, $default_headers, 'template' );

	    return $template_data;
	}


	/**
	 * 获得模版文件中的编辑区域及其内容
	 *
	 * @access  public
	 * @param   string  $tmp_name   模版名称
	 * @param   string  $tmp_file   模版文件名称
	 * @return  array
	 */
	function get_template_region($tmp_file, $lib = true) {
	    $file = $this->theme_dir . $tmp_file ;
	    //. 'themes/'
	    if (!file_exists($file))
	        $file .= '.php';
	    /* 将模版文件的内容读入内存 */
	    $content = file_get_contents($file);

	    /* 获得所有编辑区域 */
	    static $regions = array();

	    if (empty($regions)) {
	        $matches = array();
	        $result  = preg_match_all('/(<!--\\s*TemplateBeginEditable\\sname=")([^"]+)("\\s*-->)/', $content, $matches, PREG_SET_ORDER);

	        if ($result && $result > 0) {
	            foreach ($matches AS $key => $val) {
	                if ($val[2] != 'doctitle' && $val[2] != 'head') {
	                    $regions[] = $val[2];
	                }
	            }
	        }

	    }

	    if (!$lib) {
	        return $regions;
	    }

	    $libs = array();
	    /* 遍历所有编辑区 */
	    foreach ($regions AS $key => $val) {
	        $matches = array();
	        $pattern = '/(<!--\\s*TemplateBeginEditable\\sname="%s"\\s*-->)(.*?)(<!--\\s*TemplateEndEditable\\s*-->)/s';

	        if (preg_match(sprintf($pattern, $val), $content, $matches)) {
	            /* 找出该编辑区域内所有库项目 */
	            $lib_matches = array();

	            $result      = preg_match_all('/([\s|\S]{0,20})(<!--\\s#BeginLibraryItem\\s")([^"]+)("\\s-->)/', $matches[2], $lib_matches, PREG_SET_ORDER);
	            $i = 0;
	            if ($result && $result > 0) {
	                foreach ($lib_matches AS $k => $v) {
	                    $v[3]   = strtolower($v[3]);
	                    $libs[] = array('library' => $v[3], 'region' => $val, 'lib'=>basename(substr($v[3], 0, strpos($v[3], '.'))), 'sort_order' => $i);
	                    $i++;
	                }

	            }
	        }
	    }

	    return $libs;
	}

	/**
	 * 从相应模板xml文件中获得指定模板文件中的可编辑区信息
	 *
	 * @access  public
	 * @param   string  $curr_template    当前模板文件名
	 * @param   array   $curr_page_libs   缺少xml文件时的默认编辑区信息数组
	 * @return  array   $edit_libs        返回可编辑的库文件数组
	 */
	function get_editable_libs($curr_template, $curr_page_libs) {
	    $edit_libs = array();
	    $temp_libs = $this->get_template_region($curr_template . '.dwt.php', true);

	    foreach ($temp_libs as $lib) {
	        $edit_libs[] = $lib['lib'];
	    }

	    return $edit_libs;
	}


	/**
	 * 获得指定库项目在模板中的设置内容
	 *
	 * @access  public
	 * @param   string  $lib    库项目
	 * @param   array   $libs    包含设定内容的数组
	 * @return  void
	 */
	public function get_setted($lib, &$arr) {
	    $options = array('region' => '', 'sort_order' => 0, 'display' => 0);

	    foreach ($arr AS $key => $val) {
	        if ($lib == $val['library']) {
	            $options['region']     = $val['region'];
	            $options['sort_order'] = $val['sort_order'];
	            $options['display']    = 1;

	            break;
	        }
	    }

	    return $options;
	}


	/**
	 * 载入库项目内容
	 *
	 * @access  public
	 * @param   string  $curr_template  模版名称
	 * @param   string  $lib_name       库项目名称
	 * @return  array
	 */
	public function load_library($lib_name) {
		$lib_name = str_replace("0xa", '', $lib_name); // 过滤 0xa 非法字符

		$lib_file    = $this->library_dir . $lib_name . '.lbi.php';

        RC_Script::enqueue_script('jquery-form');
		RC_Loader::load_sys_func('upload');

		$arr['mark'] = RC_File::file_mode_info($lib_file);
		$arr['html'] = is_file($lib_file) ? str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file)) : '';

		return $arr;
	}


	/**
	 * 更新库项目内容
	 */
	public function update_library($lib_name, $content) {
		$lib_file = $this->library_dir . $lib_name . '.lbi.php';
		$lib_file = str_replace("0xa", '', $lib_file); // 过滤 0xa 非法字符
		$lib_file = str_replace("\\", '/', $lib_file); //windows兼容处理
        if (!royalcms('files')->isWritable($lib_file)) {
            return false;
        }

		$org_html = str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_file));

		if (file_exists($lib_file) === true && file_put_contents($lib_file, $content)) {
			file_put_contents(self::$library_bak_dir . ecjia::config('template') . '-' . $lib_name . '.lbi.php', $org_html);
			return true;
		} else {
			return false;
		}
	}


	/**
	 * 还原库项目
	 */
	public function restore_library($lib_name) {
		$lib_file   = $this->library_dir . $lib_name . '.lbi.php';
		$lib_file   = str_replace("0xa", '', $lib_file); // 过滤 0xa 非法字符
		$lib_file   = str_replace("\\", '/', $lib_file); //windows兼容处理
		$lib_backup = self::$library_bak_dir . $this->curr_theme . '-' . $lib_name . '.lbi.php';
		$lib_backup = str_replace("0xa", '', $lib_backup); // 过滤 0xa 非法字符
		$lib_backup = str_replace("\\", '/', $lib_backup); //windows兼容处理

		if (file_exists($lib_backup) && filemtime($lib_backup) >= filemtime($lib_file)) {
			return str_replace("\xEF\xBB\xBF", '',file_get_contents($lib_backup));
		} else {
			return str_replace("\xEF\xBB\xBF", '',file_get_contents($lib_file));
		}
	}


	/**
	 * 获得模版的信息
	 *
	 * @access  private
	 * @param   string      $template_style     模版风格名
	 * @return  array
	 */
	public function get_theme_info($template_style = '') {

		$info = array();
		$ext  = array('png', 'gif', 'jpg', 'jpeg');

		$info['code']       = $this->curr_theme;
		$info['screenshot'] = '';
		$info['stylename'] 	= $template_style;
		if ($template_style == '') {
			foreach ($ext as $val) {
				if (file_exists($this->theme_dir . 'images/screenshot.' . $val)) {
					$info['screenshot'] = $this->theme_curr_url . 'images/screenshot.' . $val;
					break;
				}
			}
		} else {
			foreach ($ext as $val) {
				if (file_exists($this->theme_dir . 'images/screenshot_' . $template_style . '.' . $val)) {
					$info['screenshot'] = $this->theme_curr_url . 'images/screenshot_' . $template_style . '.' . $val;
					break;
				}
			}
		}
		$css_path = $this->theme_dir . 'style.css';
		if ($template_style != '') {
			$css_path = $this->theme_dir . 'style_' . $template_style . '.css';
		}

		if (file_exists($css_path)) {
			$arr = array_slice(file($css_path), 0, 10);
			$template_name      = explode(': ', $arr[1]);
			$template_uri       = explode(': ', $arr[2]);
			$template_desc      = explode(': ', $arr[3]);
			$template_version   = explode(': ', $arr[4]);
			$template_author    = explode(': ', $arr[5]);
			$author_uri         = explode(': ', $arr[6]);
			$logo_filename      = explode(': ', $arr[7]);
			$template_type      = explode(': ', $arr[8]);
			$template_color      = explode(': ', $arr[9]);


			$info['name']       = isset($template_name[1]) ? trim($template_name[1]) : '';
			$info['uri']        = isset($template_uri[1]) ? trim($template_uri[1]) : '';
			$info['desc']       = isset($template_desc[1]) ? trim($template_desc[1]) : '';
			$info['version']    = isset($template_version[1]) ? trim($template_version[1]) : '';
			$info['author']     = isset($template_author[1]) ? trim($template_author[1]) : '';
			$info['author_uri'] = isset($author_uri[1]) ? trim($author_uri[1]) : '';
			$info['logo']       = isset($logo_filename[1]) ? trim($logo_filename[1]) : '';
			$info['type']       = isset($template_type[1]) ? trim($template_type[1]) : '';
			$info['color']      = isset($template_color[1]) ? trim($template_color[1]) : '';

		} else {
			$info['name']       = '';
			$info['uri']        = '';
			$info['desc']       = '';
			$info['version']    = '';
			$info['author']     = '';
			$info['author_uri'] = '';
			$info['logo']       = '';
            $info['color']      = '';
		}
		return $info;
	}


	/**
	 * 读取模板风格列表
	 *
	 * @access  public
	 * @param   int     $flag           1.AJAX数据；2.Array
	 * @return
	 */
	function read_theme_style($flag = 1) {
		/* 获得可用的模版 */
		$temp = '';
		$start = 0;
		$available_themes = array('');
		if(file_exists($this->theme_dir)){
			$tpl_style_dir = opendir($this->theme_dir);
			while (false !== ($file = readdir($tpl_style_dir))) {
				if ($file != '.' &&
					$file != '..' &&
					is_file($this->theme_dir . $file) &&
					$file != '.svn' &&
					$file != 'index.htm') {
					// 取模板风格缩略图
					if (preg_match("/^(style|style_)(.*)*/i", $file)) {
						$start = strpos($file, '.');
						$temp = substr($file, 0, $start);
						$temp = explode('_', $temp);
						if (count($temp) == 2) {
							$available_themes[] = $temp[1];
						}
					}
				}
			}
			closedir($tpl_style_dir);

			if ($flag == 1) {
				$ec = '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="colortable" onMouseOver="javascript:onSOver(0, this);" onMouseOut="onSOut(this);" onclick="javascript:setupTemplateFG(0);"  bgcolor="#FFFFFF"><tr><td>&nbsp;</td></tr></table>';
				if (count($available_themes) > 0) {
					foreach ($available_themes as $value) {
						$tpl_info = $this->get_theme_info();

						$ec .= '<table border="0" width="100%" cellpadding="0" cellspacing="0" class="colortable" onMouseOver="javascript:onSOver(\'' . $value . '\', this);" onMouseOut="onSOut(this);" onclick="javascript:setupTemplateFG(\'' . $value . '\');"  bgcolor="' . $tpl_info['type'] . '"><tr><td>&nbsp;</td></tr></table>';

						unset($tpl_info);
					}
				}
				else
				{
					$ec = '0';
				}

				return $ec;
			}
			elseif ($flag == 2) {
				$themes_temp = array();
				if (count($available_themes) > 0) {
					foreach ($available_themes as $key => $value) {
                        $templates_info = $this->get_theme_info($value);
                        $themes_temp[] = $templates_info;
					}
				}

				return $themes_temp;
			}
		}else{
			return false;
		}
	}



	/**
	 * 获取指定主题某个模板的主题的动态模块
	 *
	 * @access  public
	 * @param   string       $theme    模板主题
	 * @param   string       $tmp      模板名称
	 *
	 * @return array()
	 */
	public function get_dyna_libs($tmp) {
        $tmp = rtrim($tmp, '.php');

		$extsub = explode('.', $tmp);
		$ext = end($extsub);
		$tmp = basename($tmp, ".$ext");

		$db_template = RC_Loader::load_model('template_model');
		$res = $db_template	-> field('region, library, sort_order, id, number, type')
							-> where('theme = "'.$this->curr_theme.'" AND filename = "' . $tmp . '" AND type > 0 AND remarks = ""')
							-> order(array('region'=>'asc', 'library'=>'asc', 'sort_order'=>'asc'))
							-> select();

		$dyna_libs = array();
		$res or $res = array();
		foreach ($res AS $row) {
			$dyna_libs[$row['region']][$row['library']][] = array(
					'id'     => $row['id'],
					'number' => $row['number'],
					'type'   => $row['type']
			);
		}

		return $dyna_libs;
	}



	/**
	 * 获得可用的主题
	 */
	public static function available_themes() {
		/* 获得可用的模版 */
		$available_themes = array();
		$theme_dir = opendir(SITE_THEME_PATH);
		if($theme_dir){
			while (false !== ($file = readdir($theme_dir))) {
				if ($file != '.' &&
					$file != '..' &&
					is_dir(SITE_THEME_PATH . $file) &&
					$file != '.svn' &&
					$file != 'index.htm')
				{
					$available_themes[$file] = new ecjia_theme($file);
				}
			}
		}
		closedir($theme_dir);

		return $available_themes;
	}


	/**
	 * 清除不需要的模板设置
	 */
	public static function clear_not_actived() {
		$available_code = array();

		$db_template = RC_Loader::load_model('template_model');

		$available_themes = self::available_themes();
		foreach ($available_themes AS $key => $tmp) {
			$db_template->where('theme != "'. $key .'"')->delete();
			$available_code[] = $key;
		}

		$tmp_bak_dir = opendir(self::$library_bak_dir);
		while (false !== ($file = readdir($tmp_bak_dir))) {
			if ($file != '.' &&
				$file != '..' &&
				$file != '.svn' &&
				$file != 'index.htm' &&
				is_file(self::$library_bak_dir . $file) == true)
			{
				$code = substr($file, 0, strpos($file, '-'));
				if (!in_array($code, $available_code)) {
					unlink(self::$library_bak_dir . $file);
				}
			}
		}
		closedir($tmp_bak_dir);
	}

}

// end
