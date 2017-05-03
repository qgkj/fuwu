<?php
  
/**
 * Plugin Installer Skin for ECJia Plugin Installer.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 2.8.0
 */
class ecjia_plugin_installer_skin extends ecjia_upgrader_skin {
    public $api;
    public $type;
    
    function __construct($args = array()) {
        $defaults = array( 'type' => 'web', 'url' => '', 'plugin' => '', 'nonce' => '', 'title' => '' );
        $args = rc_parse_args($args, $defaults);
    
        $this->type = $args['type'];
        $this->api = isset($args['api']) ? $args['api'] : array();
    
        parent::__construct($args);
    }
    
    function before() {
        if ( !empty($this->api) ) {
            $this->upgrader->strings['process_success'] = sprintf( __('Successfully installed the plugin <strong>%s %s</strong>.'), $this->api->name, $this->api->version);
        }
    }
    
    function after() {
    
        $plugin_file = $this->upgrader->plugin_info();
    
        $install_actions = array();
    
        $from = isset($_GET['from']) ? wp_unslash( $_GET['from'] ) : 'plugins';
    
        if ( 'import' == $from )
            $install_actions['activate_plugin'] = '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;from=import&amp;plugin=' . urlencode( $plugin_file ), 'activate-plugin_' . $plugin_file) . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin &amp; Run Importer') . '</a>';
        else
            $install_actions['activate_plugin'] = '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . urlencode( $plugin_file ), 'activate-plugin_' . $plugin_file) . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>';
    
        if ( is_multisite() && current_user_can( 'manage_network_plugins' ) ) {
            $install_actions['network_activate'] = '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;networkwide=1&amp;plugin=' . urlencode( $plugin_file ), 'activate-plugin_' . $plugin_file) . '" title="' . esc_attr__('Activate this plugin for all sites in this network') . '" target="_parent">' . __('Network Activate') . '</a>';
            unset( $install_actions['activate_plugin'] );
        }
    
        if ( 'import' == $from )
            $install_actions['importers_page'] = '<a href="' . admin_url('import.php') . '" title="' . esc_attr__('Return to Importers') . '" target="_parent">' . __('Return to Importers') . '</a>';
        else if ( $this->type == 'web' )
            $install_actions['plugins_page'] = '<a href="' . self_admin_url('plugin-install.php') . '" title="' . esc_attr__('Return to Plugin Installer') . '" target="_parent">' . __('Return to Plugin Installer') . '</a>';
        else
            $install_actions['plugins_page'] = '<a href="' . self_admin_url('plugins.php') . '" title="' . esc_attr__('Return to Plugins page') . '" target="_parent">' . __('Return to Plugins page') . '</a>';
    
        if ( ! $this->result || is_ecjia_error($this->result) ) {
            unset( $install_actions['activate_plugin'], $install_actions['network_activate'] );
        } elseif ( ! current_user_can( 'activate_plugins' ) ) {
            unset( $install_actions['activate_plugin'] );
        }
    
        /**
         * Filter the list of action links available following a single plugin installation.
         *
         * @since 2.7.0
         *
         * @param array  $install_actions Array of plugin action links.
         * @param object $api             Object containing WordPress.org API plugin data. Empty
         *                                for non-API installs, such as when a plugin is installed
         *                                via upload.
         * @param string $plugin_file     Path to the plugin file.
         */
        $install_actions = RC_Hook::apply_filters( 'install_plugin_complete_actions', $install_actions, $this->api, $plugin_file );
    
        if ( ! empty($install_actions) ) {
            $this->feedback(implode(' | ', (array)$install_actions));
        }
    }
    
}


// end