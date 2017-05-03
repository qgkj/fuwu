<?php
  
/**
 * ecjia 前端页面会员中心控制器父类
 */
defined('IN_ECJIA') or exit('No permission resources.');

abstract class ecjia_user extends ecjia {

	public function __construct() {
		parent::__construct();
		
		
// 		define('SESS_ID', RC_Session::session()->get_session_id());
		
		/* 会员信息 */
// 		$user =& init_users();
		
// 		$GLOBALS['user']= $user;

		
// 		if (!isset($_SESSION['user_id'])) {
// 		    /* 获取投放站点的名称 */
// 		    $site_name = isset($_GET['from'])   ? htmlspecialchars($_GET['from']) : addslashes(RC_Lang::get('system::system.self_site'));
// 		    $from_ad   = !empty($_GET['ad_id']) ? intval($_GET['ad_id']) : 0;
		
// 		    $_SESSION['from_ad'] = $from_ad; // 用户点击的广告ID
// 		    $_SESSION['referer'] = stripslashes($site_name); // 用户来源
		
// 		    unset($site_name);
		
// 		    if (!defined('INGORE_VISIT_STATS')) {
// 		        visit_stats();
// 		    }
// 		}
		
// 		if (empty($_SESSION['user_id'])) {
// 		    if ($user->get_cookie()) {
// 		        /* 如果会员已经登录并且还没有获得会员的帐户余额、积分以及优惠券 */
// 		        if ($_SESSION['user_id'] > 0) {
// 		            update_user_info();
// 		        }
// 		    } else {
// 		        $_SESSION['user_id']     = 0;
// 		        $_SESSION['user_name']   = '';
// 		        $_SESSION['email']       = '';
// 		        $_SESSION['user_rank']   = 0;
// 		        $_SESSION['discount']    = 1.00;
// 		        if (!isset($_SESSION['login_fail'])) {
// 		            $_SESSION['login_fail'] = 0;
// 		        }
// 		    }
// 		}
		
// 		/* 设置推荐会员 */
// 		if (isset($_GET['u'])) {
// 		    set_affiliate();
// 		}
		
// 		/* session 不存在，检查cookie */
// 		if (!empty($_COOKIE['ECS']['user_id']) && !empty($_COOKIE['ECS']['password'])) {
// 		    // 找到了cookie, 验证cookie信息
// 		    $row = $this->db_users->field("user_id, user_name, password")->find("user_id = '" . intval($_COOKIE['ECS']['user_id']) . "' AND password = '" .$_COOKIE['ECS']['password']. "'");
		
// 		    if (!$row) {
// 		        // 没有找到这个记录
// 		        $time = time() - 3600;
// 		        setcookie("ECS[user_id]",  '', $time, '/');
// 		        setcookie("ECS[password]", '', $time, '/');
// 		    } else {
// 		        $_SESSION['user_id'] = $row['user_id'];
// 		        $_SESSION['user_name'] = $row['user_name'];
// 		        update_user_info();
// 		    }
// 		}
		
// 		if (isset($smarty)) {
// 		    $this->assign('ecs_session', $_SESSION);
// 		}
		
// 		$this->verify();

		
		RC_Hook::do_action('ecjia_user_finish_launching');
	}
	
