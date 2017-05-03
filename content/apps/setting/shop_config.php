<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心商店设置
 */
class shop_config extends ecjia_admin {
	private $db;
	public function __construct() {
		parent::__construct();
		
		RC_Package::package('app::setting')->loadClass('ecjia_admin_setting', false);
		
		$this->db = RC_Loader::load_model('shop_config_model');
		
		RC_Script::enqueue_script('admin_shop_config', RC_App::apps_url('statics/js/admin_shop_config.js', __FILE__), array(), false, true);
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/bootstrap-toggle-buttons.css', array('ecjia'));
		RC_Script::enqueue_script('jquery-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/jquery.toggle.buttons.js', array('ecjia-admin'), false, true);
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('smoke');
		
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商店设置'), RC_Uri::url('setting/shop_config/init')));
	}
	
	/**
	 * 商店设置页面加载
	 */
	public function init() {
		$this->admin_priv('shop_config');

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商店设置')));
		$this->assign('ur_here', __('商店设置'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
			'id'        => 'overview',
			'title'     => __('概述'),
			'content'   =>
			'<p>' . __('欢迎访问ECJia智能后台商店设置页面，在此页面可对商店有关信息进行配置，同时可根据右侧栏漂浮的快捷导航，快速的进入相应区域。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . __('更多信息：') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E5.95.86.E5.BA.97.E8.AE.BE.E7.BD.AE" target="_blank">关于商店设置帮助文档</a>') . '</p>'
		);
		
		$code = trim($_GET['code']);
		
		switch ($code) {
			case 'basic':

				if (strpos(strtolower($_SERVER['SERVER_SOFTWARE']), 'iis') !== false) {
			        $shop_config_jslang = array(
			            'rewrite_confirm' => __("URL Rewrite 功能要求您的 Web Server 必须安装IIS，并且起用了 ISAPI Rewrite 模块。如果您使用的是ISAPI Rewrite商业版，请您确认是否已经将httpd.txt文件重命名为httpd.ini。如果您使用的是ISAPI Rewrite免费版，请您确认是否已经将httpd.txt文件内的内容复制到ISAPI Rewrite安装目录中httpd.ini里。"),
			        );
			    } else {
			        $shop_config_jslang = array(
			            'rewrite_confirm' => __("URL Rewrite 功能要求您的 Web Server 必须是 Apache，并且起用了 rewrite 模块。同时请您确认是否已经将htaccess.txt文件重命名为.htaccess。如果服务器上还有其他的重写规则请去掉注释,请将RewriteBase行的注释去掉,并将路径设置为服务器请求的绝对路径"),
			        );
			    }
			    
			    $shop_config_jslang['enable_gzip_confirm'] = __('GZip 功能需要您的服务器支持 zlib 扩展库。如果您发现开启Gzip后页面出现乱码，可能是您的服务器已经开启了Gzip，您不需要在 ECJia 中再次开启。');
			    $shop_config_jslang['retain_original_img_confirm'] = __("如果您不保留商品原图，在“图片批量处理”的时候，\n将不会重新生成不包含原图的商品图片。请慎重使用该功能！");
			    $shop_config_jslang['smtp_ssl_confirm'] = __('此功能要求您的php必须支持OpenSSL模块, 如果您要使用此功能，请联系您的空间商确认支持此模块');
			    RC_Script::localize_script('admin_shop_config', 'shop_config_lang', $shop_config_jslang );
			    
			    break;
			    
			default:
			    break;
		}
		$this->assign('cfg_range_lang', RC_Lang::get('setting::shop_config.cfg_range'));
		
		$item_list = ecjia_admin_setting::singleton()->load_items($code);

		$this->assign('item_list', $item_list);
		$this->assign('current_code', $code);
		$this->assign('group', array('code' => $code, 'name' => ecjia_admin_setting::singleton()->cfg_name_langs($code)));
		
		$this->assign('form_action', RC_Uri::url('setting/shop_config/update'));
		
		$this->display('setting.dwt');
	}

	/**
	 * 商店设置表单提交处理
	 */
	public function update() {
		$this->admin_priv('shop_config', ecjia::MSGTYPE_JSON);

		$arr  = array();
		$data = $this->db->field('id, value')->select();
		foreach ($data as $row) {
			$arr[$row['id']] = $row['value'];
		}
	  	foreach ($_POST['value'] AS $key => $val) {
			if($arr[$key] != $val){
				$data = array(
					'value' => trim($val),
				);
				$this->db->where(array('id' => $key))->update($data);
			}
		}
		
		/* 处理上传文件 */
		$file_var_list = array();
		$data = $this->db->where(array('parent_id' => array('gt' => '0'), 'type' => 'file'))->select();
		foreach ($data as $row) {
			$file_var_list[$row['code']] = $row;
		}
		foreach ($_FILES AS $code => $file) {
			/* 判断用户是否选择了文件 */
			if ((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none')) {				
				if ($file_var_list[$code]['value']) {
				    ecjia_admin_setting::singleton()->replace_file($code, $file_var_list[$code]['value']);
				}
				
				/*文件名命名*/
				$save_name = $code == 'icp_file' ? substr($file['name'],0, strrpos($file['name'], '.')) : $code;
				/*判断上传类型*/
				$extname  = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
				$filetype = $code == 'icp_file' ? (strrpos(RC_Config::load_config('filesystems', 'UPLOAD_FILE_EXT'), $extname) ? 'file' : 'image') :'image';
					
				$upload = RC_Upload::uploader($filetype, array('save_path' => 'data/assets/'.ecjia::config('template'), 'replace'=> ecjia_admin_setting::singleton()->is_replace_file($code), 'auto_sub_dirs' => false));
				$upload->add_filename_callback(function () use ($save_name){ return $save_name;});
				
				$image_info = $upload->upload($file);
				/* 判断是否上传成功 */
				if (!empty($image_info)) {
					$file_name = $upload->get_position($image_info);
					$data =  array(
						'value'  => $file_name
					);
					$this->db->where(array('code'=>$code))->update($data);
				} else {
					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
				}
			}
		}
		
		if (isset($_POST['invoice_rate']) && RC_Hook::has_action('update_config_invoice_type')) {
		    RC_Hook::do_action('update_config_invoice_type', $_POST['invoice_type'], $_POST['invoice_rate']);
		}
		
		/* 记录日志 */
		ecjia_admin::admin_log('', 'edit', 'shop_config');
		
		/* 清除缓存 */
		ecjia_config::instance()->clear_cache();
		ecjia_cloud::instance()->api('product/analysis/record')->data(ecjia_utility::get_site_info())->run();
		
		$type = !empty($_POST['type']) ? $_POST['type'] : '';
		
		if ($type == 'mail_setting') {
			$message_info = __('邮件服务器设置成功。');
            /* 记录日志 */
            ecjia_admin_log::instance()->add_object('maill', '邮件服务器');
            ecjia_admin::admin_log(__('修改邮件服务器设置'), 'edit', 'mail');
		} else {
			$message_info = __('保存商店设置成功。');
            ecjia_admin::admin_log(__('修改商店设置'), 'edit', 'shop_config');
		}
		return $this->showmessage($message_info, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('setting/shop_config/init', array('code' => $_POST['code']))));
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('shop_config', ecjia::MSGTYPE_JSON);
		
		$code         = trim($_GET['code']);
		$current_code = trim($_GET['current_code']);
		$img_name     = $this->db->where(array('code'=>$code))->get_field('value');

		$disk         = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $img_name);

		ecjia_config::instance()->write_config($code, '');
		ecjia_admin::admin_log('', 'edit', 'shop_config');

		return $this->showmessage(__('保存商店设置成功。'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

}

// end