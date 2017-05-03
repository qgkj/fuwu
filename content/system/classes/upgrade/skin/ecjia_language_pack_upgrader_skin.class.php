<?php
  
/**
 * Translation Upgrader Skin for ECJia Translation Upgrades.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 3.7.0
 */
class ecjia_language_pack_upgrader_skin extends ecjia_upgrader_skin {
    public $language_update = null;
    public $done_header = false;
    public $display_footer_actions = true;
    
    function __construct( $args = array() ) {
        $defaults = array( 'url' => '', 'nonce' => '', 'title' => __( 'Update Translations' ), 'skip_header_footer' => false );
        $args = rc_parse_args( $args, $defaults );
        if ( $args['skip_header_footer'] ) {
            $this->done_header = true;
            $this->display_footer_actions = false;
        }
        parent::__construct( $args );
    }
    
    function before() {
        $name = $this->upgrader->get_name_for_update( $this->language_update );
    
        echo '<div class="update-messages lp-show-latest">';
    
        printf( '<h4>' . __( 'Updating translations for %1$s (%2$s)&#8230;' ) . '</h4>', $name, $this->language_update->language );
    }
    
    function error( $error ) {
        echo '<div class="lp-error">';
        parent::error( $error );
        echo '</div>';
    }
    
    function after() {
        echo '</div>';
    }
    
    function bulk_footer() {
        $this->decrement_update_count( 'translation' );
        $update_actions = array();
        $update_actions['updates_page'] = '<a href="' . self_admin_url( 'update-core.php' ) . '" title="' . esc_attr__( 'Go to WordPress Updates page' ) . '" target="_parent">' . __( 'Return to WordPress Updates' ) . '</a>';
    
        /**
         * Filter the list of action links available following a translations update.
         *
         * @since 3.7.0
         *
         * @param array $update_actions Array of translations update links.
         */
        $update_actions = RC_Hook::apply_filters( 'update_translations_complete_actions', $update_actions );
    
        if ( $update_actions && $this->display_footer_actions )
            $this->feedback( implode( ' | ', $update_actions ) );
    
        parent::footer();
    }
    
}

// end