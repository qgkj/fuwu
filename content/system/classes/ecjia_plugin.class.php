<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_plugin {
    /**
     * Validate the plugin path.
     *
     * Checks that the file exists and {@link validate_file() is valid file}.
     *
     * @since 1.0.0
     *
     * @param string $plugin Plugin Path
     * @return ecjia_error|int 0 on success, ecjia_error on failure.
     */
    public static function validate_plugin($plugin) {
        if ( RC_File::validate_file($plugin) )
            return new ecjia_error('plugin_invalid', __('Invalid plugin path.'));
        if ( ! file_exists(SITE_PLUGIN_PATH . '/' . $plugin) && ! file_exists(RC_PLUGIN_PATH . '/' . $plugin) )
            return new ecjia_error('plugin_not_found', __('Plugin file does not exist.'));
    
        $installed_plugins = RC_Plugin::get_plugins();
        if ( ! isset($installed_plugins[$plugin]) )
            return new ecjia_error('no_plugin_header', __('The plugin does not have a valid header.'));
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
     * @param string $plugin Plugin path to main plugin file with plugin data.
     * @param bool $silent Prevent calling activation hooks. Optional, default is false.
     * @return WP_Error|null WP_Error on invalid file or null on success.
     */
    public static function activate_plugin( $plugin, $silent = false ) {
        $plugin = RC_Plugin::plugin_basename( trim( $plugin ) );
    
        $current = ecjia_config::instance()->get_addon_config('active_plugins', true);
        $valid = self::validate_plugin($plugin);
        if ( is_ecjia_error($valid) )
            return $valid;
        
        if ( !in_array($plugin, $current) ) {
            ob_start();
            RC_Plugin::load_files($plugin);
            
            if ( ! $silent ) {
                $all_plugins = RC_Plugin::get_plugins();
                if ($all_plugins[$plugin]['PluginApp'] == 'system') {
                    $plugin_dir = dirname($plugin);
                    $system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
                    $system_plugins[$plugin_dir] = $plugin;
                    ecjia_config::instance()->set_addon_config('system_plugins', $system_plugins, true);
                }
                
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
                RC_Hook::do_action( 'activate_plugin', $plugin );
    
                /**
                 * Fires as a specific plugin is being deactivated.
                 *
                 * This hook is the "deactivation" hook used internally by
                 * register_deactivation_hook(). The dynamic portion of the
                 * hook name, $plugin. refers to the plugin basename.
                 *
                 * If a plugin is silently activated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param bool $network_wide Whether to enable the plugin for all sites in the network
                 *                           or just the current site. Multisite only. Default is false.
                */
                RC_Hook::do_action( 'activate_' . $plugin );
                
                if (is_ecjia_error(self::$error)) {
                    return self::$error;
                }
            }
    
            //插件安装完成后，更新数据库
            $current[] = $plugin;
            sort($current);
            
            ecjia_config::instance()->set_addon_config('active_plugins', $current, true);
    
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
                RC_Hook::do_action( 'activated_plugin', $plugin );
            }
    
            if ( ob_get_length() > 0 ) {
                $output = ob_get_clean();
                return new ecjia_error('unexpected_output', __('The plugin generated unexpected output.'), $output);
            }
            ob_end_clean();
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
    public static function deactivate_plugins( $plugins, $silent = false ) {
        $current = ecjia_config::instance()->get_addon_config( 'active_plugins', true );
        
        foreach ( (array) $plugins as $plugin ) {
            $plugin = RC_Plugin::plugin_basename( trim( $plugin ) );
            if ( ! self::is_active($plugin) )
                continue;
            
            RC_Plugin::load_files($plugin);
    
            if ( ! $silent ) {
                $all_plugins = RC_Plugin::get_plugins();
                if ($all_plugins[$plugin]['PluginApp'] == 'system') {
                    $plugin_dir = dirname($plugin);
                    $system_plugins = ecjia_config::instance()->get_addon_config('system_plugins', true);
                    unset($system_plugins[$plugin_dir]);
                    ecjia_config::instance()->set_addon_config('system_plugins', $system_plugins, true);
                }
                
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
                RC_Hook::do_action( 'deactivate_plugin', $plugin );
            }
    
            //从数据库中更新插件列表
            $key = array_search( $plugin, $current );
            if ( false !== $key ) {
                unset( $current[ $key ] );
            }
            
            if ( ! $silent ) {
                /**
                 * Fires as a specific plugin is being deactivated.
                 *
                 * This hook is the "deactivation" hook used internally by
                 * register_deactivation_hook(). The dynamic portion of the
                 * hook name, $plugin. refers to the plugin basename.
                 *
                 * If a plugin is silently deactivated (such as during an update),
                 * this hook does not fire.
                 *
                 * @since 1.0.0
                 *
                 * @param bool $network_deactivating Whether the plugin is deactivated for all sites in the network
                 *                                   or just the current site. Multisite only. Default is false.
                 */
                RC_Hook::do_action( 'deactivate_' . $plugin );
                
                if (is_ecjia_error(self::$error)) {
                    return self::$error;
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
                RC_Hook::do_action( 'deactivated_plugin', $plugin );
            }
        }
    
        ecjia_config::instance()->set_addon_config('active_plugins', $current, true);
    }
    
    
    /**
     * Check whether the plugin is active by checking the active_plugins list.
     *
     * @since 1.0.0
     *
     * @param string $plugin Base plugin path from plugins directory.
     * @return bool True, if in the active plugins list. False, not in the list.
     */
    public static function is_active( $plugin ) {
        $active_plugins = ecjia_config::instance()->get_addon_config('active_plugins', true);
        return in_array( $plugin, $active_plugins );
    }
    
    
    private static $error = null;
    
    public static function add_error($code = '', $message = '', $data = '') {
        if (is_null(self::$error)) {
            self::$error = new ecjia_error($code, $message, $data);
        } else {
            self::$error->add($code, $message, $data);
        }
        return self::$error;
    }
    
    public static function get_error() {
        return self::$error;
    }
    
    
    /**
     * 获取模板模板绝对路径
     */
    public static function get_plugin_template($path, $plugin) {
        if (RC_Loader::exists_site_plugin($plugin)) {
            $realdir = SITE_PLUGIN_PATH;
        } else {
            $realdir = RC_PLUGIN_PATH;
        }
    
        $tpl_path = $realdir . $plugin . DS . $path;
    
        return str_replace('/', DS, $tpl_path);
    }
    
}


// end