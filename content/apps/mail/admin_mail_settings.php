<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_mail_settings extends ecjia_admin {
	private $db;
	
	public function __construct() {
		parent::__construct();
		$this->db = RC_Loader::load_model('shop_config_model');
		
		RC_Style::enqueue_style('chosen');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('mail_settings', RC_App::apps_url('statics/js/mail_settings.js', __FILE__));
		
		$mail_settings_jslang = array(
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
		RC_Script::localize_script('mail_settings', 'mail_settings', $mail_settings_jslang );
	
	}
	
	/**
	 * 邮件服务器设置
	 */
	public function init() {
		$this->admin_priv('mail_settings_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('邮件服务器设置')));
		$this->assign('ur_here',      __('邮件服务器设置'));
		$this->assign('ur_heretest',      __('测试邮件'));
		
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
	
		$arr = $this->get_settings(array(5));
		$this->assign('cfg', $arr[5]['vars']);
		
		$this->assign('form_action', RC_Uri::url('mail/admin_mail_settings/update'));
		$this->display('shop_config_mail_settings.dwt');
	}
	
	/**
	 * 商店设置表单提交处理
	 */
	public function update() {
		$this->admin_priv('mail_settings_manage', ecjia::MSGTYPE_JSON);
	
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
	
		/* 记录日志 */
		ecjia_admin::admin_log('', 'edit', 'shop_config');
	
		/* 清除缓存 */
		ecjia_config::instance()->clear_cache();
		ecjia_cloud::instance()->api('product/analysis/record')->data(ecjia_utility::get_site_info())->run();

		ecjia_admin_log::instance()->add_object('maill', '邮件服务器');
		ecjia_admin::admin_log(__('修改邮件服务器设置'), 'edit', 'maill');
		
		$this->showmessage('邮件服务器设置成功。' , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('pjaxurl' => RC_Uri::url('mail/admin_mail_settings/init')));
	}
	
	
	/**
	 * 发送测试邮件
	 */
	public function send_test_email() {
		$this->admin_priv('mail_settings_manage', ecjia::MSGTYPE_JSON);

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
			$this->showmessage(sprintf(__('测试邮件发送失败！%s'), $error->get_error_message()) , ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$this->showmessage(sprintf(__('恭喜！测试邮件已成功发送到 %s。'), $test_mail_address), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
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
}

// end