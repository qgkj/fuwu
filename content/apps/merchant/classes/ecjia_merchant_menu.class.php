<?php
  
use Royalcms\Component\Foundation\Royalcms;
use Royalcms\Component\Foundation\Object as RC_Object;
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 商家后台菜单管理
 * @author royalwang
 */
class ecjia_merchant_menu extends RC_Object {

    protected $cacheKey;

    public function __construct()
    {
        if (defined('RC_SITE')) {
            $this->cacheKey = 'merchant_menus' . constant('RC_SITE');
        } else {
            $this->cacheKey = 'merchant_menus';
        }
    }

    /**
     * 获取用户个人导航
     */
    public function admin_navlist() {
        $admin_id = $_SESSION['staff_id'];
        $shortcut = RC_Cache::userdata_cache_get('admin_navlist', $admin_id, true);
        if (empty($shortcut2)) {
            $admin_navlist = RC_Model::model('admin_user_model')->get_nav_list();
            $shortcut = array();
            $i = 0;
            foreach ($admin_navlist as $url => $name) {
                $shortcut[] = ecjia_admin::make_admin_menu('shortcut_' . $i, $name, $url, $i);
                $i++;
            }

            if (!empty($admin_navlist)) {
                $shortcut[] = ecjia_admin::make_admin_menu('divider', '', '', 99);
            }
            $shortcut[] = ecjia_admin::make_admin_menu('shortcut_100', __('设置快捷菜单'), RC_Uri::url('@privilege/modif'), 100);

            RC_Cache::userdata_cache_set('admin_navlist', $shortcut, $admin_id, true);
        }

        return $shortcut;
    }


    /**
     * 后台菜单 （key => value）
     * key: merchant	商家
     * @var array
     */
    public final function admin_menu() {
        // 应用菜单数组
        $menus = $this->load_menu();
        $new_menus = array();
        foreach ($menus as $key => $menu_arr) {
            foreach ($menu_arr as $arr_id => $admin_menu) {
                if ($this->_check_admin_menu_priv($admin_menu)) {
                    if ($admin_menu->has_submenus) {
                        foreach ($admin_menu->submenus() as $sub_id => $sub_menu) {
                            if ($this->_check_admin_menu_priv($sub_menu)) {
                                continue;
                            }
                            $admin_menu->remove_submenu($sub_menu);
                        }
                    }
                    if ($admin_menu->has_submenus && !$admin_menu->has_submenus()) {
                        unset($menu_arr[$arr_id]);
                    }
                    continue;
                }
                unset($menu_arr[$arr_id]);
            }

            $new_menus[$key] = $menu_arr;
             
            // 如果菜单元素长度为0则删除该组
            if (empty($new_menus[$key])) {
                unset($new_menus[$key]);
            }
        }
        unset($menus);

        return $new_menus;
    }

    /**
     * 判断管理员对某一个操作是否有权限。
     *
     * 根据当前对应的action_code，然后再和用户session里面的action_list做匹配，以此来决定是否可以继续执行。
     * @param     string    $priv_str    操作对应的priv_str
     * @return true/false
     */
    public function admin_priv($priv_str) {
        if ($_SESSION['action_list'] == 'all') {
            return true;
        }

        if (strpos(',' . $_SESSION['action_list'] . ',', ',' . $priv_str . ',') === false) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 清除后台菜单缓存
     */
    public function clean_admin_menu_cache() {
        RC_Cache::app_cache_delete($this->cacheKey, 'merchant');
    }

    /**
     * 加载后台菜单
     */
    protected function load_menu()
    {
        $cache_menus = RC_Cache::app_cache_get($this->cacheKey, 'merchant');
        if (! empty($cache_menus)) {
            return $cache_menus;
        }
         
        $apps = ecjia_app::installed_app_floders();

        $menus['merchant'] = $this->_request_admin_menu($apps, 'merchant_menu');

        RC_Cache::app_cache_set($this->cacheKey, $menus, 'merchant');

        return $menus;
    }


    /**
     * 加载后台菜单
     * @param array $apps
     * @param string $menu_name
     */
    private function _request_admin_menu(array $apps, $menu_name) {
        $menus = array();

        foreach ($apps as $app) {
            $menu = RC_Api::api($app, $menu_name);
            if ($menu instanceof admin_menu) {
                $menus[] = $menu;
            } elseif (is_array($menu)) {
                foreach ($menu as $submenu) {
                    if ($submenu instanceof admin_menu) {
                        $menus[] = $submenu;
                    }
                }
            }
        }
        
        usort($menus, array('ecjia_utility', 'admin_menu_by_sort'));
        
        return $menus;
    }

    /**
     * 检查管理员菜单权限
     */
    private function _check_admin_menu_priv(admin_menu $admin_menu) {
        if ($admin_menu->has_purview()) {
            if (is_array($admin_menu->purview())) {
                $boole = false;
                foreach ($admin_menu->purview() as $action) {
                    $boole = $boole || $this->admin_priv($action, '', false);
                }
                 
                return $boole;
            } else {
                if ($this->admin_priv($admin_menu->purview(), '', false)) {
                    return true;
                }
                 
                return false;
            }
        }
        return true;
    }

}

// end