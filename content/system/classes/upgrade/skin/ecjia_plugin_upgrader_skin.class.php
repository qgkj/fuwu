<?php
  
/**
 * Plugin Upgrader Skin for ECJia Plugin Upgrades.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 1.4.0
 */
class ecjia_plugin_upgrader_skin extends ecjia_upgrader_skin {
    
    public $plugin = '';
    public $plugin_active = false;
    public $plugin_network_active = false;
    
    function __construct($args = array()) {
        $defaults = array( 'url' => '', 'plugin' => '', 'nonce' => '', 'title' => __('Update Plugin') );
        $args = rc_parse_args($args, $defaults);
    
        $this->plugin = $args['plugin'];
    
        $this->plugin_active = is_plugin_active( $this->plugin );
        $this->plugin_network_active = is_plugin_active_for_network( $this->plugin );
    
        parent::__construct($args);
    }
    
    function after() {
        $this->plugin = $this->upgrader->plugin_info();
        if ( !empty($this->plugin) && !is_ecjia_error($this->result) && $this->plugin_active ){
            echo '<iframe style="border:0;overflow:hidden" width="100%" height="170px" src="' . wp_nonce_url('update.php?action=activate-plugin&networkwide=' . $this->plugin_network_active . '&plugin=' . urlencode( $this->plugin ), 'activate-plugin_' . $this->plugin) .'"></iframe>';
        }
    
        $this->decrement_update_count( 'plugin' );
    
        $update_actions =  array(
            'activate_plugin' => '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . urlencode( $this->plugin ), 'activate-plugin_' . $this->plugin) . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>',
            'plugins_page' => '<a href="' . self_admin_url('plugins.php') . '" title="' . esc_attr__('Go to plugins page') . '" target="_parent">' . __('Return to Plugins page') . '</a>'
        );
        if ( $this->plugin_active || ! $this->result || is_ecjia_error( $this->result ) || ! current_user_can( 'activate_plugins' ) )
            unset( $update_actions['activate_plugin'] );
    
        /**
         * Filter the list of action links available following a single plugin update.
         *
         * @since 2.7.0
         *
         * @param array  $update_actions Array of plugin action links.
         * @param string $plugin         Path to the plugin file.
        */
        $update_actions = RC_Hook::apply_filters( 'update_plugin_complete_actions', $update_actions, $this->plugin );
    
        if ( ! empty($update_actions) )
            $this->feedback(implode(' | ', (array)$update_actions));
    }
    
}

// end