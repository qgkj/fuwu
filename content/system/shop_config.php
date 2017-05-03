<?php
  
/**
 * ECJIA 管理中心商店设置
 */
defined('IN_ECJIA') or exit('No permission resources.');

class shop_config extends ecjia_admin {
	private $db;
	private $db_region;
	public function __construct() {
		parent::__construct();

		$this->db = RC_Loader::load_model('shop_config_model');
		$this->db_region = RC_Loader::load_model('region_model');

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/bootstrap-toggle-buttons.css', array('ecjia'));
		RC_Script::enqueue_script('jquery-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/jquery.toggle.buttons.js', array('ecjia-admin'), false, true);
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('smoke');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商店设置'), RC_Uri::url('@shop_config/init')));
	}

	
	/**
	 * 列表编辑
	 */
	public function init() { 
		$this->admin_priv('shop_config');

		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('ecjia-admin_shop_config');
		
		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('商店设置')));
		$this->assign('ur_here',		__('商店设置'));
		
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
		
		/* 可选语言 */
		$dir = opendir(SITE_SYSTEM_PATH. 'languages');
		$lang_list = array();
		while (($file = readdir($dir)) != false) {
			if ($file != '.' && $file != '..' &&  $file != '.svn' && $file != '_svn' && is_dir(SITE_SYSTEM_PATH . 'languages/' .$file)) {
				$lang_list[] = $file;
			}
		}
		closedir($dir);
		$this->assign('lang_list',    $lang_list);
		
		if (strpos(strtolower($_SERVER['SERVER_SOFTWARE']), 'iis') !== false) {
			$shop_config_jslang = array(
				'rewrite_confirm' => __("URL Rewrite 功能要求您的 Web Server 必须安装IIS，并且起用了 ISAPI Rewrite 模块。如果您使用的是ISAPI Rewrite商业版，请您确认是否已经将httpd.txt文件重命名为httpd.ini。如果您使用的是ISAPI Rewrite免费版，请您确认是否已经将httpd.txt文件内的内容复制到ISAPI Rewrite安装目录中httpd.ini里。"),
			); 
		} else {
			$shop_config_jslang = array(
				'rewrite_confirm' => __("URL Rewrite 功能要求您的 Web Server 必须是 Apache，并且起用了 rewrite 模块。同时请您确认是否已经将htaccess.txt文件重命名为.htaccess。如果服务器上还有其他的重写规则请去掉注释,请将RewriteBase行的注释去掉,并将路径设置为服务器请求的绝对路径"),
			); 
		}
		RC_Script::localize_script( 'ecjia-shop_config', 'shop_config_lang', $shop_config_jslang );
		
		$this->assign('countries',    $this->db_region->get_regions());
		if (ecjia::config('shop_country') > 0) {
			$this->assign('provinces', $this->db_region->get_regions(1, ecjia::config('shop_country')));
			if (ecjia::config('shop_province')) {
				$this->assign('cities', $this->db_region->get_regions(2, ecjia::config('shop_province')));
			}
		}
		$this->assign('cfg_range_lang', RC_Lang::get('system::shop_config.cfg_range'));
		$this->assign('cfg',			ecjia::config());
		$this->assign('group_list',		$this->get_settings(null, array('5', '8', '9')));
		
		$this->assign('form_action',	RC_Uri::url('@shop_config/update'));
		
		$this->display('shop_config.dwt');
	}
	
	/**
	 * 邮件服务器设置
	 */
	public function mail_settings() {
		$this->admin_priv('shop_config');

		RC_Script::enqueue_script('ecjia-admin_shop_config');
		
		$admin_shop_config_jslang = array(
				'pls_select_smtp'		=> __('请输入发送邮件服务器地址(SMTP)！'),
				'required_port'			=> __('请输入服务器端口！'),
				'required_account'		=> __('请输入邮件帐号！'),
				'check_account'			=> __('请输入正确格式的邮件帐号！'),
				'required_password'		=> __('请输入邮件密码！'),
				'required_reply_account'=> __('请输入回复邮件帐号！'),
				'check_reply_account'	=> __('请输入正确格式的回复邮件帐号！'),
				'required_send_account'	=> __('请输入发送邮件帐号！'),
				'check_send_account'	=> __('请输入正确格式的发送邮件帐号！')
		);
		RC_Script::localize_script('ecjia-admin_shop_config', 'admin_shop_config', $admin_shop_config_jslang );

		$arr = $this->get_settings(array(5));
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件服务器设置')));
		$this->assign('ur_here',      __('邮件服务器设置'));
		
		ecjia_screen::get_current_screen()->add_help_tab( array(
		'id'        => 'overview',
		'title'     => __('概述'),
		'content'   =>
		'<p>' . __('欢迎访问ECJia智能后台邮件服务器设置页面，可通过以下两种方式进行配置。') . '</p>'
		) );
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
		'<p><strong>' . __('更多信息：') . '</strong></p>' .
		'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:系统设置#.E9.82.AE.E4.BB.B6.E6.9C.8D.E5.8A.A1.E5.99.A8.E8.AE.BE.E7.BD.AE" target="_blank">关于邮件服务器设置帮助文档</a>') . '</p>'
		);
		
		$this->assign('ur_heretest',      __('测试邮件'));
		$this->assign('form_action', RC_Uri::url('@shop_config/update'));
		$this->assign('cfg', $arr[5]['vars']);
		
		$this->display('shop_config_mail_settings.dwt');
	}
	
	
	/**
	 * 商店设置表单提交处理
	 */
	public function update() {
		$this->admin_priv('shop_config');

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
				$this->db->where(array('id'=>$key))->update($data);
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
// 				/*是否覆盖文件*/
// 				$replacefile = in_array($code, array('shop_logo','watermark','wap_logo','no_picture')) ? true : false;
				
// 				//删除原有文件
// 				if ($replacefile) {
// 					if (RC_Upload::upload_path().file_exists($file_var_list[$code]['value'])) {
// // 						@unlink(RC_Upload::upload_path().$file_var_list[$code]['value']);
// 						$disk = RC_Filesystem::disk();
// 						$disk->delete(RC_Upload::upload_path() . $file_var_list[$code]['value']);
// 					}
// 				}
				
				if ($file_var_list[$code]['value']) {
				    $this->replace_file($code, $file_var_list[$code]['value']);
				}
				
				/*文件名命名*/
				$save_name = $code == 'icp_file' ? substr($file['name'],0, strrpos($file['name'], '.')) : $code;
				/*判断上传类型*/
				$extname = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
				$filetype = $code == 'icp_file' ? (strrpos(RC_Config::load_config('filesystems', 'UPLOAD_FILE_EXT'),$extname)? 'file' : 'image') :'image';
				
// 				$upload = RC_Upload::uploader($filetype, array('save_path' => 'data/assets/'.ecjia::config('template'),'save_name'=>$save_name,'replace'=>$replacefile,'auto_sub_dirs' => false));		
				$upload = RC_Upload::uploader($filetype, array('save_path' => 'data/assets/'.ecjia::config('template'),'replace'=>$replacefile,'auto_sub_dirs' => false));
				$upload->add_filename_callback(function () use ($save_name){ return $save_name;});
				
				$image_info = $upload->upload($file);
				/* 判断是否上传成功 */
				if (!empty($image_info)) {
// 					$file_name = $image_info['savepath'].'/'.$image_info['savename'];
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
		/* 处理发票类型及税率 */
		if (!empty($_POST['invoice_rate'])) {
			foreach ($_POST['invoice_rate'] as $key => $rate) {
				$rate = round(floatval($rate), 2);
				if ($rate < 0) {
					$rate = 0;
				}
				$_POST['invoice_rate'][$key] = $rate;
			}
			$invoice = array(
					'type' => $_POST['invoice_type'],
					'rate' => $_POST['invoice_rate']
			);
			$data  = array(
					'value' => serialize($invoice)
			);
			$this->db->where(array('code'=>'invoice_type'))->update($data);
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
            ecjia_admin::admin_log(__('修改邮件服务器设置'), 'edit', 'maill');
		} else {
			$message_info = __('保存商店设置成功。');
            ecjia_admin::admin_log(__('修改商店设置'), 'edit', 'shop_config');
		}
		return $this->showmessage($message_info , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('@shop_config/init')));
	}
	
	/**
	 * 发送测试邮件
	 */
	public function send_test_email() {
		$this->admin_priv('shop_config');

		/* 取得参数 */			    
		RC_Hook::remove_action('reset_mail_config', 'ecjia_mail_config');
		RC_Hook::add_action('reset_mail_config', function($config){			
			royalcms('config')->set('mail.host',        trim($_POST['smtp_host']));
			royalcms('config')->set('mail.port',        trim($_POST['smtp_port']));
			royalcms('config')->set('mail.from.address', trim($_POST['reply_email']));
			royalcms('config')->set('mail.from.name',   ecjia::config('shop_name'));
			royalcms('config')->set('mail.username',    trim($_POST['smtp_user']));
			royalcms('config')->set('mail.password',    trim($_POST['smtp_pass']));
			royalcms('config')->set('mail.charset',     trim($_POST['mail_charset']));
			
			if (intval($_POST['smtp_ssl']) === 1) {
			    royalcms('config')->set('mail.encryption', 'ssl');
			} else {
			    royalcms('config')->set('mail.encryption', 'tcp');
			}
			
			if (intval($_POST['mail_service']) === 1) {
			    royalcms('config')->set('mail.driver', 'smtp');
			} else {
			    royalcms('config')->set('mail.driver', 'mail');
			}
		});
		
		$test_mail_address = trim($_POST['test_mail_address']);

		$error = RC_Mail::send_mail('', $test_mail_address, __('测试邮件'), __('您好！这是一封检测邮件服务器设置的测试邮件。收到此邮件，意味着您的邮件服务器设置正确！您可以进行其它邮件发送的操作了！'), 0);
		if ( is_ecjia_error($error) ) {
			return $this->showmessage(sprintf(__('测试邮件发送失败！%s'), $error->get_error_message()) , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage(sprintf(__('恭喜！测试邮件已成功发送到 %s。'), $test_mail_address), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('shop_config');
		
		$code     = trim($_GET['code']);
		$img_name = $this->db->where(array('code'=>$code))->get_field('value');
// 		@unlink(RC_Upload::upload_path() . $img_name);
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $img_name);
		
// 		$this->update_configure($code, '');
		ecjia_config::instance()->write_config($code, '');
		ecjia_admin::admin_log('', 'edit', 'shop_config');

		return $this->showmessage(__('保存商店设置成功。') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('@shop_config/init')));
	}
	
	

/**
 * 获得设置信息
 *
 * @param   array   $groups     需要获得的设置组
 * @param   array   $excludes   不需要获得的设置组
 *
 * @return  array
 */
	private function get_settings($groups=array(), $excludes=array()) {
		$config_groups = '';
		$excludes_groups = '';

		if (!empty($groups)) {
			foreach ($groups AS $key=>$val) {
				$config_groups .= " AND (id='$val' OR parent_id='$val')";
			}
		}

		if (!empty($excludes)) {
			foreach ($excludes AS $key=>$val) {
				$excludes_groups .= " AND (parent_id<>'$val' AND id<>'$val')";
			}
		}

		$item_list = $this->db->where('type <>"hidden"'.$config_groups . $excludes_groups)->order(array('parent_id' => 'asc', 'sort_order' => 'asc', 'id' => 'asc'))->select();
		
		/* 整理数据 */
		$group_list     = array();
		$cfg_name_lang  = RC_Lang::get('system::shop_config.cfg_name');
		$cfg_desc_lang  = RC_Lang::get('system::shop_config.cfg_desc');
		$cfg_range_lang = RC_Lang::get('system::shop_config.cfg_range');

		/* 增加图标数组 */
		$icon_arr = array(
			'shop_info'		=> 'fontello-icon-wrench',
			'basic'			=> 'fontello-icon-info',
			'display'		=> 'fontello-icon-desktop',
			'shopping_flow'	=> 'fontello-icon-truck',
			'goods'			=> 'fontello-icon-gift',
			'sms'			=> 'fontello-icon-chat-empty',
			'wap'			=> 'fontello-icon-tablet'
		);
		
		foreach ($item_list AS $key => $item) {
			$pid          = $item['parent_id'];
			$item['name'] = isset($cfg_name_lang[$item['code']]) ? $cfg_name_lang[$item['code']] : $item['code'];
			$item['desc'] = isset($cfg_desc_lang[$item['code']]) ? $cfg_desc_lang[$item['code']] : '';
			
			if ($item['type']=='file' && !empty($item['value'])) {
				if($item['code']=='icp_file') {
					$item['file_name'] = array_pop(explode('/', $item['value']));
				}
				$item['value'] = RC_Upload::upload_url() .'/'. $item['value'];
			}
			if ($item['code'] == 'sms_shop_mobile') {
				$item['url'] = 1;
			}
			if ($pid == 0) {
				/* 分组 */
				$item['icon'] = isset($icon_arr[$item['code']]) ? $icon_arr[$item['code']] : '';
				if ($item['type'] == 'group') {
					$group_list[$item['id']] = $item;
				}
			} else {
				/* 变量 */
				if (isset($group_list[$pid])) {
					if ($item['store_range']) {
						$item['store_options'] = explode(',', $item['store_range']);

						foreach ($item['store_options'] AS $k => $v) {
							$item['display_options'][$k] = isset($cfg_range_lang[$item['code']][$v]) ?
							$cfg_range_lang[$item['code']][$v] : $v;
						}
					}
					$group_list[$pid]['vars'][] = $item;
				}
			}
		}

		return $group_list;
	}
	
	/**
	 * 删除需要覆盖的文件
	 * 
	 * @param string $code
	 * @param string $value
	 */
	private function replace_file($code, $value) {
	    //定义需要替换的文件
	    $files = array('shop_logo', 'watermark', 'wap_logo', 'no_picture');

	    /*是否覆盖文件*/
	    //删除原有文件
	    if (in_array($code, $files)) {
	        if (file_exists(RC_Upload::upload_path() . $value)) {
	            $disk = RC_Filesystem::disk();
	            $disk->delete(RC_Upload::upload_path() . $value);
	        }
	    }
	}

    /**
     * 设置系统设置
     *
     * @param   string  $key
     * @param   string  $val
     *
     * @return  boolean
     */
	private function update_configure($key, $val='') {

		if (!empty($key)) {
			$data = array(
				'value' => $val
			);
			return $this->db->where(array('code'=>$key))->update($data);
		}
		return true;
	}
}

// end