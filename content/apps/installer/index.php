<?php
  
use Ecjia\System\BaseController\SimpleController;
defined('IN_ECJIA') or exit('No permission resources.');

RC_Package::package('app::installer')->loadClass('install_utility', false);
class index extends SimpleController {
	public function __construct() {
		parent::__construct();

		set_time_limit(60);
		define('DATA_PATH', dirname(__FILE__).'/data/');
		
		/* js与css加载路径*/
  		$this->assign('front_url', RC_App::apps_url('statics/front', __FILE__));
  		$this->assign('system_statics_url', RC_Uri::admin_url('statics'));
  		$this->assign('logo_pic', RC_App::apps_url('statics/front/images/logo_pic.png', __FILE__));

  		$this->assign('version', RC_Config::get('release.version'));
  		$this->assign('build', RC_Config::get('release.build'));
	}

	/**
	 * 欢迎页面加载
	 */
	public function init() {
	    $this->check_installed();
	    
		$this->unset_cookie();
		setcookie('install_step1', 1);
		
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/welcome.dwt', true)
		);
	}
	
	/*
	 * 检查环境页面加载
	 */
	public function detect() {
	    $this->check_installed();
		$this->check_step(2);
		setcookie('install_step2', 1);

		$name = $_SERVER['SCRIPT_NAME'];
		$php_path = '1';
		if ($name != '/index.php') {
			$path_name = substr($name, 0, -9);
			$this->assign('path_error', sprintf(RC_Lang::get('installer::installer.path_error'), $path_name));
			$php_path = '0';
		}
		
		$ok = '<i class="fontello-icon-ok"></i>';
		$cancel = '<i class="fontello-icon-cancel"></i>';
		
		//操作系统
		$os_array = array('Linux', 'FreeBSD', 'WINNT', 'Darwin');
		$sys_info['os'] = PHP_OS;
		
		$php_os = '0';
		if (in_array($sys_info['os'], $os_array)) {
			$php_os = '1';
		}
		$sys_info['os_info'] = $php_os == 1 ? $ok : $cancel;
		
		$sys_info['ip']           	= $_SERVER['SERVER_ADDR'];
		$sys_info['web_server']   	= $_SERVER['SERVER_SOFTWARE'];

		//WEB服务器
		if (stristr($sys_info['web_server'], 'nginx') || stristr($sys_info['web_server'], 'apache') || stristr($sys_info['web_server'], 'iis')) {
			$sys_info['web_server_on'] = '1';
		} else {
			$sys_info['web_server_on'] = '0';
		}
		
		$domain = $_SERVER['SERVER_NAME'];

		$position = strpos($domain, ':'); //查找域名是否带端口号
		if ($position !== false) {
			$domain = substr($domain, 0, $position);
		}
		$domain = strtolower($domain);
		
		$sys_info['php_dns'] 			= preg_match("/^[0-9.]{7,15}$/", @gethostbyname($domain)) ? $ok : $cancel;
		$sys_info['php_ver']            = PHP_VERSION;
		$sys_info['zlib']               = function_exists('gzclose') ? $ok : $cancel;
		$sys_info['safe_mode']          = (boolean) ini_get('safe_mode') ? __('是') : __('否');
		$sys_info['safe_mode_gid']      = (boolean) ini_get('safe_mode_gid') ? $ok : $cancel;
		$sys_info['timezone']           = function_exists("date_default_timezone_get") ? date_default_timezone_get() : __('无需设置');

		//MySQLi
		$php_mysqli = '0';
		if (extension_loaded('mysqli')) $php_mysqli = '1';
		$sys_info['mysqli'] = $php_mysqli == 1 ? $ok : $cancel;
		
		//PDO pdo_mysql
		$php_pdo = '0';
		if (extension_loaded('PDO') && extension_loaded('pdo_mysql')) $php_pdo = '1';
		$sys_info['pdo'] = $php_pdo == 1 ? $ok : $cancel;
		
		//JSON
		$php_json = '0';
		if (extension_loaded('json')) {
			if (function_exists('json_decode') && function_exists('json_encode')) $php_json = '1';
		}
		$sys_info['json'] = $php_json == 1 ? $ok : $cancel;
		
		//openssl
		$php_openssl = '0';
		if (extension_loaded('openssl')) $php_openssl = '1';
		$sys_info['openssl'] = $php_openssl == 1 ? $ok : $cancel;
		
		//socket
		$php_socket = '0';
		if (function_exists('fsockopen')) $php_socket = '1';
		$sys_info['socket'] = $php_socket == 1 ? $ok : $cancel;
		
		//GD
		$php_gd = '0';
		$gd_info = $cancel;
		if (extension_loaded('gd')) {
			$gd_info = $ok;
			$gd_info .= '支持（';
			if (function_exists('imagepng')) $gd_info .= 'png';
			if (function_exists('imagejpeg')) $gd_info .= ' / jpg';
			if (function_exists('imagegif')) $gd_info .= ' / gif';
			$gd_info .= '）';
			
			$php_gd = '1';
		}
		$sys_info['gd'] = $php_gd == 1 ? $gd_info : $cancel;
		$sys_info['gd_info'] = $php_gd == 1 ? $ok : $cancel;
		
		//curl
		$php_curl = '0';
		if (extension_loaded('curl')) $php_curl = '1';
		$sys_info['curl'] = $php_curl == 1 ? $ok : $cancel;
		
		//检测必须开启项是否开启
		$sys_info['is_right'] = $php_path && $php_os && $sys_info['web_server_on'] && version_compare(PHP_VERSION, '5.4.0', 'ge') && $php_mysqli && $php_pdo && $php_json && $php_openssl && $php_socket && $php_gd && $php_curl ? 1 : 0;
		
		//目录检测
		$Upload_Current_Path		= str_replace(SITE_ROOT, '', RC_Upload::upload_path());
		$Cache_Current_Path			= str_replace(SITE_ROOT, '', SITE_CACHE_PATH);
			
		$dir['content/configs']		= str_replace(SITE_ROOT, '', SITE_CONTENT_PATH) . 'configs';
		$dir['content/uploads']		= $Upload_Current_Path;
		$dir['content/storages']	= $Cache_Current_Path;
		$list = array();
		
		$has_unwritable_tpl = 'no';
		/* 检查目录 */
		foreach ($dir AS $key => $val) {
			$mark = RC_File::file_mode_info(SITE_ROOT . $val);
			if ($mark&4 <= 0) {
				$sys_info['is_right'] = 0;
			}
			if ($mark&8 < 1) {
				$has_unwritable_tpl = 'yes';
			}
			$list[] = array('item' => $key . __('目录'), 'r' => $mark&1, 'w' => $mark&2, 'm' => $mark&4);
		}
		$this->assign('list', $list);
		$this->assign('has_unwritable_tpl', $has_unwritable_tpl);
			
		if ($sys_info['is_right'] == 1) {
			setcookie('install_config', 1);
		} elseif ($sys_info['is_right'] == 0) {
			setcookie('install_config', 0);
		}
		
		/* 允许上传的最大文件大小 */
		$sys_info['max_filesize'] = ini_get('upload_max_filesize');
		$filesize = '0';
		if($sys_info['max_filesize'] >= 2){
			$filesize = '1';
		}
		$sys_info['filesize'] = $filesize == 1 ? $ok : $cancel;
		$this->assign('ecjia_version', VERSION);
		$this->assign('ecjia_release', RELEASE);
		$this->assign('sys_info', $sys_info);
		
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/detect.dwt', true)
		);
	}
	
	/**
	 * 配置项目包信息页面加载
	 */
	public function deploy() {
	    $this->check_installed();
		$this->check_step(3);
		setcookie('install_step3', 1);
		
		$installer_lang = 'zh_cn';
		$prefix 		= 'ecjia_';
		$show_timezone 	= 'yes';
		$timezones 		= install_utility::getTimezones($installer_lang);
		
		$this->assign('timezones', $timezones);
		$this->assign('show_timezone', $show_timezone);
		$this->assign('local_timezone', install_utility::getLocalTimezone());
		$this->assign('correct_img', RC_App::apps_url('statics/front/images/correct.png', __FILE__));
		$this->assign('error_img', RC_App::apps_url('statics/front/images/error.png', __FILE__));
		
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/deploy.dwt', true)
		);
	}

	/**
	 * 完成页面
	 */
	public function finish() {
		$result = $this->check_step(4);
		if (!$result) {
			$this->check_installed();
			//安装完成后的一些善后处理
			install_utility::updateInstallDate();
			install_utility::updateEcjiaVersion();
			install_utility::updateHashCode();
			install_utility::updateDemoApiUrl();
			install_utility::createStorageDirectory();
			install_utility::saveInstallLock();
			
			$admin_name 	= RC_Cache::app_cache_get('admin_name', 'install');
			$admin_password	= RC_Cache::app_cache_get('admin_password', 'install');

			$index_url 		= RC_Uri::home_url();
			$h5_url 		= RC_Uri::home_url().'/sites/m/';
			$admin_url      = RC_Uri::home_url().'/sites/admincp/';
			$merchant_url   = RC_Uri::home_url().'/sites/merchant/';

			$this->assign('index_url', $index_url);
			$this->assign('h5_url', $h5_url);
			$this->assign('admin_url', $admin_url);
			$this->assign('merchant_url', $merchant_url);
			$this->assign('admin_name', $admin_name);
			$this->assign('admin_password', $admin_password);
			
			$finish_message = RC_Lang::get('installer::installer.finish_success');
			$this->assign('finish_message', $finish_message);
			
			$this->display(
				RC_Package::package('app::installer')->loadTemplate('front/finish.dwt', true)
			);
		}
	}
	
	/**
	 * 已经安装过的提示页
	 */
	public function installed() {
		$this->unset_cookie();
		
		$finish_message = RC_Lang::get('installer::installer.has_locked_installer_title');
		$locked_message = RC_Lang::get('installer::installer.locked_message');
		$this->assign('finish_message', $finish_message);
		$this->assign('locked_message', $locked_message);
		
		$index_url 		= RC_Uri::home_url();
		$h5_url 		= RC_Uri::home_url().'/sites/m/';
		$admin_url      = RC_Uri::home_url().'/sites/admincp/';
		$merchant_url   = RC_Uri::home_url().'/sites/merchant/';

		$this->assign('index_url', $index_url);
		$this->assign('h5_url', $h5_url);
		$this->assign('admin_url', $admin_url);
		$this->assign('merchant_url', $merchant_url);
		
		if (!file_exists(storage_path() . '/data/install.lock')) {
			return $this->redirect(RC_Uri::url('installer/index/init'));
		}
		
		$this->display(
			RC_Package::package('app::installer')->loadTemplate('front/finish.dwt', true)
		);
	}
	
	/**
	 * 检查数据库密码是否正确
	 */
	public function check_db_correct() {
		$db_host    = isset($_POST['db_host']) ? trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port']) ? trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user']) ? trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass']) ? trim($_POST['db_pass']) : '';
		
		$databases  = install_utility::getDataBases($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($databases)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		$check_version = install_utility::getMysqlVersion($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($check_version)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if (version_compare($check_version, '5.5', '<')) {
			return $this->showmessage(RC_Lang::get('installer::installer.mysql_version_error'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		$check_result = install_utility::checkMysqlSupport($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($check_result)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		foreach ($check_result as $k => $v) {
			if ($v['Variable_name'] == 'have_innodb' && $v['Value'] != 'YES') {
				return $this->showmessage(RC_Lang::get('installer::installer.innodb_not_support'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
			}
		}
		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
		
	/**
	 * 获取数据库列表
	 */
	public function check_db_exists() {
		$db_host    = isset($_POST['db_host']) ? trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port']) ? trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user']) ? trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass']) ? trim($_POST['db_pass']) : '';
		$db_database = isset($_POST['dbdatabase']) ? trim($_POST['dbdatabase']) : '';
		
		$databases  = install_utility::getDataBases($db_host, $db_port, $db_user, $db_pass);
		if (is_ecjia_error($databases)) {
			return $this->showmessage(RC_Lang::get('installer::installer.connect_failed'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			if (in_array($db_database, $databases)) {
				return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('is_exist' => true));
			}
		}
	}
	
	/**
	 * 创建配置文件
	 */
	public function create_config_file() {
		$db_host    = isset($_POST['db_host'])		?   trim($_POST['db_host']) 	: '';
		$db_name    = isset($_POST['db_name'])      ?   trim($_POST['db_name']) 	: '';
		$db_user    = isset($_POST['db_user'])      ?   trim($_POST['db_user']) 	: '';
		$db_pass    = isset($_POST['db_pass'])      ?   trim($_POST['db_pass']) 	: '';
		$prefix     = isset($_POST['db_prefix'])    ?   trim($_POST['db_prefix']) 	: '';
		$timezone   = isset($_POST['timezone'])     ?   trim($_POST['timezone']) 	: 'Asia/Shanghai';
		
		$data = array(
			'DB_HOST' 		=> $db_host,
			'DB_DATABASE' 	=> $db_name,
			'DB_USERNAME' 	=> $db_user,
			'DB_PASSWORD' 	=> $db_pass,
			'DB_PREFIX' 	=> $prefix,
			'TIMEZONE' 		=> $timezone
		);
		
		install_utility::createEnv();
		$result = install_utility::modifyEnv($data);
		 
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 创建数据库
	 */
	public function create_database() {
		$db_host    = isset($_POST['db_host'])      ?   trim($_POST['db_host']) : '';
		$db_port    = isset($_POST['db_port'])      ?   trim($_POST['db_port']) : '';
		$db_user    = isset($_POST['db_user'])      ?   trim($_POST['db_user']) : '';
		$db_pass    = isset($_POST['db_pass'])      ?   trim($_POST['db_pass']) : '';
		$db_name    = isset($_POST['db_name'])      ?   trim($_POST['db_name']) : '';
		
		$result = install_utility::createDatabase($db_host, $db_port, $db_user, $db_pass, $db_name);
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 安装数据库结构
	 */
	public function install_structure() {
	    $sql_files = array(
	        DATA_PATH . 'structure.sql'
	    );
	    	
	    $result = install_utility::installData($sql_files);
	    	
	    if (is_ecjia_error($result)) {
	        return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    } else {
	        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	    }
	}

	/**
	 * 安装基本数据
	 */
	public function install_base_data() {
		$locale = RC_Config::get('system.locale');
			
		if (file_exists(DATA_PATH . 'data_' . $locale . '.sql')) {
			$data_path = DATA_PATH . 'data_' . $locale . '.sql';
		} else {
			$data_path = DATA_PATH . 'data_zh_CN.sql';
		}
		$sql_files = array(
			$data_path
		);
		
		$result = install_utility::installData($sql_files);
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 安装演示数据
	 */
	public function install_demo_data() {
		$data_path = DATA_PATH . 'data_demo_zh_CN.sql';
		
		$sql_files = array(
			$data_path
		);
			
		$result = install_utility::installData($sql_files);
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}

	/**
	 * 创建管理员
	 */
	public function create_admin_passport() {
		$admin_name         = isset($_POST['admin_name'])       ? trim($_POST['admin_name']) 		: '';
		$admin_password     = isset($_POST['admin_password'])   ? trim($_POST['admin_password']) 	: '';
		$admin_password2    = isset($_POST['admin_password2'])  ? trim($_POST['admin_password2']) 	: '';
		$admin_email        = isset($_POST['admin_email'])      ? trim($_POST['admin_email']) 		: '';
		
		RC_Cache::app_cache_set('admin_name', $admin_name, 'install');
		RC_Cache::app_cache_set('admin_password', $admin_password, 'install');
	
		$result = install_utility::createAdminPassport($admin_name, $admin_password, $admin_password2, $admin_email);
		if (is_ecjia_error($result)) {
			return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	}
	
	/**
	 * 检查操作步骤
	 */
	private function check_step($step) {
		if ($step > 1) {
			if (!isset($_COOKIE['install_step1']) || !isset($_COOKIE['agree'])) {
				return $this->redirect(RC_Uri::url('installer/index/init'));
			}
			if ($step > 2) {
				if (!isset($_COOKIE['install_step2']) || $_COOKIE['install_config'] != 1) {
					return $this->redirect(RC_Uri::url('installer/index/detect'));
				} else {
					if ($step > 3) {
						if (!isset($_COOKIE['install_step3']) || !isset($_COOKIE['install_step4'])) {
							return $this->redirect(RC_Uri::url('installer/index/deploy'));
						}
					}
				}
			}
		}
		return false;
	}
	
	/**
	 * 检测是否已安装程序
	 */
	private function check_installed() {
	    /* 初始化流程控制变量 */
	    if (file_exists(storage_path() . '/data/install.lock')) {
	        return $this->redirect(RC_Uri::url('installer/index/installed'));
	    }
	}
	
	/**
	 * 清除流程cookie
	 */
	private function unset_cookie() {
		setcookie('install_step1', '', time()-3600);
		setcookie('install_step2', '', time()-3600);
		setcookie('install_step3', '', time()-3600);
		setcookie('install_step4', '', time()-3600);
		setcookie('install_config', '', time()-3600);
		setcookie('agree', '', time()-3600);
	}
}

//end