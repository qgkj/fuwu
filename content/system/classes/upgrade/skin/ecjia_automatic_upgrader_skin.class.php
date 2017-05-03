<?php
  
/**
 * Upgrader Skin for Automatic ECJia Upgrades
 *
 * This skin is designed to be used when no output is intended, all output
 * is captured and stored for the caller to process and log/email/discard.
 *
 * @package ECJia
 * @subpackage Upgrader
 * @since 3.7.0
 */
class ecjia_automatic_upgrader_skin extends ecjia_upgrader_skin {
    protected $messages = array();
    
    function request_filesystem_credentials( $error = false, $context = '' ) {
        if ( $context ) {
            $this->options['context'] = $context;
        }
        // TODO: fix up request_filesystem_credentials(), or split it, to allow us to request a no-output version
        // This will output a credentials form in event of failure, We don't want that, so just hide with a buffer
        ob_start();
        $result = parent::request_filesystem_credentials( $error );
        ob_end_clean();
    	return $result;
    }
    	
    function get_upgrade_messages() {
        return $this->messages;
    }
    
    function feedback( $data ) {
        if ( is_ecjia_error( $data ) )
            $string = $data->get_error_message();
        else if ( is_array( $data ) )
            return;
        else
            $string = $data;
    
        if ( ! empty( $this->upgrader->strings[ $string ] ) )
            $string = $this->upgrader->strings[ $string ];
    
        if ( strpos( $string, '%' ) !== false ) {
            $args = func_get_args();
            $args = array_splice( $args, 1 );
            if ( ! empty( $args ) )
                $string = vsprintf( $string, $args );
        }
    
        $string = trim( $string );
    
        // Only allow basic HTML in the messages, as it'll be used in emails/logs rather than direct browser output.
        $string = wp_kses( $string, array(
            'a' => array(
                'href' => true
            ),
            'br' => true,
            'em' => true,
            'strong' => true,
        ) );
    
        if ( empty( $string ) )
            return;
    
        $this->messages[] = $string;
    }
    
    function header() {
        ob_start();
    }
    
    function footer() {
        $output = ob_get_contents();
        if ( ! empty( $output ) )
            $this->feedback( $output );
        ob_end_clean();
    }
    
    function bulk_header() {}
    function bulk_footer() {}
    function before() {}
    function after() {}
}

// end