<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_app {
    
    /**
     * 获取所有安装的应用目录名称
     * @return array
     */
    public static function app_floders() 
    {
        $applications = RC_App::get_apps();
        $app_floders = array();

        foreach ($applications as $app_info) {
            $app_floders[] = $app_info['directory'];
        }

        return $app_floders;
    }
    
    /**
     * 获取所有安装成功的应用目录名称
     * @return array
     */
    public static function installed_app_floders()
    {
        $builtin_bundles = ecjia_app::builtin_bundles();
        $extend_bundles = ecjia_app::extend_bundles();
        $bundles = array_merge($builtin_bundles, $extend_bundles);
        
        $app_floders = array();
        foreach ($bundles as $bundle) {
            $app_floders[] = $bundle['directory'];
        }
        
        return $app_floders;
    }
    
    /**
     * 获取已经安装成功的应用信息
     */
    public static function installed_apps()
    {
        $applications = RC_App::get_apps();
        
        $installed_app_floders = self::installed_app_floders();
        
        $installed_apps = array();
         
        foreach ($applications as $_key => $_value) {
            if (in_array($_value['directory'], $installed_app_floders) ) 
            {
                $installed_apps[$_value['directory']] = RC_App::get_app_package($_value['directory']);
            } 
            else 
            {
                unset($applications[$_key]);
            }
        }

        return $installed_apps;
    }
    
    /**
     * 获取项目内置应用目录名称
     * @return array
     */
    public static function builtin_app_floders() 
    {
        $bundles = ecjia_app::builtin_bundles();
    
        $app_floders = array();
        foreach ($bundles as $bundle) {
            $app_floders[] = $bundle['directory'];
        }
    
        return $app_floders;
    }
    
    
    /**
     * 获取内置应用的bundles数组
     */
    public static function builtin_bundles() 
    {
        $bundles = array();
        $bundles[] = array(
            'identifier' => 'ecjia.system',
            'directory' => 'system',
            'alias' => RC_Config::get('system.admin_entrance')
        );
        
        $core_apps = RC_Hook::apply_filters('ecjia_builtin_app_bundles', RC_Config::get('app'));
        $all_dirs = array_values($core_apps);
        
        $applications = RC_App::get_apps();
        // 只获取内置的系统应用
        foreach ($applications as $app_id => $app_info) {
            if (in_array($app_info['directory'], $all_dirs)) {
                $bundle['identifier'] = $app_info['identifier'];
                $bundle['directory'] = $app_info['directory'];
                $bundle['alias'] = array_search($app_info['directory'], $core_apps);
                $bundles[] = $bundle;
            }
        }
 
        return $bundles;
    }
    
    /**
     * 获取扩展应用的bundles数组
     */
    public static function extend_bundles() {
        $bundles = array();
        $currents = ecjia_config::instance()->get_addon_config('active_applications', true);
        $applications = RC_App::get_apps();
        // 只获取已经安装的扩展应用
        foreach ($currents as $app_id) {
            if (isset($applications[$app_id])) {
                $app_info = $applications[$app_id];
                $bundle['identifier'] = $app_info['identifier'];
                $bundle['directory'] = $app_info['directory'];
                $bundle['alias'] = $app_info['directory'];
                $bundles[] = $bundle;
            }
        }
        
        return $bundles;
    }
    
    
    /**
     * 获取应用的目录名称
     * @param string $app_id
     * @return NULL
     */ 
    public static function get_app_dir($app_id) {
        $applications = RC_App::get_apps();

        if (isset($applications[$app_id])) {
            return $applications[$app_id]['directory'];
        }
        
        return null;
    }
    
    
    
    /**
     * 获取应用模板绝对路径
     */
    public static function get_app_template($path, $app, $is_admin = true) {
        if (RC_Loader::exists_site_app($app)) {
            $realdir = SITE_APP_PATH;
        } else {
            $realdir = RC_APP_PATH;
        }
    
        $tpl_path = $realdir . $app . '/templates/';
        
        if ($is_admin) {
            $tpl_path .= 'admin/';
        } else {
            $tpl_path .= 'front/';
        }
        
        $tpl_path .= $path;
        
        return str_replace('/', DS, $tpl_path);
    }
    
    
    /**
     * Validate the application path.
     *
     * Checks that the file exists and {@link validate_file() is valid file}.
     *
     * @since 1.0.0
     *
     * @param string $appdir Application Path
     * @return ecjia_error|int 0 on success, ecjia_error on failure.
     */
    public static function validate_application($appdir) {
        if ( RC_File::validate_file($appdir) ) {
            return new ecjia_error('application_invalid', __('Invalid application path.'));
        }
            
        if ( ! file_exists(SITE_APP_PATH . '/' . $appdir) && ! file_exists(RC_APP_PATH . '/' . $appdir) ) {
            return new ecjia_error('application_not_found', __('Application file does not exist.'));
        }
            
        if (!RC_App::get_package_data($appdir)) {
            return new ecjia_error('application_package_not_found', __('Application Package info does not exist.'));
        }
        
        return 0;
    }
    
    /**
     * Attempts activation of plugin in a "sandbox" and redirects on success.
     *
     * A plugin that is already activated will not attempt to be activated again.
     *
     * The way it works is by setting the redirection to the error before trying to
     * include the plugin file. If the plugin fails, then the redirection will not
     * be overwritten with the success message. Also, the options will not be
     * updated and the activation hook will not be called on plugin error.
     *
     * It should be noted that in no way the below code will actually prevent errors
     * within the file. The code should not be used elsewhere to replicate the
     * "sandbox", which uses redirection to work.
     * {@source 13 1}
     *
     * If any errors are found or text is outputted, then it will be captured to
     * ensure that the success redirection will update the error redirection.
     *
     * @since 1.0.0
     *
     * @param string $app_id Application ID to main application file with application data.
     * @param bool $silent Prevent calling activation hooks. Optional, default is false.
     * @return ecjia_error|null ecjia_error on invalid file or null on success.
     */
    public static function install_application( $app_id, $silent = false ) {
        $app_dir = self::get_app_dir($app_id);
        
        $application = RC_App::app_basename( trim( $app_dir ) );
    
        $current = ecjia_config::instance()->get_addon_config('active_applications', true);
        $valid = self::validate_application($application);
        if ( is_ecjia_error($valid) )
            return $valid;
       
        if ( !in_array($app_id, $current) ) {
            ob_start();
            $install_class = $app_dir . '_installer';
            $stat = RC_Loader::load_app_class($install_class, $app_dir, false);
            if (!$stat) {
                return new ecjia_error('class_not_found', sprintf(__("Class '%s' not found"), $install_class));
            }
            
            $handle = new $install_class();
           
            if ( ! $silent ) {
                /**
                 * Fires before a plugin is activated.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin       Plugin path to main plugin file with plugin data.
                 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
                 *                             or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'activate_application', $app_id );
                
                $result = $handle->install();
                
                if (is_ecjia_error($result)) {
                    return $result;
                }
            }
    
            //插件安装完成后，更新数据库
            $current[] = $app_id;
            sort($current);
            
            ecjia_config::instance()->set_addon_config('active_applications', $current, true);
    
            if ( ! $silent ) {
                /**
                 * Fires after a plugin has been activated.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param string $plugin       Plugin path to main plugin file with plugin data.
                 * @param bool   $network_wide Whether to enable the plugin for all sites in the network
                 *                             or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'activated_application', $app_id );
            }
    
            if ( ob_get_length() > 0 ) {
                $output = ob_get_clean();
                return new ecjia_error('unexpected_output', __('The plugin generated unexpected output.'), $output);
            }
            ob_end_clean();
        } else {
            return new ecjia_error('application_already_installed', __('应用已经安装，请勿重复安装。'));
        }
    
        return null;
    }
    
    /**
     * Deactivate a single plugin or multiple plugins.
     *
     * The deactivation hook is disabled by the plugin upgrader by using the $silent
     * parameter.
     *
     * @since 1.0.0
     *
     * @param string|array $plugins Single plugin or list of plugins to deactivate.
     * @param bool $silent Prevent calling deactivation hooks. Default is false.
     * @param mixed $network_wide Whether to deactivate the plugin for all sites in the network.
     * 	A value of null (the default) will deactivate plugins for both the site and the network.
     */
    public static function uninstall_application( $app_id, $silent = false ) {
        $current = ecjia_config::instance()->get_addon_config( 'active_applications', true );
        
        $app_dir = self::get_app_dir($app_id);
        
        $application = RC_App::app_basename( trim( $app_dir ) );
        
        if ( ! self::is_active($app_id) ) {
            new ecjia_error('application_not_installed', __('应用未安装！'));
        }

        $install_class = $app_dir . '_installer';
        $stat = RC_Loader::load_app_class($install_class, $app_dir, false);
        if (!$stat) {
            return new ecjia_error('class_not_found', sprintf(__("Class '%s' not found"), $install_class));
        }
        
        $handle = new $install_class();

        if ( ! $silent ) {
            /**
             * Fires before a plugin is deactivated.
             *
             * If a plugin is silently deactivated (such as during an update),
             * this hook does not fire.
             *
             * @since 1.0.0
             *
             * @param string $plugin               Plugin path to main plugin file with plugin data.
             * @param bool   $network_deactivating Whether the plugin is deactivated for all sites in the network
             *                                     or just the current site. Multisite only. Default is false.
             */
            RC_Hook::do_action( 'deactivate_application', $app_id );
        }

        //从数据库中更新插件列表
        $key = array_search( $app_id, $current );
        if ( false !== $key ) {
            unset( $current[ $key ] );
        }
        
        if ( ! $silent ) {            
            $result = $handle->uninstall();
            
            if (is_ecjia_error($result)) {
                return $result;
            }

            /**
             * Fires after a plugin is deactivated.
             *
             * If a plugin is silently deactivated (such as during an update),
             * this hook does not fire.
             *
             * @since 1.0.0
             *
             * @param string $plugin               Plugin basename.
             * @param bool   $network_deactivating Whether the plugin is deactivated for all sites in the network
             *                                     or just the current site. Multisite only. Default false.
            */
            RC_Hook::do_action( 'deactivated_application', $app_id );
        }
    
        ecjia_config::instance()->set_addon_config('active_applications', $current, true);
    }
    
    
    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @since 1.0.0
     *
     * @param string $plugin Base plugin path from plugins directory.
     * @return bool True, if in the active plugins list. False, not in the list.
     */
    public static function is_active( $app_id ) {
        $active_apps = ecjia_config::instance()->get_addon_config('active_applications', true);
        return in_array( $app_id, $active_apps );
    }
    
}


// end