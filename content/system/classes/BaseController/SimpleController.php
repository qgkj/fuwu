<?php
  
namespace Ecjia\System\BaseController;

use \ecjia_view;
use \RC_File;
use \RC_Config;
use \RC_Loader;
use \Smarty;
use \RC_Uri;
use \RC_Response;
use \RC_Hook;
use \RC_Theme;
use \ecjia_app;
use \ecjia_template_fileloader;

class SimpleController extends EcjiaController implements ecjia_template_fileloader
{
    
    public function __construct() {
        parent::__construct();
    
        self::$controller = static::$controller;
        self::$view_object = static::$view_object;

    
        RC_Response::header('Cache-control', 'private');
    
        //title信息
        $this->assign_title();
        
        if (RC_Config::get('system.debug')) {
            error_reporting(E_ALL);
        } else {
            error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        }
    
        RC_Hook::do_action('ecjia_simple_finish_launching');
    }
    
    protected function session_start() {}
    
    public function create_view()
    {
        $view = new ecjia_view($this);
         
        // 模板目录
        $view->setTemplateDir($this->get_template_dir());
        // 编译目录
        $view->setCompileDir(TEMPLATE_COMPILE_PATH . 'front' . DIRECTORY_SEPARATOR);
        // 插件目录
//         $view->setPluginsDir(dirname(dirname($this->get_template_dir())) . '/smarty/');
         
        if (RC_Config::get('system.debug')) {
            $view->caching = Smarty::CACHING_OFF;
            $view->cache_lifetime = 0;
            $view->debugging = true;
            $view->force_compile = true;
        } else {
            $view->caching = Smarty::CACHING_LIFETIME_CURRENT;
            $view->cache_lifetime = 1800;
            $view->debugging = false;
            $view->force_compile = false;
        }
         
        $view->assign('ecjia_charset', RC_CHARSET);
        $view->assign('system_static_url', RC_Uri::system_static_url() . '/');
         
        return $view;
    }
    
        /**
        * 获得前台模板目录
        * @return string
        */
        public function get_template_dir()
        {
            if (RC_Loader::exists_site_app(ROUTE_M)) {
                $dir = SITE_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR;
            } else {
                $dir = RC_APP_PATH . ROUTE_M . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'front' . DIRECTORY_SEPARATOR;
            }
    
            return $dir;
        }
    
        /**
         * 获得前台模版文件
         */
        public function get_template_file($file)
        {
            $style = RC_Theme::get_template();
    
            if (is_null($file)) {
                $file = SITE_THEME_PATH . $style . DIRECTORY_SEPARATOR . ROUTE_M . DIRECTORY_SEPARATOR . ROUTE_C . '_' . ROUTE_A;
            } elseif (! RC_File::is_absolute_path($file)) {
                $file = SITE_THEME_PATH . $style . DIRECTORY_SEPARATOR . $file;
            }
    
            // 添加模板后缀
            if (! preg_match('@\.[a-z]+$@', $file))
                $file .= RC_Config::get('system.tpl_fix');
    
            // 将目录全部转为小写
            if (is_file($file)) {
                return $file;
            } else {
                // 模版文件不存在
                if (RC_Config::get('system.debug'))
                    // TODO:
                    rc_die("Template does not exist.:$file");
                else
                    return null;
            }
        }
    
        public final function display($tpl_file = null, $cache_id = null, $show = true, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
            return parent::display($tpl_file, $cache_id, $show, $options);
        }
    
        public final function fetch($tpl_file = null, $cache_id = null, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront') && ! RC_File::is_absolute_path($tpl_file)) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
            return parent::fetch($tpl_file, $cache_id, $options);
        }
    
        /**
         * 判断是否缓存
         *
         * @access  public
         * @param   string     $tpl_file
         * @param   sting      $cache_id
         *
         * @return  bool
         */
        public final function is_cached($tpl_file, $cache_id = null, $options = array()) {
            if (strpos($tpl_file, 'string:') !== 0) {
                if (RC_File::file_suffix($tpl_file) !== 'php') {
                    $tpl_file = $tpl_file . '.php';
                }
                if (RC_Config::get('system.tpl_usedfront')) {
                    $tpl_file = ecjia_app::get_app_template($tpl_file, ROUTE_M, false);
                }
            }
             
            $is_cached = parent::is_cached($tpl_file, $cache_id, $options);
             
            $purge = royalcms('request')->query('purge', 0);
            $purge = intval($purge);
            if ($is_cached && $purge === 1) {
                parent::clear_cache($tpl_file, $cache_id, $options);
                return false;
            }
            return $is_cached;
        }
    
        /**
         * 直接跳转
         *
         * @param string $url
         * @param int $code
         */
        public function redirect($url, $code = 302) {
            return parent::redirect($url, $code);
        }
    
        /**
         * 信息提示
         *
         * @param string    $msg    提示内容
         * @param string    $url    跳转URL
         * @param int       $time   跳转时间
         * @param null      $tpl    模板文件
         */
        protected function message($msg = '操作成功', $url = null, $time = 2, $tpl = null)
        {
            $url = $url ? "window.location.href='" . $url . "'" : "window.history.back(-1);";
            $front_tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . RC_Config::get('system.tpl_message');
    
            if ($tpl) {
                $this->assign(array(
                    'msg' => $msg,
                    'url' => $url,
                    'time' => $time
                ));
                $tpl = SITE_THEME_PATH . RC_Config::get('system.tpl_style') . DIRECTORY_SEPARATOR . $tpl;
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
        }
    
    
        /**
         * 向模版注册title
         */
        public function assign_title($title = '') {
            $title_suffix = RC_Hook::apply_filters('page_title_suffix', ' ');
            $this->assign('page_title', $title . $title_suffix);
        }
    
    
        protected function load_hooks() {}
}