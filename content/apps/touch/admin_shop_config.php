<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心商店设置
 */
class admin_shop_config extends ecjia_admin {
	private $db;
	private $db_region;
	public function __construct() {
		parent::__construct();

		$this->db = RC_Loader::load_model('shop_config_model');
		$this->db_region = RC_Loader::load_model('region_model');

		RC_Lang::load('shop_config');

		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Style::enqueue_style('bootstrap-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/bootstrap-toggle-buttons.css', array('ecjia'));
		RC_Script::enqueue_script('jquery-toggle-buttons', RC_Uri::admin_url() . '/statics/lib/toggle_buttons/jquery.toggle.buttons.js', array('ecjia-admin'), false, true);
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('smoke');
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('微商城设置'), RC_Uri::url('touch/admin_shop_config/init')));
	}


	/**
	 * 列表编辑
	 */
	public function init() {
		$this->admin_priv('touch_shop_config');

		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('ecjia-shop_config', RC_Uri::admin_url() . '/statics/js/ecjia/ecjia-shop_config.js', array('ecjia-admin'), false, true);

		ecjia_screen::get_current_screen()->remove_last_nav_here();
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('微商城设置')));

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

		$this->assign('ur_here',		__('微商城设置'));
		$this->assign('cfg',			ecjia::config());
		$this->assign('group_list',		$this->get_settings(null, array('1', '2', '3', '4', '5', '6', '7', '8')));
		$this->assign('form_action',	RC_Uri::url('touch/admin_shop_config/update'));
		$this->assign_lang();

		$this->display('shop_config.dwt');
	}

	/**
	 * 商店设置表单提交处理
	 */
	public function update() {
		$this->admin_priv('touch_shop_config', ecjia::MSGTYPE_JSON);

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
				/*是否覆盖文件*/
				$replacefile = in_array($code, array('shop_logo','watermark','wap_logo','no_picture')) ? true : false;

				//删除原有文件
				if ($replacefile) {
					if (RC_Upload::upload_path().file_exists($file_var_list[$code]['value'])) {
// 						@unlink(RC_Upload::upload_path().$file_var_list[$code]['value']);
						$disk = RC_Filesystem::disk();
						$disk->delete(RC_Upload::upload_path() . $file_var_list[$code]['value']);
					}
				}

				/*文件名命名*/
				$save_name = $code == 'icp_file' ? substr($file['name'],0, strrpos($file['name'], '.')) : $code;
				/*判断上传类型*/
				$extname = strtolower(substr($file['name'], strrpos($file['name'], '.') + 1));
				$filetype = $code == 'icp_file' ? (strrpos(RC_Config::load_config('system', 'UPLOAD_FILE_EXT'),$extname)? 'file' : 'image') :'image';
				$upload = RC_Upload::uploader($filetype, array('save_path' => 'data/assets/'.ecjia::config('template'),'save_name'=>$save_name,'replace'=>$replacefile,'auto_sub_dirs' => false));
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
					'type'  => $_POST['invoice_type'],
					'rate'  => $_POST['invoice_rate']
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
		ecjia_cloud::instance()->api('ecjia/record')->data(ecjia_utility::get_site_info())->run();

		$type = !empty($_POST['type']) ? $_POST['type'] : '';

		if ($type == 'mail_setting') {
			$message_info = __('邮件服务器设置成功。');
		} else {
			$message_info = __('保存商店设置成功。');
		}

		return $this->showmessage($message_info , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	 * 删除上传文件
	 */
	public function del() {
		$this->admin_priv('touch_shop_config', ecjia::MSGTYPE_JSON);

		$code     = trim($_GET['code']);
		$img_name = $this->db->where(array('code'=>$code))->get_field('value');
// 		@unlink(RC_Upload::upload_path() . $img_name);
		$disk = RC_Filesystem::disk();
		$disk->delete(RC_Upload::upload_path() . $img_name);
		
		$this->update_configure($code, '');
		ecjia_admin::admin_log('', 'edit', 'shop_config');

		return $this->showmessage(__('保存商店设置成功。') , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/admin_shop_config/init')));
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
		$cfg_name_lang  = RC_Lang::get('touch::shop_config.cfg_name');
		$cfg_desc_lang  = RC_Lang::get('touch::shop_config.cfg_desc');
		$cfg_range_lang = RC_Lang::get('touch::shop_config.cfg_range');

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
				$item['icon'] = $icon_arr[$item['code']];
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
