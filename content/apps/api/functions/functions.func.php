<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 设置api session id
 * @param string $session_id session id
 * @return session_id
 */
function set_api_session_id($session_id) {
    if (isset($_POST['json']) && $_POST['json']) {
        $post = json_decode(rc_stripslashes($_POST['json']), true);
    } else {
    	$post = $_POST;
    }
    if (isset($post['session']) && isset($post['session']['sid']) && $post['session']['sid']) {
        return $post['session']['sid'];
    }
    if (isset($post['token'])) {
        return $post['token'];
    }
    return ;
}

RC_Hook::add_filter('ecjia_api_session_id', 'set_api_session_id');

// end