	private function verify() {
		/* 载入语言文件 */
// 		RC_Lang::load('user/user');
		
		$user_id = $_SESSION['user_id'];
// 		$action  = ROUTE_A;
	
// 		$affiliate = unserialize($GLOBALS['_CFG']['affiliate']);
// 		$this->assign('affiliate', $affiliate);
// 		$back_act='';
	
		// 不需要登录的操作或自己验证是否登录（如ajax处理）的act
		$not_login_arr = array(
				'signin',
				'signup',
				'forgotpass',
				
				
				'login',
				'act_login',
				'register',
				'act_register',
				'act_edit_password',
				'get_password',
				'send_pwd_email',
				'password', 
				'signin', 
				'add_tag', 
				'collect', 
				'return_to_cart', 
				'logout', 
				'email_list', 
				'validate_email', 
				'send_hash_mail', 
				'order_query', 
				'is_registered', 
				'check_email',
				'clear_history',
				'qpassword_name', 
				'get_passwd_question', 	
				'check_answer'
		);
	
		/* 显示页面的action列表 */
		$ui_arr = array(
				'init',
				'register', 
				'login', 
				'profile', 
				'order_list', 
				'order_detail', 
				'address_list', 
				'collection_list',
				'message_list', 
				'tag_list', 
				'get_password', 
				'reset_password', 
				'booking_list', 
				'add_booking', 
				'account_raply',
				'account_deposit', 
				'account_log', 
				'account_detail', 
				'act_account', 
				'pay', 
				'default', 
				'bonus', 
				'group_buy', 
				'group_buy_detail', 
				'affiliate', 
				'comment_list',
				'validate_email',
				'track_packages', 
				'transform_points',
				'qpassword_name', 
				'get_passwd_question', 
				'check_answer'
		);
		
		/* 未登录处理 */
		if (empty($_SESSION['user_id'])) {
			if (!in_array($action, $not_login_arr)) {
				if (in_array($action, $ui_arr)) {
					/* 如果需要登录,并是显示页面的操作，记录当前操作，用于登录后跳转到相应操作
					 if ($action == 'login')
					 {
					if (isset($_REQUEST['back_act']))
					{
					$back_act = trim($_REQUEST['back_act']);
					}
					}
					else
					{}*/
					if (!empty($_SERVER['QUERY_STRING'])) {
						$back_act = 'index.php?m=user&' . strip_tags($_SERVER['QUERY_STRING']);
					}
					// 					var_dump($_LANG['sign_up']);die;
// 					header("Location: index.php?m=user&a=login");die;
// 					$action = 'login';

					return $this->redirect('index.php?m=user&c=passport&a=signin');
				} else {
					//未登录提交数据。非正常途径提交数据！
					die($_LANG['require_login']);
				}
			}
		}
	
		/* 如果是显示页面，对页面进行相应赋值 */
		if (in_array($action, $ui_arr)) {
			$this->assign_template();
			$position = assign_ur_here(0, $_LANG['user_center']);
			$this->assign('page_title', $position['title']); // 页面标题
			$this->assign('ur_here',    $position['ur_here']);
// 			$sql = "SELECT value FROM " . $db_shop_config->table() . " WHERE id = 419";
// 			$row = $db_shop_config->getRow($sql);
			
			$car_off =  $this->config->read_config('anonymous_buy'); // $row['value'];
			$this->assign('car_off',       $car_off);
			/* 是否显示积分兑换 */
			if (ecjia::config('points_rule',CONFIG_EXISTS) && unserialize(ecjia::config('points_rule')))
			{
				$this->assign('show_transform_points',     1);
			}
// 			$this->assign('helps',      get_shop_help());        // 网店帮助
			$this->assign('data_dir',   DATA_DIR);   // 数据目录
			$this->assign('action',     $action);
			$this->assign('lang',       $_LANG);
		}
	
	}


    public function display($tpl_file = null, $cache_time = null, $show = true, $options = array()) {
        if (RC_File::file_suffix($tpl_file) !== 'php') {
			$tpl_file = $tpl_file . '.php';
		}
        
        if (RC_Config::system('TPL_USEDFRONT')) {
            $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
        }
        parent::display($tpl_file, $cache_time, $show, $options);
    }
    
    
    public function fetch($tpl_file = null, $cache_time = null, $options = array()) {
        if (RC_File::file_suffix($tpl_file) !== 'php') {
			$tpl_file = $tpl_file . '.php';
		}
		
		if (RC_Config::system('TPL_USEDFRONT')) {
		    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
		}
        return parent::fetch($tpl_file, $cache_time, $options);
    }
    
    
    /**
     * 使用字符串作为模板，获取解析后输出内容
     * @param string $tpl_string
     * @param string $cache_time
     * @param array $options
     * @return mixed
     */
    public function fetch_string($tpl_string = null, $cache_time = null, $options = array()) {
        $tpl_file = null;
    
        if ($tpl_string) {
            $tpl_file = 'string:' . $tpl_string;
        }
        return parent::fetch($tpl_file, $cache_time, $options);
    }
    
    
    /**
     * 信息提示
     *
     * @param string $msg
     *            提示内容
     * @param string $url
     *            跳转URL
     * @param int $time
     *            跳转时间
     * @param null $tpl
     *            模板文件
     */
    protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
    {
        $url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
        $front_tpl = SITE_THEME_PATH . Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . Config::get('system.tpl_message');
    
        if ($tpl) {
            $this->assign(array(
                'msg' => $msg,
                'url' => $url,
                'time' => $time
            ));
            $tpl = SITE_THEME_PATH . Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . $tpl;
            $this->display($tpl);
        } elseif (file_exists($front_tpl)) {
            $this->assign(array(
                'msg' => $msg,
                'url' => $url,
                'time' => $time
            ));
            $this->display($front_tpl);
        } else {
            return parent::message($msg, $url, $time, $tpl);
        }
    
        exit(0);
    }


    protected function load_hooks() {
        RC_Hook::add_action( 'user_head',	'user_enqueue_scripts',	1 );
        RC_Hook::add_action( 'user_head',	'user_print_styles',		8 );
        RC_Hook::add_action( 'user_head',	'user_print_head_scripts',	9 );
        RC_Hook::add_action( 'user_footer',	'user_print_footer_scripts', 20 );
        RC_Hook::add_action( 'user_print_footer_scripts', '_user_footer_scripts');
    
        $apps = ecjia_app::installed_app_floders();
        if (is_array($apps)) {
            foreach ($apps as $app) {
                RC_Loader::load_app_class('hooks.user_' . $app, $app, false);
            }
        }
    }
    
    
}

// end