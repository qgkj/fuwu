<?php 
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 载入Library Item项目
 * @param string $source
 * @param object $smarty
 * @return mixed
 */
function smarty_prefilter_library_item($source, $smarty) {
	$current_file = str_replace('.php', '', $smarty->_current_file);
	$file_type = strtolower(strrchr($current_file, '.'));
	
	$tmp_dir   = RC_Theme::get_template_directory_uri().'/'; // 前台模板所在路径
	if (defined('IN_ADMIN')) {
		$tmp_dir   = RC_Uri::admin_url('statics/'); // 后台模板所在路径
	}
	
	/**
	 * 处理模板文件
	 */
	if ($file_type == '.dwt') {
		/* 将模板中所有library替换为链接 */
		$pattern  = '/<!--\s#BeginLibraryItem\s\"\/(.*?)\"\s-->.*?<!--\s#EndLibraryItem\s-->/s';
		$source   = preg_replace_callback($pattern, function($matches) {
		    return '{include file="'.strtolower($matches[1]).'.php"}';
		}, $source);
		
		if (!defined('IN_ADMIN') || !defined('IN_MERCHANT')) {
			/* 检查有无动态库文件，如果有为其赋值 */
			$dyna_libs = ecjia_theme::instance()->get_dyna_libs($smarty->_current_file);
			if ($dyna_libs) {
				foreach ($dyna_libs AS $region => $libs) {
					$pattern = '/<!--\\s*TemplateBeginEditable\\sname="'. $region .'"\\s*-->(.*?)<!--\\s*TemplateEndEditable\\s*-->/s';
		
					if (preg_match($pattern, $source, $reg_match)) {
						$reg_content = $reg_match[1];
						/* 生成匹配字串 */
						$keys = array_keys($libs);
						$lib_pattern = '';
						foreach ($keys AS $lib) {
							$lib_pattern .= '|' . str_replace('/', '\/', substr($lib, 1));
						}
						$lib_pattern = '/{include\sfile=\"(' . substr($lib_pattern, 1) . ').php\"}/';
						/* 修改$reg_content中的内容 */
						$GLOBALS['libs'] = $libs;
						$reg_content = preg_replace_callback($lib_pattern, 'dyna_libs_replace', $reg_content);
		
						/* 用修改过的内容替换原来当前区域中内容 */
						$source = preg_replace($pattern, $reg_content, $source);
					}
				}
			}
		}
		
		/* 在头部加入版本信息 */
		$source = preg_replace('/<head>/i', "<head>\r\n<meta name=\"Generator\" content=\"" . APPNAME .' ' . VERSION . "\" />",  $source);
	
		/* 修正css路径 */
		$source = preg_replace('/(<link\shref=["|\'])(?:\.\/|\.\.\/)?(css\/)?([a-z0-9A-Z_]+\.css["|\']\srel=["|\']stylesheet["|\']\stype=["|\']text\/css["|\'])/i', '\1' . $tmp_dir . '\2\3', $source);
	
		/* 修正js目录下js的路径 */
		$source = preg_replace('/(<script\s(?:type|language)=["|\']text\/javascript["|\']\ssrc=["|\'])(?:\.\/|\.\.\/)?(js\/[a-z0-9A-Z_\-\.]+\.(?:js|vbs)["|\']><\/script>)/', '\1' . $tmp_dir . '\2', $source);
	
		/* 更换编译模板的编码类型 */
		$source = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\'][^>]*?>\r?\n?/i', '<meta http-equiv="Content-Type" content="text/html; charset=' . RC_CHARSET . '" />' . "\n", $source);
	}
	
	/**
	 * 处理库文件
	 */
	elseif ($file_type == '.lbi') {
		/* 去除meta */
		$source = preg_replace('/<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\']>\r?\n?/i', '', $source);
	}
	
	/* 去除模板文件被直接访问时的常量定义判断 */
	$source = preg_replace('/<\?php\sdefined\(["|\']IN_ECJIA["|\']\)\sor\sexit\(["|\']\s?(?:.*?)\s?["|\']\);*?\?>\r?\n?/i', '', $source);
	$source = preg_replace('/<\?php(.|\n)*?\?>\r?\n?/is', '', $source);
	
	/* 替换文件编码头部 */
	if (strpos($source, "\xEF\xBB\xBF") !== false) {
		$source = str_replace("\xEF\xBB\xBF", '', $source);
	}
	
	$pattern = array(
			'/<!--[^>|\n]*?({.+?})[^<|{|\n]*?-->/', // 替换smarty注释
			'/<!--[^<|>|{|\n]*?-->/',               // 替换不换行的html注释
			'/(href=["|\'])\.\.\/(.*?)(["|\'])/i',  // 替换相对链接
			'/((?:background|src)\s*=\s*["|\'])(?:\.\/|\.\.\/)?(images\/.*?["|\'])/is', // 在images前加上 $tmp_dir
			'/((?:background|background-image):\s*?url\()(?:\.\/|\.\.\/)?(images\/)/is', // 在images前加上 $tmp_dir
			'/([\'|"])\.\.\//is', // 以../开头的路径全部修正为空
	);
	$replace = array(
			'\1',
		    '',
			'\1\2\3',
			'\1' . $tmp_dir . '\2',
			'\1' . $tmp_dir . '\2',
			'\1'
	);
	$source = preg_replace($pattern, $replace, $source);
	
	return $source;
}


/**
 * 替换动态模块
 *
 * @access  public
 * @param   string       $matches    匹配内容
 *
 * @return string        结果
 */
function dyna_libs_replace($matches) {
    $key = '/' . $matches[1];
    $row = array_shift($GLOBALS['libs'][$key]);
    if ($row) {
        $str = '';
        switch($row['type']) {
        	case 1:
        	    // 分类的商品
        	    $str = '{assign var="cat_goods" value=$cat_goods_' .$row['id']. '}
        	           {assign var="goods_cat" value=$goods_cat_' .$row['id']. '}';
        	    break;
        	case 2:
        	    // 品牌的商品
        	    $str = '{assign var="brand_goods" value=$brand_goods_' .$row['id']. '}
        	           {assign var="goods_brand" value=$goods_brand_' .$row['id']. '}';
        	    break;
        	case 3:
        	    // 文章列表
        	    $str = '{assign var="articles" value=$articles_' .$row['id']. '}
        	           {assign var="articles_cat" value=$articles_cat_' .$row['id']. '}';
        	    break;
        	case 4:
        	    //广告位
        	    $str = '{assign var="ads_id" value=' . $row['id'] . '}
        	           {assign var="ads_num" value=' . $row['number'] . '}';
        	    break;
    	    case 5:
    	    	//问卷调查
        	    $str = '{assign var="vote_form" value=$vote_form_' .$row['id']. '}';
    	    	break;
        }
        return $str . $matches[0];
    } else {
        return $matches[0];
    }
}


// end
